<?php
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

//Receber dados do formulário
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); //Criptografar a senha

//Inserir dados no banco
$sql = "INSERT INTO usuarios (nome, sobrenome, cpf, telefone, email, senha) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $nome, $sobrenome, $cpf, $telefone, $email, $senha);

if ($stmt->execute()) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>