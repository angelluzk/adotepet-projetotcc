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

        .info-container {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .info-container img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-left: 30px;
        }

        .centered-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: -10px;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            margin-top: -10px;
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

        img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin: 10px 0;
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
        <h1>Detalhes da Doação</h1>

        <div class="info-container">
            <div class="text-info">
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
            <a href="listar_doacoes.php" class="btn voltar">Voltar à lista</a>
        </div>
    </div>
</body>

</html>