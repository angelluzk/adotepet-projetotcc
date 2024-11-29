<?php
require '../config/DataBase.php';
require '../controllers/PetController.php';

$db = (new DataBase())->getConnection();
$petController = new PetController($db);

$sqlStatus = "SELECT id, nome FROM status";
$stmtStatus = $db->prepare($sqlStatus);
$stmtStatus->execute();
$statusList = $stmtStatus->get_result()->fetch_all(MYSQLI_ASSOC);

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
    $status_id = $_POST['status'];
    $files = $_FILES['foto'];

    $statusValido = false;
    foreach ($statusList as $status) {
        if ($status['id'] == $status_id) {
            $statusValido = true;
            break;
        }
    }

    if (!$statusValido) {
        $message = ["type" => "error", "text" => "Status inválido selecionado."];
    } else {
        $atualizarFotos = isset($files) && $files['name'][0] !== "";

        $resultado = $petController->editarDoacao($_GET['id'], $nome, $especie_id, $raca, $porte, $sexo, $cor, $idade, $descricao, $status_id, $atualizarFotos ? $files : null);

        if ($resultado === "Doação editada com sucesso!") {
            $message = ["type" => "success", "text" => "Doação editada com sucesso!"];
            header("Location: ../../crud/views/painel_admin.php");
            exit();
        } else {
            $message = ["type" => "error", "text" => "Aviso: " . htmlspecialchars($resultado['text'])];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adote Pet - Editar Doação</title>
    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/editar_doacao.css">
</head>

<body>
    <div class="container">
        <h1>Editar Doação</h1>
        <?php if (isset($message)): ?>
            <div id="message-container" class="message-container <?php echo $message['type']; ?>">
                <p><?php echo htmlspecialchars($message['text']); ?></p>
            </div>
        <?php endif; ?>


        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group left">
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
            </div>

            <div class="form-group right">
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

                <label for="status">Status:</label>
                <select name="status" id="status">
                    <?php foreach ($statusList as $status): ?>
                        <option value="<?= $status['id']; ?>" <?= $doacao['status_id'] == $status['id'] ? 'selected' : ''; ?>>
                            <?= $status['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-left">
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" required><?php echo htmlspecialchars($doacao['descricao']); ?></textarea>
            </div>

            <div class="form-group full-width">
                <label for="foto">Atualizar fotos:</label>
                <div class="file-upload">
                    <input type="file" name="foto[]" id="foto" multiple onchange="previewImages(event)"
                        style="display: none;">
                    <span class="file-upload-label" id="file-upload-label">Selecione arquivos</span>
                    <div id="fotos-adicionadas" class="foto-preview">
                        <p>Fotos Adicionadas: 0</p>
                    </div>
                    <div id="preview-container"></div>
                </div>
            </div>

            <div class="form-group full-width">
                <button type="submit">Salvar</button>
                <a href="../../crud/views/painel_admin.php">Voltar à lista</a>
            </div>
        </form>
    </div>

    <script src="../../javascript/editar_doacao.js"></script>

</body>

</html>