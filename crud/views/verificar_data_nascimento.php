<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Passo 2</title>

    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../../css/recuperar_senha.css">

</head>

<body>
    <div class="wave"></div>
    <div class="form-container">
        <h1>Recuperar Senha - Passo 2</h1>
        <p>Agora, por favor, insira sua data de nascimento para verificarmos a autenticidade das informações fornecidas.
        </p>
        <form method="POST" action="../../crud/controllers/RecuperarSenhaController.php?action=verificarDataNascimento">
            <label for="data_nascimento">Data de Nascimento: <span class="required">*</span></label>
            <input type="date" id="data_nascimento" name="data_nascimento" required>
            <button type="submit">Avançar</button>
            <?php if (isset($error)) {
                echo "<p class='error'>$error</p>";
            } ?>
        </form>
    </div>
</body>

</html>