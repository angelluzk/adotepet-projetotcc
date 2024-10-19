<?php
class Endereco {
    private $conn;
    private $table_name = 'enderecos';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data, $usuario_id) {
        $query = "INSERT INTO " . $this->table_name . " (usuario_id, cep, logradouro, bairro, localidade, uf) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }

        $stmt->bind_param('isssss', $usuario_id, $data['cep'], $data['logradouro'], $data['bairro'], $data['localidade'], $data['uf']);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao cadastrar endereço: " . $stmt->error);
        }

        $stmt->close();
        return $this->conn->insert_id;
    }

    public function updateEndereco($usuario_id, $data) {
        $query = "UPDATE " . $this->table_name . " SET cep = ?, logradouro = ?, bairro = ?, localidade = ?, uf = ? 
                  WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }

        $stmt->bind_param('sssssi', $data['cep'], $data['logradouro'], $data['bairro'], $data['localidade'], $data['uf'], $usuario_id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao atualizar endereço: " . $stmt->error);
        }

        $stmt->close();
    }

    public function deleteEnderecoPorUsuarioId($usuario_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }

        $stmt->bind_param('i', $usuario_id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao deletar endereço: " . $stmt->error);
        }

        $stmt->close();
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

    public function buscarEnderecoPorCep($cep) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE cep = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }

        $stmt->bind_param('s', $cep);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Nenhum endereço encontrado para o CEP informado.");
        }

        $endereco = $result->fetch_assoc();
        $stmt->close();
        return $endereco;
    }
}
?>