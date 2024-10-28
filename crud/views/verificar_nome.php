<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Passo 1</title>

    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../../css/recuperar_senha.css">
</head>

<body>
    <div class="wave"></div>
    <div class="form-container">
        <p><a href="../../login.html" class="link-voltar"><i class="fas fa-arrow-left"></i> Voltar</a></p>
        <h1>Recuperar Senha</h1>
        <p>Para recuperar sua senha, você precisará fornecer algumas informações em três etapas. Comece inserindo seu
            nome e sobrenome abaixo.</p>
        <form method="POST" action="../../crud/controllers/RecuperarSenhaController.php?action=verificarNome">
            <label for="nome">Nome: <span class="required">*</span></label>
            <input type="text" id="nome" name="nome" required>
            <label for="sobrenome">Sobrenome: <span class="required">*</span></label>
            <input type="text" id="sobrenome" name="sobrenome" required>
            <button type="submit">Avançar</button>
            <?php if (isset($error)) {
                echo "<p class='error'>$error</p>";
            } ?>
        </form>
    </div>
</body>

</html>