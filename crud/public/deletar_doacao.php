<?php
require '../config/DataBase.php';
require '../controllers/PetController.php';

$db = (new DataBase())->getConnection();
$petController = new PetController($db);

if (isset($_GET['id'])) {
    $petController->deletarDoacao($_GET['id']);
    header("Location: listar_doacoes.php");
    exit();
} else {
    die("ID da doação não fornecido.");
}
?>
