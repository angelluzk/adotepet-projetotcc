<?php
require_once '../config/DataBase.php';
require_once '../models/Endereco.php';
require_once '../models/Usuario.php';

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
        try {
            return $this->endereco->buscarEnderecoPorCep($cep);
        } catch (Exception $e) {
            error_log('Erro ao buscar endereço por CEP: ' . $e->getMessage());
            throw new Exception("Falha ao buscar o endereço.");
        }
    }

    public function update($usuario_id, $data) {
        try {
            $this->endereco->updateEndereco($usuario_id, $data);
            return "Endereço atualizado com sucesso.";
        } catch (Exception $e) {
            error_log('Erro ao atualizar endereço: ' . $e->getMessage());
            throw new Exception("Falha ao atualizar o endereço.");
        }
    }

    public function delete($usuario_id) {
        try {
            $this->endereco->deleteEnderecoPorUsuarioId($usuario_id);
            return "Endereço deletado com sucesso.";
        } catch (Exception $e) {
            error_log('Erro ao deletar endereço: ' . $e->getMessage());
            throw new Exception("Falha ao deletar o endereço.");
        }
    }
}
?>