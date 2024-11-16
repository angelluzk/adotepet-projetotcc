<?php
require_once '../../crud/config/DataBase.php';

$recaptchaSecret = '6Lf1h4AqAAAAAHFR8JlXZ06dO7pLJisXpIB4S6MH';
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
$verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
$responseData = json_decode($verifyResponse);
if (!$responseData->success) {
    echo json_encode(['error' => 'Falha no reCAPTCHA.']);
    exit;
}

$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$email = $_POST['email'] ?? '';
$petId = $_POST['pet_id'] ?? null;

if (!$petId) {
    echo json_encode(['error' => 'ID do pet não fornecido.']);
    exit;
}

try {
    $db = new DataBase();
    $conn = $db->getConnection();

    $query = "INSERT INTO adocoes (nome, telefone, email, pet_id, criado_em) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssi', $nome, $telefone, $email, $petId);

    if ($stmt->execute()) {
        $queryUpdate = "UPDATE pets SET status_id = (SELECT id FROM status WHERE nome = 'Em adoção') WHERE id = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param('i', $petId);

        if ($stmtUpdate->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Erro ao atualizar status do pet.']);
        }
    } else {
        echo json_encode(['error' => 'Erro ao salvar a adoção.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Erro ao processar a solicitação: ' . $e->getMessage()]);
}
?>