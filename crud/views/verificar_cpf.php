<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Passo 3</title>
    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/recuperar_senha.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
</head>

<body>
    <div class="wave"></div>
    <div class="form-container">
        <h1>Recuperar Senha - Passo 3</h1>
        <p>Por favor, insira os 6 primeiros dígitos do seu CPF para verificar sua identidade.</p>
        <form method="POST" action="../../crud/controllers/RecuperarSenhaController.php?action=verificarCpf">
            <label for="cpf">CPF: <span class="required">*</span></label>
            <input type="text" id="cpf" name="cpf" maxlength="6" pattern="\d{6}"
                title="Digite apenas os 6 primeiros dígitos do CPF" required>
            <button type="submit">Avançar</button>
            <?php if (isset($error)) {
                echo "<p class='error'>$error</p>";
            } ?>
        </form>
    </div>

    <script>
        document.getElementById('cpf').addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    </script>
</body>

</html>