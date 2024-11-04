<?php
require_once '../config/DataBase.php';

class Endereco
{
    private $conn;
    private $table_name = 'enderecos';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($data, $usuario_id)
    {
        $query = "INSERT INTO " . $this->table_name . " (usuario_id, cep, logradouro, bairro, localidade, uf, estado) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }

        $stmt->bind_param('issssss', $usuario_id, $data['cep'], $data['logradouro'], $data['bairro'], $data['localidade'], $data['uf'], $data['estado']);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao cadastrar endereço: " . $stmt->error);
        }

        $stmt->close();
        return $this->conn->insert_id;
    }

    public function getEnderecoIdByUsuarioId($usuario_id)
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $endereco = $result->fetch_assoc();
            return $endereco['id'];
        }

        throw new Exception("Endereço não encontrado para o usuário informado.");
    }

    public function updateEndereco($usuario_id, $data)
    {
        $query = "UPDATE " . $this->table_name . " SET cep = ?, logradouro = ?, bairro = ?, localidade = ?, uf = ?, estado = ? 
                  WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a consulta: " . $this->conn->error);
        }

        $stmt->bind_param('ssssssi', $data['cep'], $data['logradouro'], $data['bairro'], $data['localidade'], $data['uf'], $data['estado'], $usuario_id);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao atualizar endereço: " . $stmt->error);
        }

        $endereco_id = $this->getEnderecoIdByUsuarioId($usuario_id);


        $queryDoacao = "UPDATE doacoes SET endereco_id = ? WHERE usuario_id = ?";
        $stmtDoacao = $this->conn->prepare($queryDoacao);

        if (!$stmtDoacao) {
            throw new Exception("Erro ao preparar a consulta para atualizar doações: " . $this->conn->error);
        }

        $stmtDoacao->bind_param('ii', $endereco_id, $usuario_id);

        if (!$stmtDoacao->execute()) {
            throw new Exception("Erro ao atualizar doações: " . $stmtDoacao->error);
        }

        $stmt->close();
        $stmtDoacao->close();
    }

    public function deleteEnderecoPorUsuarioId($usuario_id)
    {
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

    public function buscarEnderecoPorCep($cep)
    {
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