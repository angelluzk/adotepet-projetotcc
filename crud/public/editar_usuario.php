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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Garantir que a data de nascimento esteja no formato YYYY-MM-DD, se não estiver vazia
    $data_nascimento = !empty($_POST['data_nascimento']) ? date('Y-m-d', strtotime($_POST['data_nascimento'])) : null;

    $usuarioController->update($_POST['id'], array_merge($_POST, ['data_nascimento' => $data_nascimento]));
    header("Location: listar_usuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <style>
        body {
            font-family: 'Candara', sans-serif;
            background-color: #f4f4f4;
            color: #100e48;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }

        h1 {
            text-align: center;
            color: #100e48;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #100e48;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #100e48;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #7fb9ca;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
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
        <h1>Editar Usuário</h1>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
            <label>Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required></label>
            <label>Sobrenome: <input type="text" name="sobrenome" value="<?php echo htmlspecialchars($usuario['sobrenome']); ?>" required></label>
            <label>Data de Nascimento: <input type="date" name="data_nascimento" value="<?php echo $usuario['data_nascimento']; ?>" required></label>
            <label>CPF: <input type="text" name="cpf" value="<?php echo htmlspecialchars($usuario['cpf']); ?>" required></label>
            <label>Telefone: <input type="text" name="telefone" value="<?php echo htmlspecialchars($usuario['telefone']); ?>" required></label>
            <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required></label>
            <label>Senha: <input type="password" name="senha" placeholder="Nova Senha (opcional)"></label>
            <label>Perfil:
                <select name="perfil">
                    <option value="1" <?php echo $usuario['perfil_id'] == 1 ? 'selected' : ''; ?>>Funcionário</option>
                    <option value="2" <?php echo $usuario['perfil_id'] == 2 ? 'selected' : ''; ?>>Usuário Comum</option>
                </select>
            </label>
            <button type="submit">Salvar</button>
            <a href="listar_usuarios.php">Voltar à lista</a>
        </form>
    </div>
</body>
</html>
