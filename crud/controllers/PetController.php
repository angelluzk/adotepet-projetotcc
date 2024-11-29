<?php
require_once '../models/Pet.php';

class PetController
{
    private $petModel;

    public function __construct($db)
    {
        $this->petModel = new Pet($db);
    }

    public function cadastrarDoacao($nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $fotos, $usuario_id, $endereco_id)
    {
        if (!$endereco_id) {
            return "Endereço do usuário não encontrado.";
        }

        $status_id = $this->petModel->getStatusIdByName("Em análise");
        if (!$status_id) {
            return "Status 'Em análise' não encontrado.";
        }

        $pet_id = $this->petModel->insertPet($nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $status_id);
        if (!$pet_id) {
            return "Erro ao cadastrar o pet.";
        }

        if (!$this->petModel->uploadFotos($pet_id, $fotos)) {
            return "Erro ao cadastrar as fotos.";
        }

        $data_doacao = date('Y-m-d H:i:s');
        if (!$this->petModel->insertDoacao($pet_id, $usuario_id, $data_doacao, $endereco_id)) {
            return "Erro ao cadastrar a doação.";
        }
        return "Doação cadastrada com sucesso!";
    }

    public function listarDoacoes($searchTerm = '', $limit = 5, $offset = 0)
    {
        return $this->petModel->listarDoacoes($searchTerm, $limit, $offset);
    }

    public function visualizarDoacao($id)
    {
        $doacao = $this->petModel->visualizarDoacao($id);

        if (!$doacao) {
            return ["error" => "Doação não encontrada."];
        }
        return $doacao;
    }

    public function editarDoacao($id, $nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $status_id, $files)
    {
        $resultado = $this->petModel->editarPet($id, $nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $status_id);

        if ($resultado === "Doação editada com sucesso!") {
            if (isset($files) && !empty($files['name'][0])) {
                $this->petModel->deletarFotos($id);

                if ($this->petModel->uploadFotos($id, $files)) {
                    return ["type" => "success", "text" => "Doação e fotos editadas com sucesso!"];
                } else {
                    return ["type" => "error", "text" => "Doação editada, mas erro ao carregar as fotos. Verifique os arquivos enviados."];
                }
            } else {
                return ["type" => "success", "text" => "Doação editada com sucesso!"];
            }
        }

        return ["type" => "error", "text" => $resultado];
    }

    public function deletarPet($pet_id)
    {
        return $this->petModel->deletarPet($pet_id);
    }

    public function contarDoacoes($searchTerm = '')
    {
        return $this->petModel->contarDoacoes($searchTerm);
    }
}
?>