<?php
require_once '../config/DataBase.php';
require_once '../controllers/UsuarioController.php';
require_once '../controllers/EnderecoController.php';

$database = new DataBase();
$db = $database->conn;

if ($db->connect_error) {
    die("Conexão falhou: " . $db->connect_error);
}

$usuarioController = new UsuarioController($db);
if (!$usuarioController) {
    die('Erro ao criar o UsuarioController.'); 
}

$enderecoController = new EnderecoController($db);
if (!$enderecoController) {
    die('Erro ao criar o EnderecoController.'); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $sobrenome = $_POST['sobrenome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar-senha'] ?? '';
    $perfil = $_POST['perfil'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';

    $cep = $_POST['cep'] ?? '';
    $logradouro = $_POST['logradouro'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $localidade = $_POST['localidade'] ?? '';
    $uf = $_POST['uf'] ?? '';

    try {
        if ($senha !== $confirmar_senha) {
            throw new Exception("As senhas não correspondem.");
        }

        if ($usuarioController->emailExists($email)) {
            throw new Exception("E-mail já cadastrado.");
        }

        $senha_criptografada = password_hash($senha, PASSWORD_BCRYPT);

        $usuarioController->create([
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'cpf' => $cpf,
            'telefone' => $telefone,
            'email' => $email,
            'senha' => $senha_criptografada,
            'perfil' => $perfil,
            'data_nascimento' => $data_nascimento,
        ]);

        $usuario_id = $db->insert_id;

        if ($usuario_id > 0) {
            $enderecoController->create([
                'cep' => $cep,
                'logradouro' => $logradouro,
                'bairro' => $bairro,
                'localidade' => $localidade,
                'uf' => $uf
            ], $usuario_id);

            header('Location: ../../index.php');
            exit();
        } else {
            throw new Exception("Falha ao obter o ID do usuário.");
        }
    } catch (Exception $e) {
        error_log('Erro: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
        exit();
    }
}
?>