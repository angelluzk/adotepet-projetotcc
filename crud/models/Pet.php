<?php
require_once '../config/DataBase.php';

class Pet
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function insertPet($nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $status_id)
    {
        $sql_pet = "INSERT INTO pets (nome, especie_id, raca, porte, sexo, cor, idade, descricao, status_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql_pet);
        $stmt->bind_param("sissssssi", $nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $status_id);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }

    public function getStatusIdByName($status_name)
    {
        $sql = "SELECT id FROM status WHERE nome = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $status_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc()['id'];
        }
        return false;
    }


    public function editarPet($pet_id, $nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $status_id)
    {
        $sqlValidarStatus = "SELECT id FROM status WHERE id = ?";
        $stmtValidar = $this->conn->prepare($sqlValidarStatus);
        $stmtValidar->bind_param("i", $status_id);
        $stmtValidar->execute();
        $stmtValidar->store_result();

        if ($stmtValidar->num_rows === 0) {
            return "Status inválido.";
        }

        $sql = "UPDATE pets 
            SET nome = ?, especie_id = ?, raca = ?, porte = ?, sexo = ?, cor = ?, idade = ?, descricao = ?, status_id = ? 
            WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return "Erro na preparação da consulta: " . $this->conn->error;
        }

        $stmt->bind_param(
            "sissssissi",
            $nome,
            $especie_id,
            $raca,
            $porte,
            $sexo,
            $cor,
            $idade,
            $descricao,
            $status_id,
            $pet_id
        );

        if ($stmt->execute()) {
            return "Doação editada com sucesso!";
        } else {
            return "Erro ao editar pet: " . $stmt->error;
        }
    }

    public function deletarFotos($pet_id)
    {
        $sql = "SELECT url FROM fotos WHERE pet_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $pet_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $fotosParaDeletar = [];
        while ($foto = $result->fetch_assoc()) {
            $fotosParaDeletar[] = $foto['url'];
        }

        $sqlDelete = "DELETE FROM fotos WHERE pet_id = ?";
        $stmtDelete = $this->conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $pet_id);
        $stmtDelete->execute();

        foreach ($fotosParaDeletar as $fotoUrl) {
            $caminhoFoto = "../../" . $fotoUrl;
            if (file_exists($caminhoFoto)) {
                unlink($caminhoFoto);
            }
        }
    }

    public function uploadFotos($pet_id, $fotos)
    {
        if (empty($fotos) || count($fotos['name']) === 0) {
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

    public function insertDoacao($pet_id, $usuario_id, $data_doacao, $endereco_id)
    {
        $sql_doacao = "INSERT INTO doacoes (pet_id, usuario_id, data, endereco_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql_doacao);
        $stmt->bind_param("iisi", $pet_id, $usuario_id, $data_doacao, $endereco_id);
        return $stmt->execute();
    }

    public function listarDoacoes($searchTerm = '', $limit = 8, $offset = 0)
    {
        $sql = "SELECT d.id, 
                    p.id AS pet_id, 
                    p.nome AS nome_pet, 
                    p.raca, 
                    p.porte, 
                    p.sexo, 
                    p.cor, 
                    p.idade, 
                    s.nome AS status_nome, 
                    e.nome AS especie_nome, 
                    u.nome AS usuario_nome, 
                    u.sobrenome AS usuario_sobrenome
            FROM doacoes d 
            JOIN pets p ON d.pet_id = p.id
            JOIN especie e ON p.especie_id = e.id
            JOIN usuarios u ON d.usuario_id = u.id
            JOIN status s ON p.status_id = s.id
            WHERE (p.raca LIKE ? OR p.cor LIKE ? OR p.id LIKE ? OR u.nome LIKE ? OR e.nome LIKE ? OR p.nome LIKE ?)
            ORDER BY d.data DESC
            LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($sql);

        $likeTerm = '%' . $searchTerm . '%';
        $stmt->bind_param("ssssssii", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $limit, $offset);

        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function visualizarDoacao($doacao_id)
    {
        $sql = "SELECT d.id AS doacao_id, 
                       p.id AS pet_id, 
                       p.nome, 
                       p.especie_id, 
                       p.raca, 
                       p.porte, 
                       p.sexo, 
                       p.cor, 
                       p.idade, 
                       p.descricao, 
                       p.status_id, 
                       s.nome AS status_nome, 
                       d.data, 
                       u.nome AS usuario_nome, 
                       u.sobrenome AS usuario_sobrenome,
                       e.nome AS especie_nome,
                       f.url AS foto_url
                FROM doacoes d 
                JOIN pets p ON d.pet_id = p.id 
                JOIN usuarios u ON d.usuario_id = u.id 
                LEFT JOIN fotos f ON p.id = f.pet_id 
                LEFT JOIN especie e ON p.especie_id = e.id
                LEFT JOIN status s ON p.status_id = s.id
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
        $sql_select_fotos = "SELECT url FROM fotos WHERE pet_id = ?";
        $stmt = $this->conn->prepare($sql_select_fotos);
        $stmt->bind_param("i", $pet_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $file_path = "../../" . $row['url'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $sql_delete_fotos = "DELETE FROM fotos WHERE pet_id = ?";
        $stmt = $this->conn->prepare($sql_delete_fotos);
        $stmt->bind_param("i", $pet_id);
        return $stmt->execute();
    }

    public function deletarPet($pet_id)
    {
        $this->conn->begin_transaction();

        try {
            if (!$this->removerFotosPet($pet_id)) {
                throw new Exception("Erro ao deletar fotos do pet.");
            }

            $sql_delete_doacoes = "DELETE FROM doacoes WHERE pet_id = ?";
            $stmt = $this->conn->prepare($sql_delete_doacoes);
            $stmt->bind_param("i", $pet_id);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao deletar doações do pet.");
            }

            $sql_delete_pet = "DELETE FROM pets WHERE id = ?";
            $stmt = $this->conn->prepare($sql_delete_pet);
            $stmt->bind_param("i", $pet_id);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao deletar o pet.");
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function contarDoacoes($searchTerm = '')
    {
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