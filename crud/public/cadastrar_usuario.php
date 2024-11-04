<?php
require_once '../config/DataBase.php';
require_once '../controllers/UsuarioController.php';
require_once '../controllers/EnderecoController.php';


$db = new DataBase();
$conn = $db->getConnection();

if ($conn->connect_error) {
    error_log("Conexão falhou: " . $conn->connect_error);
    die("Conexão falhou: " . $conn->connect_error);
}

$dadosUsuario = [
    'nome' => $_POST['nome'] ?? '',
    'sobrenome' => $_POST['sobrenome'] ?? '',
    'cpf' => $_POST['cpf'] ?? '',
    'telefone' => $_POST['telefone'] ?? '',
    'email' => $_POST['email'] ?? '',
    'senha' => $_POST['senha'] ?? '',
    'perfil_id' => $_POST['perfil_id'] ?? '',
    'data_nascimento' => $_POST['data_nascimento'] ?? ''
];

$dadosEndereco = [
    'cep' => $_POST['cep'] ?? '',
    'logradouro' => $_POST['logradouro'] ?? '',
    'bairro' => $_POST['bairro'] ?? '',
    'localidade' => $_POST['localidade'] ?? '',
    'uf' => $_POST['uf'] ?? '',
    'estado' => $_POST['estado'] ?? ''
];

try {
    if ($_POST['senha'] !== $_POST['confirmar-senha']) {
        throw new Exception("As senhas não correspondem.");
    }

    $usuario = new Usuario($conn);
    $usuario_id = $usuario->create($dadosUsuario);

    $endereco = new Endereco($conn);
    $endereco_id = $endereco->create($dadosEndereco, $usuario_id);

    echo "<script>
            alert('Cadastro feito com sucesso. Entre no nosso site!');
            window.location.href = '../../index.php';
          </script>";
} catch (Exception $e) {
    echo "<script>
            alert('Erro: " . addslashes($e->getMessage()) . "');
            window.history.back();
          </script>";
}
?>