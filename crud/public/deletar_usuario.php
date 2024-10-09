<?php
require_once '../config/DataBase.php';
require_once '../controllers/UsuarioController.php';

$db = (new DataBase())->getConnection();
$usuarioController = new UsuarioController($db);

if (isset($_GET['id'])) {
    $usuarioController->delete($_GET['id']);
    header("Location: listar_usuarios.php");
    exit();
}
?>
