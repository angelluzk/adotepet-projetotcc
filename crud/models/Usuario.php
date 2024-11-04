<?php
require_once '../config/DataBase.php';

class Usuario
{
    private $conn;
    private $table_name = 'usuarios';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function emailExists($email)
    {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    public function usuarioExists($usuario_id)
    {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    public function getLastInsertId()
    {
        return $this->conn->insert_id;
    }

    public function create($data)
    {
        $this->validateUserData($data);

        $query = "INSERT INTO " . $this->table_name . " (nome, sobrenome, cpf, telefone, email, senha, perfil_id, data_nascimento) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }

        $senhaHash = password_hash($data['senha'], PASSWORD_DEFAULT);

        $stmt->bind_param('ssssssss', $data['nome'], $data['sobrenome'], $data['cpf'], $data['telefone'], $data['email'], $senhaHash, $data['perfil_id'], $data['data_nascimento']);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao cadastrar usuário: " . $stmt->error);
        }

        $usuario_id = $this->conn->insert_id;
        $stmt->close();
        return $usuario_id;
    }
    public function update($id, $data)
    {
        $sql = "UPDATE " . $this->table_name . " SET 
                nome = ?, 
                sobrenome = ?, 
                cpf = ?, 
                telefone = ?, 
                email = ?, 
                perfil_id = ?, 
                data_nascimento = ? 
                WHERE id = ?";

        if (!empty($data['senha'])) {
            $sql = "UPDATE " . $this->table_name . " SET 
                    nome = ?, 
                    sobrenome = ?, 
                    cpf = ?, 
                    telefone = ?, 
                    email = ?, 
                    senha = ?, 
                    perfil_id = ?, 
                    data_nascimento = ? 
                    WHERE id = ?";
        }

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }


        if (!empty($data['senha'])) {
            $senhaHash = password_hash($data['senha'], PASSWORD_DEFAULT);

            $stmt->bind_param('ssssssssi', $data['nome'], $data['sobrenome'], $data['cpf'], $data['telefone'], $data['email'], $senhaHash, $data['perfil_id'], $data['data_nascimento'], $id);
        } else {
            $stmt->bind_param('sssssssi', $data['nome'], $data['sobrenome'], $data['cpf'], $data['telefone'], $data['email'], $data['perfil_id'], $data['data_nascimento'], $id);
        }

        if (!$stmt->execute()) {
            throw new Exception("Erro ao atualizar o usuário: " . $stmt->error);
        }

        $stmt->close();
    }

    public function updateEndereco($usuarioId, $data)
    {
        $sql = "UPDATE enderecos SET 
                    cep = ?, 
                    logradouro = ?, 
                    bairro = ?, 
                    localidade = ?, 
                    uf = ?, 
                    estado = ? 
                WHERE usuario_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssssssi', $data['cep'], $data['logradouro'], $data['bairro'], $data['localidade'], $data['uf'], $data['estado'], $usuarioId);

        if (!$stmt->execute()) {
            throw new Exception("Falha ao atualizar o endereço.");
        }
    }

    public function addEnderecoIfNotExists($usuario_id, $data)
    {
        $query = "SELECT COUNT(*) as total FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ((int) $row['total'] === 0) {
            throw new Exception("Usuário com ID $usuario_id não encontrado.");
        }

        $this->validateAddressData($data);
        $query = "INSERT INTO enderecos (usuario_id, cep, logradouro, bairro, localidade, uf, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('issssss', $usuario_id, $data['cep'], $data['logradouro'], $data['bairro'], $data['localidade'], $data['uf'], $data['estado']);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao adicionar endereço: " . $stmt->error);
        }

        $stmt->close();
    }

    public function delete($id)
    {
        $query = "DELETE FROM enderecos WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        $query = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao deletar usuário: " . $this->conn->error);
        }

        $stmt->close();
    }

    public function listar($searchTerm = '', $limit = 8, $offset = 0)
    {
        $likeTerm = '%' . $searchTerm . '%';

        $query = "SELECT u.*, p.nome as perfil_nome, CONCAT(u.nome, ' ', u.sobrenome) as nome_completo 
                  FROM usuarios u 
                  JOIN perfis p ON u.perfil_id = p.id 
                  WHERE 
                    u.id LIKE ? OR 
                    CONCAT(u.nome, ' ', u.sobrenome) LIKE ? OR 
                    u.cpf LIKE ?
                  LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }

        $stmt->bind_param('ssiii', $likeTerm, $likeTerm, $likeTerm, $limit, $offset);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $usuarios;
    }

    public function contarUsuarios($searchTerm = '')
    {
        $likeTerm = '%' . $searchTerm . '%';

        $query = "SELECT COUNT(*) as total 
                  FROM usuarios 
                  WHERE 
                    id LIKE ? OR 
                    CONCAT(nome, ' ', sobrenome) LIKE ? OR 
                    cpf LIKE ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sss', $likeTerm, $likeTerm, $likeTerm);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return (int) $row['total'];
    }

    public function buscarEnderecoPorUsuarioId($usuario_id)
    {
        $query = "SELECT * FROM enderecos WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Nenhum endereço encontrado para o usuário informado.");
        }

        $endereco = $result->fetch_assoc();
        $stmt->close();
        return $endereco;
    }

    public function read($id)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    private function validateUserData($data)
    {
        if (empty($data['nome']) || empty($data['sobrenome']) || empty($data['cpf']) || empty($data['telefone']) || empty($data['email']) || empty($data['senha']) || empty($data['perfil_id']) || empty($data['data_nascimento'])) {
            throw new Exception("Todos os campos devem ser preenchidos.");
        }

        if ($this->emailExists($data['email'])) {
            throw new Exception("O email já está cadastrado.");
        }
    }

    private function validateAddressData($data)
    {
        if (!preg_match('/^\d{8}$/', $data['cep'])) {
            throw new Exception("CEP inválido. Deve conter 8 dígitos numéricos.");
        }

        if (strlen($data['logradouro']) < 3) {
            throw new Exception("Logradouro inválido. Deve conter ao menos 3 caracteres.");
        }
        if (strlen($data['bairro']) < 3) {
            throw new Exception("Bairro inválido. Deve conter ao menos 3 caracteres.");
        }
        if (strlen($data['localidade']) < 3) {
            throw new Exception("Localidade inválida. Deve conter ao menos 3 caracteres.");
        }
        if (strlen($data['uf']) !== 2) {
            throw new Exception("UF inválido. Deve conter 2 caracteres.");
        }
        if (strlen($data['estado']) < 3) {
            throw new Exception("Estado inválido. Deve conter ao menos 3 caracteres.");
        }
    }
}
?>