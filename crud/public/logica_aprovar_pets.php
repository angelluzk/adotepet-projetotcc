<?php
require '../config/DataBase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new DataBase();
    $conn = $database->getConnection();
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data && isset($data['pet_id'], $data['status'])) {
        $petId = $data['pet_id'];
        $status = $data['status'];

        if ($status === 'Disponível') {
            $query = "UPDATE pets SET status_id = (SELECT id FROM status WHERE nome = 'Disponível') WHERE id = ?";
        } elseif ($status === 'Rejeitado') {
            $query = "DELETE FROM pets WHERE id = ?";
        } else {
            echo json_encode(['success' => false, 'message' => 'Status inválido.']);
            exit;
        }

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $petId);

        if ($stmt->execute()) {
            $message = ($status === 'Disponível') ? 'Pet aprovado com sucesso!' : 'Pet rejeitado e removido.';
            echo json_encode(['success' => true, 'message' => $message]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o status do pet.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido.']);
}