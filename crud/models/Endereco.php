<?php
class Endereco {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data, $usuario_id) {
        $stmt = $this->db->prepare("INSERT INTO enderecos (cep, logradouro, bairro, localidade, uf, usuario_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $data['cep'], $data['logradouro'], $data['bairro'], $data['localidade'], $data['uf'], $usuario_id);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao inserir endereço: " . $stmt->error);
        }
        
        return true;
    }

    public function buscarEnderecoPorCep($cep) {
        $stmt = $this->db->prepare("SELECT * FROM enderecos WHERE cep = ?");
        $stmt->bind_param("s", $cep);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}
?>