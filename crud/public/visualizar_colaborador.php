<?php
require '../config/DataBase.php';

$database = new DataBase();
$conn = $database->getConnection();

if (!isset($_GET['id'])) {
    die("ID do colaborador não fornecido.");
}

$user_id = intval($_GET['id']);

$query = "
    SELECT u.id, u.nome, u.sobrenome, u.cpf, u.telefone, u.email, u.criado_em, u.data_nascimento, u.status_id,
           e.cep, e.logradouro, e.bairro, e.localidade, e.uf, e.estado
    FROM usuarios u
    LEFT JOIN enderecos e ON u.id = e.usuario_id
    WHERE u.id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Colaborador não encontrado.");
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Colaborador</title>
    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/visualizar_colaborador.css">
</head>

<body>
    <div class="container">
        <div class="usuario-details">
            <h1>Detalhes do Colaborador</h1>
            <div class="details-columns">
                <div class="details-left">
                    <h2>Dados Pessoais</h2>
                    <p><strong>Nome:</strong> <?= htmlspecialchars($user['nome']) ?>
                        <?= htmlspecialchars($user['sobrenome']) ?>
                    </p>
                    <p><strong>CPF:</strong> <?= htmlspecialchars($user['cpf']) ?></p>
                    <p><strong>E-mail:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Telefone:</strong> <?= htmlspecialchars($user['telefone']) ?></p>
                    <p><strong>Data de Nascimento:</strong> <?= htmlspecialchars($user['data_nascimento']) ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($user['status_id']) ?></p>
                    <p><strong>Criado em:</strong> <?= htmlspecialchars($user['criado_em']) ?></p>
                </div>

                <div class="details-right">
                    <h2>Endereço</h2>
                    <p><strong>CEP:</strong> <?= htmlspecialchars($user['cep']) ?></p>
                    <p><strong>Logradouro:</strong> <?= htmlspecialchars($user['logradouro']) ?></p>
                    <p><strong>Bairro:</strong> <?= htmlspecialchars($user['bairro']) ?></p>
                    <p><strong>Localidade:</strong> <?= htmlspecialchars($user['localidade']) ?></p>
                    <p><strong>UF:</strong> <?= htmlspecialchars($user['uf']) ?></p>
                    <p><strong>Estado:</strong> <?= htmlspecialchars($user['estado']) ?></p>
                </div>
            </div>
            <a href="../../crud/views/painel_admin.php" class="btn-voltar">Voltar à lista</a>
        </div>
    </div>
</body>

</html>