<?php
require_once '../../crud/config/DataBase.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'Usuário não autenticado.']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$pet_id = $_POST['pet_id'] ?? null;

if (!$pet_id) {
    echo json_encode(['success' => false, 'error' => 'Pet não informado.']);
    exit;
}

try {
    $db = new DataBase();
    $conn = $db->getConnection();

    $query = "SELECT * FROM favoritos WHERE usuario_id = ? AND pet_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $usuario_id, $pet_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $deleteQuery = "DELETE FROM favoritos WHERE usuario_id = ? AND pet_id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("ii", $usuario_id, $pet_id);
        $deleteStmt->execute();

        echo json_encode(['success' => true, 'favoritado' => false, 'pet' => $pet_id]);
    } else {
        $insertQuery = "INSERT INTO favoritos (usuario_id, pet_id) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ii", $usuario_id, $pet_id);
        $insertStmt->execute();

        echo json_encode(['success' => true, 'favoritado' => true, 'pet' => $pet_id]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}