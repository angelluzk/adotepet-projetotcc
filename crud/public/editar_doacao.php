<?php
require '../config/DataBase.php';
require '../controllers/PetController.php';

$db = (new DataBase())->getConnection();
$petController = new PetController($db);

if (isset($_GET['id'])) {
    $doacao = $petController->visualizarDoacao($_GET['id']);
} else {
    die("ID da doação não fornecido.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especie_id = $_POST['especie'];
    $raca = $_POST['raca'];
    $cor = $_POST['cor'];
    $idade = $_POST['idade'];
    $descricao = $_POST['descricao'];
    $porte = $_POST['porte'];
    $sexo = $_POST['sexo'];
    $files = $_FILES['foto'];

    $result = $petController->editarDoacao($_GET['id'], $nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $files);

    if ($result === "Doação editada com sucesso!") {
        header("Location: listar_doacoes.php");
        exit();
    } else {
        echo "<div class='error'>Erro: " . htmlspecialchars($result) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Doação</title>
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
        select,
        textarea {
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
        <h1>Editar Doação</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="especie">Espécie:</label>
            <select name="especie" id="especie" required>
                <option value="1" <?php echo isset($doacao['especie_id']) && $doacao['especie_id'] == 1 ? 'selected' : ''; ?>>Cachorro</option>
                <option value="2" <?php echo isset($doacao['especie_id']) && $doacao['especie_id'] == 2 ? 'selected' : ''; ?>>Gato</option>
            </select>

            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($doacao['nome']); ?>" required>

            <label for="raca">Raça:</label>
            <input type="text" name="raca" value="<?php echo htmlspecialchars($doacao['raca']); ?>" required>

            <label for="cor">Cor:</label>
            <input type="text" name="cor" value="<?php echo htmlspecialchars($doacao['cor']); ?>" required>

            <label for="porte">Porte:</label>
            <select name="porte" id="porte" required>
                <option value="Pequeno" <?php echo isset($doacao['porte']) && $doacao['porte'] == 'Pequeno' ? 'selected' : ''; ?>>Pequeno</option>
                <option value="Médio" <?php echo isset($doacao['porte']) && $doacao['porte'] == 'Médio' ? 'selected' : ''; ?>>Médio</option>
                <option value="Grande" <?php echo isset($doacao['porte']) && $doacao['porte'] == 'Grande' ? 'selected' : ''; ?>>Grande</option>
            </select>

            <label for="sexo">Sexo:</label>
            <select name="sexo" id="sexo" required>
                <option value="Macho" <?php echo isset($doacao['sexo']) && $doacao['sexo'] == 'macho' ? 'selected' : ''; ?>>Macho</option>
                <option value="Fêmea" <?php echo isset($doacao['sexo']) && $doacao['sexo'] == 'femea' ? 'selected' : ''; ?>>Fêmea</option>
            </select>

            <label for="idade">Idade:</label>
            <input type="number" name="idade" value="<?php echo htmlspecialchars($doacao['idade']); ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" required><?php echo htmlspecialchars($doacao['descricao']); ?></textarea>

            <label for="foto">Fotos (pode enviar novas para substituir as antigas):</label>
            <input type="file" name="foto[]" multiple>

            <button type="submit">Salvar</button>
            <a href="listar_doacoes.php">Voltar à lista</a>
        </form>
    </div>
</body>

</html>