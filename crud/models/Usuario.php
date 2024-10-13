<?php
require_once '../config/DataBase.php';

class Usuario {
    private $conn;

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
        $query = "INSERT INTO usuarios (nome, sobrenome, cpf, telefone, email, senha, perfil_id, data_nascimento) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        error_log("Dados do usuário: " . json_encode($data));
    
        $stmt->bind_param('ssssssss', $data['nome'], $data['sobrenome'], $data['cpf'], $data['telefone'], $data['email'], $data['senha'], $data['perfil'], $data['data_nascimento']);
        
        if (!$stmt->execute()) {
            error_log("Erro ao cadastrar usuário: " . $this->conn->error);
            die("Erro ao cadastrar usuário.");
        }
    }   

    public function update($id, $data) {
        $query = "UPDATE usuarios SET nome = ?, sobrenome = ?, cpf = ?, telefone = ?, email = ?, senha = ?, perfil_id = ?, data_nascimento = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssssssisi', $data['nome'], $data['sobrenome'], $data['cpf'], $data['telefone'], $data['email'], $data['senha'], $data['perfil'], $data['data_nascimento'], $id);
    
        if (!$stmt->execute()) {
            die("Erro ao atualizar usuário: " . $this->conn->error);
        }
    }

    public function delete($id) {
        $query = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            die("Erro ao deletar usuário: " . $this->conn->error);
        }
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
    
        $stmt->bind_param('ssiii', $likeTerm, $likeTerm, $likeTerm, $limit, $offset);

        if (!$stmt->execute()) {
            die("Erro ao executar a consulta: " . $stmt->error);
        }
    
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
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

    public function read($id) {
        $query = "SELECT u.*, p.nome as perfil_nome FROM usuarios u JOIN perfis p ON u.perfil_id = p.id WHERE u.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            die("Erro ao executar a consulta: " . $stmt->error);
        }

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }   
}
?>