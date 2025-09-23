<?php
// Opcional, mas recomendado: Apenas exibe erros se algo der muito errado,
// mas o bloco try-catch vai cuidar da mensagem para o usuário.
error_reporting(0);
ini_set('display_errors', 0);

session_start();

// 1. Incluir a classe do banco de dados
require_once "crud/config/DataBase.php"; 

try {
    // 2. Criar o objeto e estabelecer a conexão (A CORREÇÃO PRINCIPAL)
    $database = new DataBase();
    $conn = $database->getConnection();

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        echo "Preencha todos os campos!";
        exit;
    }
    
    $sql = "SELECT u.id, u.senha, u.perfil_id, u.nome, u.status_id, p.nome AS perfil_nome
            FROM usuarios u
            INNER JOIN perfis p ON u.perfil_id = p.id
            WHERE u.email = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erro interno do servidor."); // Mensagem genérica por segurança
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close();
    // A conexão é fechada automaticamente no fim do script, mas se quiser, pode adicionar:
    // $database->closeConnection();

    if (!$user || !password_verify($senha, $user['senha'])) {
        // Juntamos a verificação de usuário e senha por segurança
        echo "E-mail ou senha inválidos!";
        exit;
    }

    // 3. Lógica de Status Aprimorada
    $status_id = (int)$user['status_id'];
    
    // Status 4 = Em Análise
    if ($status_id === 4) {
        echo "analysis";
        exit;
    }
    
    // Status 1 = Aprovado (baseado na sua tabela, onde usuários ativos tem status 'Disponível')
    if ($status_id === 1) {
        // Apenas loga o usuário se o status for 1 (Aprovado)
        $_SESSION['usuario_id']   = $user['id'];
        $_SESSION['usuario_nome'] = $user['nome'];
        $_SESSION['perfil_id']    = $user['perfil_id'];
        $_SESSION['perfil_nome']  = $user['perfil_nome'];
        
        echo "success";
        exit;
    }

    // Se o status não for 1 nem 4 (ex: o default 5, que é inválido), o acesso é negado.
    echo "Sua conta está inativa ou com status pendente. Contacte o suporte.";
    exit;

} catch (Exception $e) {
    // error_log($e->getMessage()); // Descomente para registrar o erro real em logs do servidor
    echo "Ocorreu um erro no servidor. Tente novamente mais tarde.";
    exit;
}