<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="../../css/recuperar_senha.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <h1>Alterar Senha</h1>
        <p>Por favor, insira sua nova senha abaixo.</p>
        <form method="POST" action="../../crud/controllers/RecuperarSenhaController.php?action=alterarSenha">
            <label for="nova_senha">Nova Senha: <span class="required">*</span></label>
            <div class="password-container">
                <input type="password" id="nova_senha" name="nova_senha" required>
                <i class="fas fa-eye toggle-password" onclick="togglePassword('nova_senha')"></i>
            </div>

            <label for="confirma_senha">Confirmar Nova Senha: <span class="required">*</span></label>
            <div class="password-container">
                <input type="password" id="confirma_senha" name="confirma_senha" required>
                <i class="fas fa-eye toggle-password" onclick="togglePassword('confirma_senha')"></i>
            </div>

            <button type="submit">Alterar Senha</button>
            <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const icon = passwordField.nextElementSibling;

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>