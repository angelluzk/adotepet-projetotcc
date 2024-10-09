<?php
require_once '../config/DataBase.php';

class Pet
{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertPet($especie_id, $raca, $cor, $idade, $descricao)
{
    $sql_pet = "INSERT INTO pets (especie_id, raca, cor, idade, descricao) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql_pet);
    $stmt->bind_param("issss", $especie_id, $raca, $cor, $idade, $descricao);

    if ($stmt->execute()) {
        return $stmt->insert_id;
    }
    return false;
}


    public function editarPet($pet_id, $especie_id, $raca, $cor, $idade, $descricao)
    {
        $sql = "UPDATE pets SET especie_id = ?, raca = ?, cor = ?, idade = ?, descricao = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issssi", $especie_id, $raca, $cor, $idade, $descricao, $pet_id);

        return $stmt->execute();
    }

    public function uploadFotos($pet_id, $fotos)
    {
        if (is_null($fotos) || count($fotos['name']) === 0) {
            return true;
        }

        $target_dir = "../../uploads/";
        $uploadedFiles = [];

        for ($i = 0; $i < count($fotos['name']); $i++) {
            if ($fotos['error'][$i] === UPLOAD_ERR_OK) {
                $target_file = $target_dir . basename($fotos['name'][$i]);
                $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if (in_array($file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    if (move_uploaded_file($fotos['tmp_name'][$i], $target_file)) {
                        $sql_foto = "INSERT INTO fotos (nome, url, pet_id) VALUES (?, ?, ?)";
                        $stmt = $this->conn->prepare($sql_foto);
                        $url = 'uploads/' . basename($fotos['name'][$i]);
                        $stmt->bind_param("ssi", $fotos['name'][$i], $url, $pet_id);

                        if ($stmt->execute()) {
                            $uploadedFiles[] = $stmt->insert_id;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        return count($uploadedFiles) > 0;
    }

    public function insertDoacao($pet_id, $usuario_id, $data_doacao)
    {
        $sql_doacao = "INSERT INTO doacoes (pet_id, usuario_id, data) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql_doacao);
        $stmt->bind_param("iis", $pet_id, $usuario_id, $data_doacao);
        return $stmt->execute();
    }

    public function listarDoacoes($searchTerm = '', $limit = 8, $offset = 0) {
        $sql = "SELECT d.id, p.id AS pet_id, p.raca, p.cor, p.idade, d.data, e.nome AS especie_nome, 
                       u.nome AS usuario_nome, u.sobrenome AS usuario_sobrenome
                FROM doacoes d 
                JOIN pets p ON d.pet_id = p.id
                JOIN especie e ON p.especie_id = e.id
                JOIN usuarios u ON d.usuario_id = u.id
                WHERE (p.raca LIKE ? OR p.cor LIKE ? OR p.id LIKE ? OR u.nome LIKE ? OR e.nome LIKE ?)
                ORDER BY d.data DESC
                LIMIT ? OFFSET ?";  
            
        $stmt = $this->conn->prepare($sql);
        
        $likeTerm = '%' . $searchTerm . '%';
        $stmt->bind_param("sssssii", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $limit, $offset);
        
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function visualizarDoacao($doacao_id){
        $sql = "SELECT d.id AS doacao_id, 
                       p.id AS pet_id, 
                       p.especie_id, 
                       p.raca, 
                       p.cor, 
                       p.idade, 
                       p.descricao, 
                       d.data, 
                       u.nome AS usuario_nome, 
                       u.sobrenome AS usuario_sobrenome,
                       f.url AS foto_url
                FROM doacoes d 
                JOIN pets p ON d.pet_id = p.id 
                JOIN usuarios u ON d.usuario_id = u.id 
                LEFT JOIN fotos f ON p.id = f.pet_id 
                WHERE d.id = ? 
                LIMIT 1";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $doacao_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function removerFotosPet($pet_id)
    {
        $sql_delete_fotos = "DELETE FROM fotos WHERE pet_id = ?";
        $stmt = $this->conn->prepare($sql_delete_fotos);
        $stmt->bind_param("i", $pet_id);
        return $stmt->execute();
    }

    public function deletarDoacao($id)
    {
        $sql_get_pet_id = "SELECT pet_id FROM doacoes WHERE id = ?";
        $stmt = $this->conn->prepare($sql_get_pet_id);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $doacao = $result->fetch_assoc();
        $pet_id = $doacao['pet_id'];

        if (!$pet_id) {
            return false;
        }

        $sql_delete_doacao = "DELETE FROM doacoes WHERE id = ?";
        $stmt = $this->conn->prepare($sql_delete_doacao);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $this->removerFotosPet( $pet_id);
            return true;
        }

        return false;
    }

    public function contarDoacoes($searchTerm = '') {
        $sql = "SELECT COUNT(*) as total FROM doacoes d 
                JOIN pets p ON d.pet_id = p.id 
                WHERE (p.raca LIKE ? OR p.cor LIKE ?)";
        
        $stmt = $this->conn->prepare($sql);
        $likeTerm = '%' . $searchTerm . '%';
        $stmt->bind_param("ss", $likeTerm, $likeTerm);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>