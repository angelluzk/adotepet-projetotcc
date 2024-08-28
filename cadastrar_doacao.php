<?php
session_start(); //Inicia a sessão

//Verifica se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); //Redireciona para a página de login
    exit();
}

//Receber dados do formulário
$especie = isset($_POST['especie']) ? $_POST['especie'] : '';
$raca = isset($_POST['raca']) ? $_POST['raca'] : '';
$cor = isset($_POST['cor']) ? $_POST['cor'] : '';
$idade = isset($_POST['idade']) ? $_POST['idade'] : '';
$descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';

//Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adote_pet";

$conn = new mysqli($servername, $username, $password, $dbname);

//Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

//Gerenciar upload de fotos
$fotos = '';
if (isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $uploaded_files = [];
    foreach ($_FILES['fotos']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['fotos']['name'][$key]);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($tmp_name, $target_file)) {
            $uploaded_files[] = $file_name;
        } else {
            echo "Erro ao fazer upload do arquivo: $file_name<br>";
        }
    }
    $fotos = implode(',', $uploaded_files);
}

//Inserir dados no banco
$sql = "INSERT INTO pets (especie, raca, cor, idade, descricao, fotos) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $especie, $raca, $cor, $idade, $descricao, $fotos);

if ($stmt->execute()) {
    echo "Pet cadastrado com sucesso!";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
