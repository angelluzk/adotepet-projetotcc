<?php
require_once '../config/DataBase.php';
require_once '../controllers/UsuarioController.php';

$db = (new DataBase())->getConnection();
$usuarioController = new UsuarioController($db);

if (isset($_GET['id'])) {
    $usuario = $usuarioController->read($_GET['id']);
} else {
    die("ID do usuário não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Usuário</title>
    <style>
        body {
            font-family: Candara, sans-serif;
            background-color: #fff;
            color: #100e48;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 90%;
            box-sizing: border-box;
            text-align: left;
            display: flex;
            flex-direction: column;
        }

        h1 {
            text-align: center;
            color: #100e48;
        }

        p {
            margin: 10px 0;
            font-size: 20px;
            line-height: 1.5;
        }

        a {
            display: inline-block;
            background-color: #100e48;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            text-align: center;
        }

        a:hover {
            background-color: #7fb9ca;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detalhes do Usuário</h1>
        <p><strong>ID:</strong> <?php echo $usuario['id']; ?></p>
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
        <p><strong>Sobrenome:</strong> <?php echo htmlspecialchars($usuario['sobrenome']); ?></p>
        <p><strong>CPF:</strong> <?php echo htmlspecialchars($usuario['cpf']); ?></p>
        <p><strong>Data Nascimento:</strong> <?php echo htmlspecialchars((new DateTime($usuario['data_nascimento']))->format('d/m/Y')); ?></p>
        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($usuario['telefone']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
        <p><strong>Perfil:</strong> <?php echo $usuario['perfil_id'] == 1 ? 'Funcionário' : 'Usuário Comum'; ?></p>

        <a href="listar_usuarios.php">Voltar</a>
    </div>
</body>
</html>
