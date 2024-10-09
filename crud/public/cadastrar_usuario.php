<?php
require_once '../config/DataBase.php';
require_once '../controllers/UsuarioController.php';

$dataBase = new DataBase();
$db = $dataBase->conn;

$usuarioController = new UsuarioController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $sobrenome = $_POST['sobrenome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $perfil = $_POST['perfil'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';

    // Log para depuração
    error_log("Data de Nascimento (Cadastro): " . $data_nascimento);

    // Chamar a função create
    $usuarioController->create([
        'nome' => $nome,
        'sobrenome' => $sobrenome,
        'cpf' => $cpf,
        'telefone' => $telefone,
        'email' => $email,
        'senha' => $senha,
        'perfil' => $perfil,
        'data_nascimento' => $data_nascimento,
    ]);

    // Redirecionar após o cadastro
    header("Location: ../../index.php");
    exit();
}
?>