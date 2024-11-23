<?php
require_once '../../crud/config/DataBase.php';

session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Método não permitido.']);
    exit;
}

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Usuário não autenticado.']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['pet_id'])) {
    echo json_encode(['error' => 'ID do pet não informado.']);
    exit;
}

$pet_id = $data['pet_id'];

try {
    $db = new DataBase();
    $conn = $db->getConnection();

    $query = "DELETE FROM favoritos WHERE usuario_id = ? AND pet_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $usuario_id, $pet_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Erro ao remover o animal dos favoritos.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Erro no servidor: ' . $e->getMessage()]);
}