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
        $this->conn->begin_transaction();

        try {
            $queryCheckUser = "SELECT id FROM usuarios WHERE id = ?";
            $stmtCheckUser = $this->conn->prepare($queryCheckUser);
            $stmtCheckUser->bind_param('i', $id);
            $stmtCheckUser->execute();
            $resultCheckUser = $stmtCheckUser->get_result();

            if ($resultCheckUser->num_rows === 0) {
                throw new Exception("Usuário com ID $id não encontrado.");
            }
            $stmtCheckUser->close();

            $queryPets = "SELECT pet_id FROM doacoes WHERE usuario_id = ?";
            $stmtPets = $this->conn->prepare($queryPets);
            $stmtPets->bind_param('i', $id);
            $stmtPets->execute();
            $resultPets = $stmtPets->get_result();

            $petIds = [];
            while ($pet = $resultPets->fetch_assoc()) {
                $petIds[] = $pet['pet_id'];
            }
            $stmtPets->close();

            if (!empty($petIds)) {
                $placeholders = implode(',', array_fill(0, count($petIds), '?'));
                $queryFotos = "SELECT url FROM fotos WHERE pet_id IN ($placeholders)";
                $stmtFotos = $this->conn->prepare($queryFotos);
                $stmtFotos->bind_param(str_repeat('i', count($petIds)), ...$petIds);
                $stmtFotos->execute();
                $resultFotos = $stmtFotos->get_result();

                while ($foto = $resultFotos->fetch_assoc()) {
                    $fotoUrl = $foto['url'];

                    $queryDeleteFotos = "DELETE FROM fotos WHERE pet_id = ?";
                    $stmtDeleteFotos = $this->conn->prepare($queryDeleteFotos);
                    $stmtDeleteFotos->bind_param('i', $pet['pet_id']);
                    $stmtDeleteFotos->execute();
                    $stmtDeleteFotos->close();

                    $fotoPath = '../../uploads/' . $fotoUrl;
                    if (file_exists($fotoPath)) {
                        unlink($fotoPath);
                    }
                }
                $stmtFotos->close();
            }

            $queryDoacoes = "DELETE FROM doacoes WHERE usuario_id = ?";
            $stmtDoacoes = $this->conn->prepare($queryDoacoes);
            $stmtDoacoes->bind_param('i', $id);
            if (!$stmtDoacoes->execute()) {
                throw new Exception("Erro ao deletar doações: " . $stmtDoacoes->error);
            }
            $stmtDoacoes->close();

            if (!empty($petIds)) {
                $placeholdersPets = implode(',', array_fill(0, count($petIds), '?'));
                $queryDeletePets = "DELETE FROM pets WHERE id IN ($placeholdersPets)";
                $stmtDeletePets = $this->conn->prepare($queryDeletePets);
                $stmtDeletePets->bind_param(str_repeat('i', count($petIds)), ...$petIds);
                if (!$stmtDeletePets->execute()) {
                    throw new Exception("Erro ao deletar pets: " . $stmtDeletePets->error);
                }
                $stmtDeletePets->close();
            }

            $queryDeleteUsuario = "DELETE FROM usuarios WHERE id = ?";
            $stmtDeleteUsuario = $this->conn->prepare($queryDeleteUsuario);
            $stmtDeleteUsuario->bind_param('i', $id);
            if (!$stmtDeleteUsuario->execute()) {
                throw new Exception("Erro ao deletar usuário: " . $stmtDeleteUsuario->error);
            }
            $stmtDeleteUsuario->close();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Erro na deleção: " . $e->getMessage());
            throw $e;
        }
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
        $data['cpf'] = preg_replace('/\D/', '', $data['cpf']);
        $data['telefone'] = preg_replace('/\D/', '', $data['telefone']);

        if (empty($data['nome']) || empty($data['sobrenome']) || empty($data['cpf']) || empty($data['telefone']) || empty($data['email']) || empty($data['senha']) || empty($data['perfil_id']) || empty($data['data_nascimento'])) {
            throw new Exception("Todos os campos devem ser preenchidos.");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("O e-mail fornecido não é válido.");
        }

        if (!preg_match('/^\d{11}$/', $data['cpf'])) {
            throw new Exception("O CPF deve conter 11 dígitos numéricos.");
        }

        if (!preg_match('/^\d{10,11}$/', $data['telefone'])) {
            throw new Exception("O telefone deve conter 10 ou 11 dígitos numéricos.");
        }

        if ($this->emailExists($data['email'])) {
            throw new Exception("O e-mail já está cadastrado.");
        }
    }

    private function validateAddressData($data)
    {
        if (empty($data['cep']) || empty($data['logradouro']) || empty($data['bairro']) || empty($data['localidade']) || empty($data['uf']) || empty($data['estado'])) {
            throw new Exception("Todos os campos do endereço devem ser preenchidos.");
        }

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