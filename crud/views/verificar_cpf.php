<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Passo 3</title>
    <link rel="stylesheet" href="../../css/recuperar_senha.css">
</head>
<body>
<div class="form-container">
        <h1>Recuperar Senha - Passo 3</h1>
        <p>Por favor, insira os 6 primeiros dígitos do seu CPF para verificar sua identidade.</p>
        <form method="POST" action="../../crud/controllers/RecuperarSenhaController.php?action=verificarCpf">
            <label for="cpf">CPF: <span class="required">*</span></label>
            <input type="text" id="cpf" name="cpf" maxlength="6" pattern="\d{6}" title="Digite apenas os 6 primeiros dígitos do CPF" required>
            <button type="submit">Avançar</button>
            <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>
    </div>
</body>
</html>