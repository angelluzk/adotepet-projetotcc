<?php
require_once '../config/DataBase.php';

class Usuario {
    private $conn;
    private $table_name = 'usuarios';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        return $stmt->num_rows > 0;
    }

    public function create($data) {
        $this->validateUserData($data);

        $query = "INSERT INTO usuarios (nome, sobrenome, cpf, telefone, email, senha, perfil_id, data_nascimento) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }

        $stmt->bind_param('ssssssss', $data['nome'], $data['sobrenome'], $data['cpf'], $data['telefone'], $data['email'], $data['senha'], $data['perfil'], $data['data_nascimento']);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao cadastrar usuário: " . $stmt->error);
        }

        $stmt->close();
    }

    public function update($id, $data) {
        $this->validateUserData($data);
    
        // Inicia a query de atualização
        $query = "UPDATE " . $this->table_name . " SET nome = ?, sobrenome = ?, cpf = ?, telefone = ?, email = ?, perfil_id = ?, data_nascimento = ?";
    
        // Verifica se a senha foi fornecida e adiciona a coluna na query, se necessário
        if (!empty($data['senha'])) {
            // Criptografa a senha
            $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
            $query .= ", senha = ?";
        }
    
        // Adiciona a condição WHERE para a atualização
        $query .= " WHERE id = ?";
    
        // Prepara a instrução SQL
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }
    
        // Define os parâmetros com ou sem senha
        if (!empty($data['senha'])) {
            // Com senha
            $stmt->bind_param(
                'ssssssssi',
                $data['nome'],
                $data['sobrenome'],
                $data['cpf'],
                $data['telefone'],
                $data['email'],
                $data['perfil'],
                $data['data_nascimento'],
                $data['senha'],
                $id
            );
        } else {
            // Sem senha
            $stmt->bind_param(
                'sssssssi',
                $data['nome'],
                $data['sobrenome'],
                $data['cpf'],
                $data['telefone'],
                $data['email'],
                $data['perfil'],
                $data['data_nascimento'],
                $id
            );
        }
    
        // Executa a instrução
        if (!$stmt->execute()) {
            throw new Exception("Erro ao atualizar usuário: " . $stmt->error);
        }
    
        // Fecha o statement
        $stmt->close();
    }

    public function updateEndereco($usuario_id, $data) {
        $this->validateAddressData($data);

        $query = "UPDATE enderecos SET cep = ?, logradouro = ?, bairro = ?, localidade = ?, uf = ? WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sssssi', $data['cep'], $data['logradouro'], $data['bairro'], $data['localidade'], $data['uf'], $usuario_id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao atualizar endereço: " . $stmt->error);
        }

        $stmt->close();
    }

    public function addEnderecoIfNotExists($usuario_id, $data) {
        // Verifica se o usuário já possui um endereço
        $query = "SELECT COUNT(*) as total FROM enderecos WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ((int)$row['total'] === 0) {
            // O usuário não possui um endereço, então vamos adicioná-lo
            $this->validateAddressData($data);
            $query = "INSERT INTO enderecos (usuario_id, cep, logradouro, bairro, localidade, uf) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('isssss', $usuario_id, $data['cep'], $data['logradouro'], $data['bairro'], $data['localidade'], $data['uf']);
            
            if (!$stmt->execute()) {
                throw new Exception("Erro ao adicionar endereço: " . $stmt->error);
            }
    
            $stmt->close();
        }
    }

    public function delete($id) {
        $query = "DELETE FROM enderecos WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $query = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao deletar usuário: " . $this->conn->error);
        }

        $stmt->close();
    }

    public function listar($searchTerm = '', $limit = 8, $offset = 0) {
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

    public function contarUsuarios($searchTerm = '') {
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

    public function buscarEnderecoPorUsuarioId($usuario_id) {
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

    public function read($id) {
        $query = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } else {
            throw new Exception("Erro na consulta: " . $this->conn->error);
        }
    }

    private function validateUserData($data) {
        if (empty($data['nome']) || strlen($data['nome']) < 3) {
            throw new Exception("Nome inválido. Deve conter ao menos 3 caracteres.");
        }
        if (empty($data['sobrenome']) || strlen($data['sobrenome']) < 3) {
            throw new Exception("Sobrenome inválido. Deve conter ao menos 3 caracteres.");
        }
        if (empty($data['cpf']) || !preg_match('/^\d{11}$/', $data['cpf'])) {
            throw new Exception("CPF inválido. Deve conter 11 dígitos numéricos.");
        }
        if (empty($data['telefone']) || !preg_match('/^\d{10,11}$/', $data['telefone'])) {
            throw new Exception("Telefone inválido. Deve conter 10 ou 11 dígitos numéricos.");
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido.");
        }
        if (empty($data['data_nascimento']) || !DateTime::createFromFormat('Y-m-d', $data['data_nascimento'])) {
            throw new Exception("Data de nascimento inválida. Formato deve ser YYYY-MM-DD.");
        }
        if (empty($data['perfil'])) {
            throw new Exception("Perfil é obrigatório.");
        }
    }

    private function validateAddressData($data) {
        if (empty($data['cep']) || !preg_match('/^\d{8}$/', $data['cep'])) {
            throw new Exception("CEP inválido. Deve conter 8 dígitos numéricos.");
        }
        if (empty($data['logradouro']) || strlen($data['logradouro']) < 3) {
            throw new Exception("Logradouro inválido. Deve conter ao menos 3 caracteres.");
        }
        if (empty($data['bairro']) || strlen($data['bairro']) < 3) {
            throw new Exception("Bairro inválido. Deve conter ao menos 3 caracteres.");
        }
        if (empty($data['localidade']) || strlen($data['localidade']) < 3) {
            throw new Exception("Localidade inválida. Deve conter ao menos 3 caracteres.");
        }
        if (empty($data['uf']) || strlen($data['uf']) !== 2) {
            throw new Exception("UF inválido. Deve conter 2 caracteres.");
        }
    }
}
?>