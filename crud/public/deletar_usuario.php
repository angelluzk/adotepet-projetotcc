<?php
require_once '../config/DataBase.php';
require_once '../controllers/UsuarioController.php';

$database = new DataBase();
$db = $database->getConnection();

$controller = new UsuarioController($db);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $controller->delete($id);
        header("Location: ../../crud/views/painel_admin.php");
        exit();
    } catch (Exception $e) {
        echo json_encode(["message" => "Erro ao deletar usuário: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["message" => "ID do usuário não fornecido."]);
}
?>
