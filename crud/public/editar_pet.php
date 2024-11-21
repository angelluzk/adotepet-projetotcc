<?php
require_once '../../crud/config/DataBase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new DataBase();
    $conn = $db->getConnection();

    $pet_id = $_POST['pet_id'];
    $nome = $_POST['nome'];
    $raca = $_POST['raca'];
    $porte = $_POST['porte'];
    $sexo = $_POST['sexo'];
    $cor = $_POST['cor'];
    $idade = $_POST['idade'];
    $descricao = $_POST['descricao'];
    $status_id = $_POST['status_id'];

    $query = "UPDATE pets 
              SET nome = ?, raca = ?, porte = ?, sexo = ?, cor = ?, idade = ?, descricao = ?, status_id = ?
              WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->bind_param("sssssisii", $nome, $raca, $porte, $sexo, $cor, $idade, $descricao, $status_id, $pet_id);

    if (!$stmt->execute()) {
        die("Erro ao atualizar o pet: " . $stmt->error);
    }

    if (!empty($_FILES['foto']['name'])) {
        $fotoNome = $_FILES['foto']['name'];
        $fotoCaminho = 'uploads/' . $fotoNome;
        move_uploaded_file($_FILES['foto']['tmp_name'], $fotoCaminho);

        $fotoQuery = "UPDATE fotos SET nome = ?, url = ? WHERE pet_id = ?";
        $fotoStmt = $conn->prepare($fotoQuery);

        if (!$fotoStmt) {
            die("Erro ao preparar a consulta da foto: " . $conn->error);
        }

        $fotoStmt->bind_param("ssi", $fotoNome, $fotoCaminho, $pet_id);

        if (!$fotoStmt->execute()) {
            die("Erro ao atualizar a foto: " . $fotoStmt->error);
        }
    }

    header('Location: ../../crud/views/perfil_usuario.php');
    exit();
}
?>