<?php
require '../config/DataBase.php';
require '../controllers/PetController.php';

$db = (new DataBase())->getConnection();
$petController = new PetController($db);

if (isset($_GET['id'])) {
    if ($petController->deletarPet($_GET['id'])) {
        header("Location: ../../crud/views/painel_admin.php");
    } else {
        echo "Erro ao deletar o pet.";
    }
    exit();
} else {
    die("ID do pet não fornecido.");
}
?>