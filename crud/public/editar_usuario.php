<?php
require_once '../config/DataBase.php';
require_once '../controllers/UsuarioController.php';
require_once '../controllers/EnderecoController.php';

$db = new DataBase();
$conn = $db->getConnection();
$usuarioController = new UsuarioController($conn);

$usuario_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    $data = $usuarioController->read($usuario_id);
    if (!$data) {
        throw new Exception("Usuário não encontrado.");
    }
    $usuario = $data['usuario'];
    $endereco = $data['endereco'];
} catch (Exception $e) {
    echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioData = [
        'nome' => trim($_POST['nome']),
        'sobrenome' => trim($_POST['sobrenome']),
        'cpf' => trim($_POST['cpf']),
        'telefone' => trim($_POST['telefone']),
        'email' => trim($_POST['email']),
        'senha' => trim($_POST['senha']),
        'perfil_id' => (int) $_POST['perfil_id'],
        'data_nascimento' => $_POST['data_nascimento']
    ];

    foreach ($usuarioData as $key => $value) {
        if (empty($value) && $key !== 'senha') {
            echo "<p style='color: red;'>Erro: O campo $key não pode estar vazio.</p>";
            exit;
        }
    }

    try {
        $usuarioController->update($usuario_id, $usuarioData);

        $enderecoData = [
            'cep' => trim($_POST['cep']),
            'logradouro' => trim($_POST['logradouro']),
            'bairro' => trim($_POST['bairro']),
            'localidade' => trim($_POST['localidade']),
            'uf' => trim($_POST['uf']),
            'estado' => trim($_POST['estado'])
        ];

        if (!empty($endereco)) {
            $usuarioController->updateEndereco($usuario_id, $enderecoData);
        } else {
            $usuarioController->createEndereco($enderecoData, $usuario_id);
        }

        echo "<p style='color: green;'>Usuário e endereço atualizados com sucesso!</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>Erro ao atualizar: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adote Pet - Editar Usuário</title>
    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/editar_usuario.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Editar Usuário</h1>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
            <div class="form-columns">
                <div class="form-section">
                    <h2>Dados Cadastrados</h2>
                    <div class="input-group">
                        <label>Perfil:</label>
                        <select name="perfil_id">
                            <option value="1" <?php echo $usuario['perfil_id'] == 1 ? 'selected' : ''; ?>>Colaborador
                            </option>
                            <option value="2" <?php echo $usuario['perfil_id'] == 2 ? 'selected' : ''; ?>>Tutor</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Nome:</label>
                        <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>"
                            required>
                    </div>
                    <div class="input-group">
                        <label>Sobrenome:</label>
                        <input type="text" name="sobrenome"
                            value="<?php echo htmlspecialchars($usuario['sobrenome']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Data de Nascimento:</label>
                        <input type="date" name="data_nascimento" value="<?php echo $usuario['data_nascimento']; ?>"
                            required>
                    </div>
                    <div class="input-group">
                        <label>CPF:</label>
                        <input type="text" name="cpf" value="<?php echo htmlspecialchars($usuario['cpf']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Telefone:</label>
                        <input type="text" name="telefone" value="<?php echo htmlspecialchars($usuario['telefone']); ?>"
                            required>
                    </div>
                    <div class="input-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>"
                            required>
                    </div>
                    <div class="input-group">
                        <label>Senha (opcional):</label>
                        <input type="password" name="senha" placeholder="Nova senha">
                    </div>
                </div>

                <div class="form-section">
                    <h2>Endereço</h2>
                    <div class="input-group">
                        <label>CEP:</label>
                        <input type="text" name="cep" id="cep"
                            value="<?php echo htmlspecialchars($endereco['cep'] ?? ''); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Logradouro:</label>
                        <input type="text" name="logradouro" id="logradouro"
                            value="<?php echo htmlspecialchars($endereco['logradouro'] ?? ''); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Bairro:</label>
                        <input type="text" name="bairro" id="bairro"
                            value="<?php echo htmlspecialchars($endereco['bairro'] ?? ''); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Localidade:</label>
                        <input type="text" name="localidade" id="localidade"
                            value="<?php echo htmlspecialchars($endereco['localidade'] ?? ''); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>UF:</label>
                        <input type="text" name="uf" id="uf"
                            value="<?php echo htmlspecialchars($endereco['uf'] ?? ''); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Estado:</label>
                        <input type="text" name="estado" id="estado"
                            value="<?php echo htmlspecialchars($endereco['estado'] ?? ''); ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-buttons">
                <button type="submit">SALVAR</button>
                <a href="../../crud/views/painel_admin.php" class="back-link">Voltar à lista</a>
            </div>
        </form>
    </div>

    <script src="../../javascript/buscar_endereco.js"></script>
</body>

</html>