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

    $sql = "SELECT u.id, u.senha, u.perfil_id, u.nome, u.status_id, p.nome AS perfil_nome 
            FROM usuarios u
            INNER JOIN perfis p ON u.perfil_id = p.id 
            WHERE u.email = ?";
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

        if ($user['status_id'] == 4) {
            echo "Seu cadastro está em análise. Aguarde a aprovação para acessar o sistema!";
            exit();
        }

        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];
            $_SESSION['perfil_nome'] = $user['perfil_nome'];
            $_SESSION['perfil_id'] = $user['perfil_id'];
            $_SESSION['logged_in'] = true;

            header("Location: index.php");
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