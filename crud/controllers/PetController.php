<?php
require_once '../models/Pet.php';

class PetController {
    private $petModel;

    public function __construct($db) {
        $this->petModel = new Pet( $db);
    }

    public function cadastrarDoacao($nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $fotos, $usuario_id){
        $pet_id = $this->petModel->insertPet($nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao);
        if (!$pet_id) {
            return "Erro ao cadastrar o pet.";
        }
    
        if (!$this->petModel->uploadFotos($pet_id, $fotos)) {
            return "Erro ao cadastrar as fotos.";
        }
    
        $data_doacao = date('Y-m-d H:i:s');
        if (!$this->petModel->insertDoacao($pet_id, $usuario_id, $data_doacao)) {
            return "Erro ao cadastrar a doação.";
        }
    
        return "Doação cadastrada com sucesso!";
    }

    public function listarDoacoes($searchTerm = '', $limit = 5, $offset = 0){
        return $this->petModel->listarDoacoes($searchTerm, $limit, $offset);
    }

    public function visualizarDoacao($id) {
        $doacao = $this->petModel->visualizarDoacao($id); 
    
        if (!$doacao) {
            return ["error" => "Doação não encontrada."];
        }
        
        return $doacao;
    }

    public function editarDoacao($doacao_id, $nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $fotos){
        //Obter o pet_id da doação
        $doacao = $this->petModel->visualizarDoacao($doacao_id);
        if (!$doacao) {
            return "Doação não encontrada.";
        }
        $pet_id = $doacao['pet_id'];
    
        //Atualizar os dados do pet
        if (!$this->petModel->editarPet($pet_id, $nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao)) {
            return "Erro ao atualizar o pet.";
        }
    
        //Se houver novas fotos, remover as antigas e fazer o upload das novas
        if (!empty($fotos['name'][0])) {
            //Remover fotos antigas
            if (!$this->petModel->removerFotosPet($pet_id)) {
                return "Erro ao remover fotos antigas.";
            }
    
            //Fazer upload das novas fotos
            if (!$this->petModel->uploadFotos($pet_id, $fotos)) {
                return "Erro ao fazer upload das novas fotos.";
            }
        }
    
        return "Doação editada com sucesso!";
    }    

    public function deletarDoacao($id){
        return $this->petModel->deletarDoacao($id);
    }

    public function contarDoacoes($searchTerm = ''){
        return $this->petModel->contarDoacoes($searchTerm);
    }
}
?>