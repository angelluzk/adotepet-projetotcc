<?php
require_once '../../crud/config/DataBase.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['favoritado' => false, 'error' => 'Usuário não autenticado.']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$pet_id = $_GET['pet_id'] ?? null;

if (!$pet_id) {
    echo json_encode(['favoritado' => false, 'error' => 'Pet não informado.']);
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

    echo json_encode(['favoritado' => $result->num_rows > 0]);
} catch (Exception $e) {
    echo json_encode(['favoritado' => false, 'error' => $e->getMessage()]);
}