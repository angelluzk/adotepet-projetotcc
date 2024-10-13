<?php
require_once '../config/DataBase.php';
require_once '../controllers/UsuarioController.php';
require_once '../controllers/EnderecoController.php';

$database = new DataBase();
$db = $database->conn;

// Verifica se a conexão foi bem-sucedida
if ($db->connect_error) {
    die("Conexão falhou: " . $db->connect_error);
}

// Instancia o UsuarioController
$usuarioController = new UsuarioController($db);
if (!$usuarioController) {
    die('Erro ao criar o UsuarioController.'); 
}

// Instancia o EnderecoController
$enderecoController = new EnderecoController($db);
if (!$enderecoController) {
    die('Erro ao criar o EnderecoController.'); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $nome = $_POST['nome'] ?? '';
    $sobrenome = $_POST['sobrenome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $perfil = $_POST['perfil'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';

    // Dados do endereço
    $cep = $_POST['cep'] ?? '';
    $logradouro = $_POST['logradouro'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $localidade = $_POST['localidade'] ?? '';
    $uf = $_POST['uf'] ?? '';

    try {
        // Verifica se o e-mail já está cadastrado
        if ($usuarioController->emailExists($email)) {
            throw new Exception("E-mail já cadastrado.");
        }

        // Criação do usuário
        $usuarioController->create([
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'cpf' => $cpf,
            'telefone' => $telefone,
            'email' => $email,
            'senha' => $senha,
            'perfil' => $perfil,
            'data_nascimento' => $data_nascimento,
        ]);

        $usuario_id = $db->insert_id;

        if ($usuario_id > 0) {
            //Cria o novo endereço
            $enderecoController->create([
                'cep' => $cep,
                'logradouro' => $logradouro,
                'bairro' => $bairro,
                'localidade' => $localidade,
                'uf' => $uf
            ], $usuario_id);

            //Redireciona para a página index.php em caso de sucesso
            header('Location: ../../index.php');
            exit();
        } else {
            throw new Exception("Falha ao obter o ID do usuário.");
        }
    } catch (Exception $e) {
        error_log('Erro: ' . $e->getMessage());
        
        //Retorna uma resposta JSON apenas se houver um erro
        echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
        exit();
    }
}
?>