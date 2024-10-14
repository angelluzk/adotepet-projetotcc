<?php
require_once '../models/Usuario.php';

class UsuarioController {
    private $usuario;

    public function __construct($db) {
        $this->usuario = new Usuario($db);
    }

    public function listarUsuarios($searchTerm = '', $limit = 8, $offset = 0){
        return $this->usuario->listar($searchTerm, $limit, $offset);
    }

    public function delete($id){
        $this->usuario->delete($id);
    }

    public function update($id, $data){
        return $this->usuario->update($id, $data);
    }

    public function updateEndereco($usuario_id, $data) {
        return $this->usuario->updateEndereco($usuario_id, $data);
    }

    public function read($id) {
        $usuario = $this->usuario->read($id);
        $endereco = $this->usuario->buscarEnderecoPorUsuarioId($id);
        
        return [
            'usuario' => $usuario,
            'endereco' => $endereco
        ];
    }

    public function create($data){
        $this->usuario->create($data);
    }

    public function contarUsuarios($searchTerm = ''){
        return $this->usuario->contarUsuarios($searchTerm);
    }
    
    public function emailExists($email) {
        return $this->usuario->emailExists($email);
    }
}
?>