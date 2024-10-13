<?php
session_start();
require_once 'crud/config/DataBase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        echo "Por favor, preencha todos os campos.";
        exit();
    }

    $db = new DataBase();
    $conn = $db->getConnection();

    $sql = "SELECT id, senha, perfil_id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['perfil_id'] = $user['perfil_id'];
            $_SESSION['logged_in'] = true;

            if ($user['perfil_id'] == 1) {
                header("Location: crud/views/painel_admin.php");
            } elseif ($user['perfil_id'] == 2) {
                header("Location: index.php");
            } else {
                echo "Perfil desconhecido.";
            }
            exit();
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    $stmt->close();
    $db->closeConnection();
}
?>
