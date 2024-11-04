<?php
session_start();

require_once '../config/DataBase.php';
require_once '../controllers/PetController.php';
require_once '../controllers/EnderecoController.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.html');
    exit;
}

$db = new DataBase();
$conn = $db->getConnection();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especie_id = $_POST['especie'];
    $raca = $_POST['raca'];
    $porte = $_POST['porte'];
    $sexo = $_POST['sexo'];
    $cor = $_POST['cor'];
    $idade = $_POST['idade'];
    $descricao = $_POST['descricao'];
    $usuario_id = $_SESSION['usuario_id'];

    $fotos = isset($_FILES['foto']) ? $_FILES['foto'] : null; 

    $petController = new PetController($conn);
    $enderecoController = new EnderecoController($conn);

    $endereco = $enderecoController->getEnderecoByUsuarioId($usuario_id);
    
    if ($endereco) {
        $endereco_id = $endereco['id'];
    } else {
        echo "<script>alert('Erro: Endereço não encontrado.');</script>";
        echo "<script>window.location.href='../../index.php';</script>";
        exit;
    }

    $mensagem = $petController->cadastrarDoacao($nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $fotos, $usuario_id, $endereco_id);

    echo "<script>alert('$mensagem');</script>";
    echo "<script>window.location.href='../../index.php';</script>";
}

$db->closeConnection();
?>