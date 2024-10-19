<?php
require_once '../config/DataBase.php';
require_once '../controllers/UsuarioController.php';
require_once '../controllers/EnderecoController.php';

$db = new DataBase();
$db = $db->getConnection();
$usuarioController = new UsuarioController($db);

$usuario_id = $_GET['id'] ?? 0;

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
        'nome' => $_POST['nome'],
        'sobrenome' => $_POST['sobrenome'],
        'cpf' => $_POST['cpf'],
        'telefone' => $_POST['telefone'],
        'email' => $_POST['email'],
        'senha' => !empty($_POST['senha']) ? $_POST['senha'] : null,
        'perfil' => $_POST['perfil'],
        'data_nascimento' => $_POST['data_nascimento']
    ];

    try {
        $usuarioController->update($usuario_id, $usuarioData);

        $enderecoData = [
            'cep' => $_POST['cep'],
            'logradouro' => $_POST['logradouro'],
            'bairro' => $_POST['bairro'],
            'localidade' => $_POST['localidade'],
            'uf' => $_POST['uf']
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

        .input-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
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
            padding: 8px 12px;
            cursor: pointer;
            font-size: 16px;
            width: auto;
            display: block;
            margin: 20px auto 0;
        }

        button:hover {
            background-color: #7fb9ca;
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

        h2 {
            margin-top: 30px;
            color: #100e48;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Editar Usuário</h1>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
        <div class="input-group">
            <label>Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required></label>
            <label>Sobrenome: <input type="text" name="sobrenome" value="<?php echo htmlspecialchars($usuario['sobrenome']); ?>" required></label>
        </div>
        <div class="input-group">
            <label>Data de Nascimento: <input type="date" name="data_nascimento" value="<?php echo $usuario['data_nascimento']; ?>" required></label>
            <label>CPF: <input type="text" name="cpf" value="<?php echo htmlspecialchars($usuario['cpf']); ?>" required></label>
        </div>
        <div class="input-group">
            <label>Telefone: <input type="text" name="telefone" value="<?php echo htmlspecialchars($usuario['telefone']); ?>" required></label>
            <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required></label>
        </div>
        <label>Senha: <input type="password" name="senha" placeholder="Nova Senha (opcional)"></label>
        <label>Perfil:
            <select name="perfil">
                <option value="1" <?php echo $usuario['perfil_id'] == 1 ? 'selected' : ''; ?>>Funcionário</option>
                <option value="2" <?php echo $usuario['perfil_id'] == 2 ? 'selected' : ''; ?>>Usuário Comum</option>
            </select>
        </label>
        <h2>Endereço</h2>
        <div class="input-group">
            <label>CEP: <input type="text" name="cep" id="cep" value="<?php echo htmlspecialchars($endereco['cep'] ?? ''); ?>" required></label>
            <label>Logradouro: <input type="text" name="logradouro" id="logradouro" value="<?php echo htmlspecialchars($endereco['logradouro'] ?? ''); ?>" required></label>
        </div>
        <div class="input-group">
            <label>Bairro: <input type="text" name="bairro" id="bairro" value="<?php echo htmlspecialchars($endereco['bairro'] ?? ''); ?>" required></label>
            <label>Localidade: <input type="text" name="localidade" id="localidade" value="<?php echo htmlspecialchars($endereco['localidade'] ?? ''); ?>" required></label>
        </div>
        <div class="input-group">
            <label>UF: <input type="text" name="uf" id="uf" value="<?php echo htmlspecialchars($endereco['uf'] ?? ''); ?>" required></label>
        </div>
        <button type="submit">Salvar</button>
        <a href="listar_usuarios.php">Voltar à lista</a>
    </form>
</div>

<script src="../../javascript/buscar_endereco.js"></script>
</body>
</html>