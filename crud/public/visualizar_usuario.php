<?php
require_once '../config/DataBase.php';
require_once '../controllers/UsuarioController.php';

$db = new DataBase();
$usuarioController = new UsuarioController($db->getConnection());

$usuario_id = $_GET['id'] ?? 0;
$data = $usuarioController->read($usuario_id);
$usuario = $data['usuario'];
$endereco = $data['endereco'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Usuário</title>

    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/visualizar_usuario.css">
</head>

<body>
<div class="user-details">
        <h1>Detalhes do Usuário</h1>

        <div class="details-columns">
            <div class="details-left">
                <h2>Dados Cadastrados</h2>
                <hr>
                <p><strong>ID:</strong> <?php echo $usuario['id']; ?></p>
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
                <p><strong>Sobrenome:</strong> <?php echo htmlspecialchars($usuario['sobrenome']); ?></p>
                <p><strong>CPF:</strong> <?php echo htmlspecialchars($usuario['cpf']); ?></p>
                <p><strong>Data Nascimento:</strong> <?php echo htmlspecialchars((new DateTime($usuario['data_nascimento']))->format('d/m/Y')); ?></p>
                <p><strong>Telefone:</strong> <?php echo htmlspecialchars($usuario['telefone']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
                <p><strong>Perfil:</strong> <?php echo $usuario['perfil_id'] == 1 ? 'Funcionário' : 'Usuário Comum'; ?></p>
            </div>

            <div class="details-right">
                <h2>Endereço</h2>
                <hr>
                <p><strong>CEP:</strong> <?php echo htmlspecialchars($endereco['cep']); ?></p>
                <p><strong>Logradouro:</strong> <?php echo htmlspecialchars($endereco['logradouro']); ?></p>
                <p><strong>Bairro:</strong> <?php echo htmlspecialchars($endereco['bairro']); ?></p>
                <p><strong>Localidade:</strong> <?php echo htmlspecialchars($endereco['localidade']); ?></p>
                <p><strong>Estado:</strong> <?php echo htmlspecialchars($endereco['estado']); ?></p>
                <p><strong>UF:</strong> <?php echo htmlspecialchars($endereco['uf']); ?></p>
            </div>
        </div>

        <a href="../../crud/views/painel_admin.php" class="btn-voltar">Voltar à lista</a>
    </div>
</body>

</html>