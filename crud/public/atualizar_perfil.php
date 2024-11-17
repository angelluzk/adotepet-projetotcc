<?php
const IMG_BASE_PATH = 'http://localhost/adotepet-projetotcc/';
require_once '../../crud/config/DataBase.php';
session_start();

$errors = [];
$userData = [];

$isLoggedIn = isset($_SESSION['usuario_id']);
$userName = $isLoggedIn ? $_SESSION['usuario_nome'] : 'Visitante';
$userPhoto = '../../img/default-photo.png';
$userType = $isLoggedIn ? $_SESSION['perfil_nome'] : null;

if ($isLoggedIn) {
    $usuarioId = $_SESSION['usuario_id'];

    $db = new DataBase();
    $conn = $db->getConnection();

    $query = "
    SELECT u.nome, u.sobrenome, u.email, u.data_nascimento, u.telefone, e.cep, e.logradouro, e.bairro, e.localidade, e.uf, e.estado
    FROM usuarios u
    LEFT JOIN enderecos e ON u.id = e.usuario_id
    WHERE u.id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        $errors[] = "Usuário não encontrado!";
    }

    $adocoes = [];
    $queryAdocoes = "
    SELECT 
        a.id, 
    a.nome, 
    a.email, 
    a.telefone, 
    p.nome AS pet_nome, 
    a.pet_id,
    MIN(f.url) AS url_principal,
    GROUP_CONCAT(f.url) AS urls
    FROM adocoes a
JOIN doacoes d ON a.pet_id = d.pet_id
JOIN pets p ON a.pet_id = p.id
LEFT JOIN fotos f ON f.pet_id = p.id
WHERE d.usuario_id = ?
GROUP BY a.id, a.nome, a.email, a.telefone, p.nome, a.pet_id";


    $stmt = $conn->prepare($queryAdocoes);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $resultAdocoes = $stmt->get_result();


    while ($row = $resultAdocoes->fetch_assoc()) {
        $adocoes[] = $row;
    }

    $petsDoacoes = [];
    $queryPets = "
    SELECT 
        p.id AS pet_id, 
        p.nome AS pet_nome, 
        s.nome AS status_nome, 
        MIN(f.url) AS url_principal,
        GROUP_CONCAT(f.url) AS urls
    FROM pets p
    LEFT JOIN status s ON p.status_id = s.id
    LEFT JOIN doacoes d ON d.pet_id = p.id
    LEFT JOIN fotos f ON f.pet_id = p.id
    WHERE d.usuario_id = ?
    GROUP BY p.id, p.nome, s.nome
    ";

    $stmt = $conn->prepare($queryPets);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $resultPets = $stmt->get_result();

    while ($row = $resultPets->fetch_assoc()) {
        $row['url_principal'] = $row['url_principal'] ? IMG_BASE_PATH . $row['url_principal'] : IMG_BASE_PATH . 'default.jpg';

        if (!empty($row['urls'])) {
            $urls = explode(',', $row['urls']);
            $row['urls'] = array_map(function ($url) {
                return IMG_BASE_PATH . $url;
            }, $urls);
        } else {
            $row['urls'] = [IMG_BASE_PATH . 'default.jpg'];
        }

        $petsDoacoes[] = $row;
    }

    $stmt->close();
    $db->closeConnection();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : '';
    $telefone = $_POST['telefone'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $localidade = $_POST['localidade'];
    $uf = $_POST['uf'];
    $estado = $_POST['estado'];
    $senha_atual = isset($_POST['senha_atual']) ? $_POST['senha_atual'] : '';
    $nova_senha = isset($_POST['nova_senha']) ? $_POST['nova_senha'] : '';

    if (empty($nome) || empty($sobrenome) || empty($email)) {
        $errors[] = "Nome, sobrenome e e-mail são obrigatórios.";
    }

    if (!empty($senha_atual) && empty($nova_senha)) {
        $errors[] = "A nova senha é obrigatória quando a senha atual for informada.";
    }

    if (empty($errors)) {
        $db = new DataBase();
        $conn = $db->getConnection();

        $queryUsuario = "
            UPDATE usuarios 
            SET nome = ?, sobrenome = ?, email = ?, data_nascimento = ?, telefone = ?
            WHERE id = ?
        ";
        $stmt = $conn->prepare($queryUsuario);
        $stmt->bind_param("sssssi", $nome, $sobrenome, $email, $data_nascimento, $telefone, $usuarioId);
        $stmt->execute();

        if (!empty($senha_atual)) {
            $querySenha = "SELECT senha FROM usuarios WHERE id = ?";
            $stmt = $conn->prepare($querySenha);
            $stmt->bind_param("i", $usuarioId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $senha_armazenada = $row['senha'];

                if (password_verify($senha_atual, $senha_armazenada)) {
                    if (!empty($nova_senha)) {
                        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                        $queryAlterarSenha = "UPDATE usuarios SET senha = ? WHERE id = ?";
                        $stmt = $conn->prepare($queryAlterarSenha);
                        $stmt->bind_param("si", $senha_hash, $usuarioId);
                        $stmt->execute();
                    } else {
                        $errors[] = "Por favor, forneça uma nova senha.";
                    }
                } else {
                    $errors[] = "A senha atual está incorreta.";
                }
            }
        }

        $db->closeConnection();

        if (empty($errors)) {
            echo "<script>alert('Alterações salvas com sucesso!'); window.location = '../../crud/views/perfil_usuario.php';</script>";
            exit();
        }
    }
}
?>