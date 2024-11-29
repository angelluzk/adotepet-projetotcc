<?php
require '../config/DataBase.php';
require '../controllers/PetController.php';

$db = (new DataBase())->getConnection();
$petController = new PetController($db);

if (isset($_GET['id'])) {
    $doacao = $petController->visualizarDoacao($_GET['id']);

    if (isset($doacao['error'])) {
        die($doacao['error']);
    }
} else {
    die("ID da doação não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Doação</title>

    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/visualizar_doacao.css">
</head>

<body>
    <div class="container">
        <h1>Detalhes da Doação</h1>

        <div class="info-container">
            <div class="text-info">
                <p><strong>Status:</strong> <?= htmlspecialchars($doacao['status_nome']) ?></p>
                <p><strong>Nome do Protetor:</strong>
                    <?= htmlspecialchars($doacao['usuario_nome'] . ' ' . $doacao['usuario_sobrenome']) ?></p>
                <p><strong>Espécie:</strong> <?= htmlspecialchars($doacao['especie_nome']) ?></p>
                <p><strong>Nome do Pet:</strong> <?= htmlspecialchars($doacao['nome']) ?></p>
                <p><strong>Raça:</strong> <?= htmlspecialchars($doacao['raca']) ?></p>
                <p><strong>Porte:</strong> <?= htmlspecialchars($doacao['porte']) ?></p>
                <p><strong>Sexo:</strong> <?= htmlspecialchars($doacao['sexo']) ?></p>
                <p><strong>Cor:</strong> <?= htmlspecialchars($doacao['cor']) ?></p>
                <p><strong>Idade:</strong> <?= htmlspecialchars($doacao['idade']) ?> anos</p>
                <p><strong>Descrição:</strong> <?= htmlspecialchars($doacao['descricao']) ?></p>
                <p><strong>Data da Doação:</strong>
                    <?= (new DateTime($doacao['data']))->format('d/m/Y') ?></p>
            </div>

            <div class="image-info">
                <?php if (!empty($doacao['foto_url'])): ?>
                    <?php
                    $imgSrc = '../../' . $doacao['foto_url'];
                    ?>
                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Foto do Pet">
                <?php else: ?>
                    <p>Nenhuma foto disponível.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="btn-group">
            <a href="../../crud/views/painel_admin.php" class="btn voltar">Voltar à lista</a>
        </div>
    </div>
</body>

</html>