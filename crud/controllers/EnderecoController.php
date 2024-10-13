<?php
require_once '../config/DataBase.php';
require_once '../models/Endereco.php';

class EnderecoController {
    private $endereco;

    public function __construct($db) {
        $this->endereco = new Endereco($db);
    }

    public function create($data, $usuario_id) {
        try {
            return $this->endereco->create($data, $usuario_id);
        } catch (Exception $e) {
            error_log('Erro ao criar o endereço: ' . $e->getMessage());
            throw new Exception("Falha ao criar o endereço.");
        }
    }

    public function buscarEnderecoPorCep($cep) {
        return $this->endereco->buscarEnderecoPorCep($cep);
    }
}
?>