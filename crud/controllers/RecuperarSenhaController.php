<?php
session_start();
require_once '../config/DataBase.php';

class RecuperarSenhaController {

    public function __construct() {
        
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'verificarNome':
                $this->verificarNome();
                break;
            case 'verificarDataNascimento':
                $this->verificarDataNascimento();
                break;
            case 'verificarCpf':
                $this->verificarCpf();
                break;
            case 'alterarSenha':
                $this->alterarSenha();
                break;
            default:
                require_once '../views/verificar_nome.php';
        }
    }

    public function verificarNome(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST["nome"];
            $sobrenome = $_POST["sobrenome"];

            $db = new DataBase();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome = ? AND sobrenome = ?");
            $stmt->bind_param("ss", $nome, $sobrenome);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION["nome"] = $nome;
                $_SESSION["sobrenome"] = $sobrenome;
                header("Location: RecuperarSenhaController.php?action=verificarDataNascimento");
                exit();
            } else {
                $error = "Nome e sobrenome não encontrados!";
                require_once '../views/verificar_nome.php';
            }

            $stmt->close();
            $db->closeConnection();
        } else {
            require_once '../views/verificar_nome.php';
        }
    }

    public function verificarDataNascimento(){
        if (!isset($_SESSION["nome"]) || !isset($_SESSION["sobrenome"])) {
            header("Location: RecuperarSenhaController.php?action=verificarNome");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_nascimento = $_POST["data_nascimento"];

            $db = new DataBase();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome = ? AND sobrenome = ? AND data_nascimento = ?");
            $stmt->bind_param("sss", $_SESSION["nome"], $_SESSION["sobrenome"], $data_nascimento);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION["data_nascimento"] = $data_nascimento;
                header("Location: RecuperarSenhaController.php?action=verificarCpf");
                exit();
            } else {
                $error = "Data de nascimento incorreta!";
                require_once '../views/verificar_data_nascimento.php';
            }

            $stmt->close();
            $db->closeConnection();
        } else {
            require_once '../views/verificar_data_nascimento.php';
        }
    }

    public function verificarCpf(){
        if (!isset($_SESSION["data_nascimento"])) {
            header("Location: RecuperarSenhaController.php?action=verificarDataNascimento");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cpf = $_POST["cpf"];

            $cpf_abreviado = substr($cpf, 0, 6);

            $db = new DataBase();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome = ? AND sobrenome = ? AND data_nascimento = ? AND LEFT(cpf, 6) = ?");
            $stmt->bind_param("ssss", $_SESSION["nome"], $_SESSION["sobrenome"], $_SESSION["data_nascimento"], $cpf_abreviado);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                header("Location: RecuperarSenhaController.php?action=alterarSenha");
                exit();
            } else {
                $error = "CPF incorreto!";
                require_once '../views/verificar_cpf.php';
            }

            $stmt->close();
            $db->closeConnection();
        } else {
            require_once '../views/verificar_cpf.php';
        }
    }

    public function alterarSenha(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nova_senha = $_POST["nova_senha"];
            $confirma_senha = $_POST["confirma_senha"];
            
            if ($nova_senha === $confirma_senha) {
                $hash_senha = password_hash($nova_senha, PASSWORD_BCRYPT);
                $db = new DataBase();
                $conn = $db->getConnection();

                $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE nome = ? AND sobrenome = ? AND data_nascimento = ?");
                $stmt->bind_param("ssss", $hash_senha, $_SESSION["nome"], $_SESSION["sobrenome"], $_SESSION["data_nascimento"]);

                if ($stmt->execute()) {
                    session_destroy();
                    header("Location: ../../login.html");
                    exit();
                } else {
                    $error = "Erro ao alterar a senha!";
                    require_once '../views/alterar_senha.php';
                }

                $stmt->close();
                $db->closeConnection();
            } else {
                $error = "As senhas não correspondem!";
                require_once '../views/alterar_senha.php';
            }
        } else {
            require_once '../views/alterar_senha.php';
        }
    }
}

new RecuperarSenhaController();