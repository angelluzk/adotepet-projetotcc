<?php
require '../config/DataBase.php';
require '../controllers/PetController.php';

$db = (new DataBase())->getConnection();
$petController = new PetController($db);

if (isset($_GET['id'])) {
    if ($petController->deletarPet($_GET['id'])) {
        header("Location: listar_doacoes.php");
    } else {
        echo "Erro ao deletar o pet.";
    }
    exit();
} else {
    die("ID do pet não fornecido.");
}
?>