<?php
require_once '../config/DataBase.php';
require_once '../models/Usuario.php';
require_once '../models/Endereco.php';

class UsuarioController {
    private $usuario;
    private $endereco;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->usuario = new Usuario($db);
        $this->endereco = new Endereco($db);
    }
    
    public function emailExists($email) {
        return $this->usuario->emailExists($email);
    }

    public function create($data) {
        try {
            if ($this->usuario->emailExists($data['email'])) {
                throw new Exception("E-mail já cadastrado.");
            }

            $this->usuario->create($data);
            return "Usuário criado com sucesso.";
        } catch (Exception $e) {
            error_log('Erro ao criar usuário: ' . $e->getMessage());
            throw new Exception("Falha ao criar o usuário.");
        }
    }

    public function createEndereco($data, $usuario_id) {
        try {
            $enderecoController = new EnderecoController($this->db);
            return $enderecoController->create($data, $usuario_id);
        } catch (Exception $e) {
            error_log('Erro ao criar o endereço: ' . $e->getMessage());
            throw new Exception("Falha ao criar o endereço.");
        }
    }

    public function update($id, $data) {
        try {
            $this->usuario->update($id, $data);
    
            if (isset($data['endereco'])) {
                $this->usuario->addEnderecoIfNotExists($id, $data['endereco']);
            }
    
            return "Usuário atualizado com sucesso.";
        } catch (Exception $e) {
            error_log('Erro ao atualizar usuário: ' . $e->getMessage());
            throw new Exception("Falha ao atualizar o usuário.");
        }
    }

    public function updateEndereco($usuario_id, $data) {
        try {
            $this->endereco->updateEndereco($usuario_id, $data);
            return "Endereço do usuário atualizado com sucesso.";
        } catch (Exception $e) {
            error_log('Erro ao atualizar endereço do usuário: ' . $e->getMessage());
            throw new Exception("Falha ao atualizar o endereço do usuário.");
        }
    }

    public function delete($id) {
        try {
            $this->endereco->deleteEnderecoPorUsuarioId($id); 
            $this->usuario->delete($id);
        } catch (Exception $e) {
            error_log('Erro ao deletar usuário: ' . $e->getMessage());
            throw new Exception("Falha ao deletar o usuário.");
        }
    }

    public function listar($searchTerm = '', $limit = 8, $offset = 0) {
        try {
            $usuarios = $this->usuario->listar($searchTerm, $limit, $offset);
            $total = $this->usuario->contarUsuarios($searchTerm);
            return [
                'usuarios' => $usuarios,
                'total' => $total
            ];
        } catch (Exception $e) {
            error_log('Erro ao listar usuários: ' . $e->getMessage());
            throw new Exception("Falha ao listar os usuários.");
        }
    }

    public function read($id) {
        try {
            $usuario = $this->usuario->read($id);
            try {
                $endereco = $this->endereco->buscarEnderecoPorUsuarioId($id);
            } catch (Exception $e) {
                $endereco = null;
            }

            return [
                'usuario' => $usuario,
                'endereco' => $endereco
            ];
        } catch (Exception $e) {
            error_log('Erro ao ler usuário: ' . $e->getMessage());
            throw new Exception("Falha ao buscar o usuário.");
        }
    }
}
?>