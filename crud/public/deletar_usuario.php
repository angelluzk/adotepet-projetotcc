<?php
require_once '../config/DataBase.php';
require_once '../controllers/UsuarioController.php';

$database = new DataBase();
$db = $database->getConnection();

$controller = new UsuarioController($db);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $controller->delete($id);
    header("Location: listar_usuarios.php");
    exit();
} else {
    echo json_encode(["message" => "ID do usuário não fornecido."]);
}
?>