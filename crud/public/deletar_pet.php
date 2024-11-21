<?php
require_once '../../crud/config/DataBase.php';

if (isset($_GET['pet_id'])) {
    $pet_id = $_GET['pet_id'];
    
    $deleteFotosQuery = "DELETE FROM fotos WHERE pet_id = ?";
    $stmt = $conn->prepare($deleteFotosQuery);
    $stmt->bind_param("i", $pet_id);
    $stmt->execute();

    $deletePetQuery = "DELETE FROM pets WHERE id = ?";
    $stmt = $conn->prepare($deletePetQuery);
    $stmt->bind_param("i", $pet_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>