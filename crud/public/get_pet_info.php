<?php
require_once '../../crud/config/DataBase.php';

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['pet_id']) && is_numeric($_GET['pet_id'])) {
    $pet_id = (int)$_GET['pet_id'];

    try {
        $db = new DataBase();
        $conn = $db->getConnection();

        $query = "SELECT p.id AS pet_id, p.nome AS pet_nome, p.raca AS pet_raca, 
                         p.porte AS pet_porte, p.sexo AS pet_sexo, p.cor AS pet_cor, 
                         p.idade AS pet_idade, p.descricao AS pet_descricao, 
                         p.status_id 
                  FROM pets p 
                  WHERE p.id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            echo json_encode(['error' => 'Erro ao preparar a consulta: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param("i", $pet_id);

        if (!$stmt->execute()) {
            echo json_encode(['error' => 'Erro ao executar a consulta: ' . $stmt->error]);
            exit;
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $pet = $result->fetch_assoc();
            echo json_encode($pet);
        } else {
            echo json_encode(['error' => 'Pet não encontrado.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Erro ao buscar pet: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Pet ID inválido ou não fornecido.']);
}