<?php
require_once '../../crud/config/DataBase.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adocaoId = $_POST['adocao_id'];
    $petId = $_POST['pet_id'];

    if (!isset($adocaoId, $petId)) {
        echo "<script>alert('Dados inválidos!'); window.history.back();</script>";
        exit();
    }

    $db = new DataBase();
    $conn = $db->getConnection();

    $deleteAdocaoQuery = "DELETE FROM adocoes WHERE id = ?";
    $stmt = $conn->prepare($deleteAdocaoQuery);
    $stmt->bind_param("i", $adocaoId);

    if ($stmt->execute()) {
        $updatePetStatusQuery = "UPDATE pets SET status_id = (SELECT id FROM status WHERE nome = 'Disponível') WHERE id = ?";
        $stmt = $conn->prepare($updatePetStatusQuery);
        $stmt->bind_param("i", $petId);

        if ($stmt->execute()) {
            echo "<script>alert('Dados da solitação de adoção removida!'); window.location = '../../crud/views/perfil_usuario.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar o status do pet.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Erro ao remover a solicitação.'); window.history.back();</script>";
    }

    $stmt->close();
    $db->closeConnection();
}
?>