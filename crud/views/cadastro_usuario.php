<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário - Adote Pet</title>
    <link rel="stylesheet" href="../../css/cadastrousuario.css">
    <link href="https://fonts.googleapis.com/css2?family=Candara&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
<div class="wave"></div>
    <div class="container">
        <div class="header">
            <img src="../../img/logo.png" alt="Logo" class="logo">
        </div>
        <a href="../../index.php" class="link-voltar"><i class="fas fa-arrow-left"></i> Voltar</a>
        <h2>Crie seu Cadastro no Adote Pet</h2>
        <p class="descricao">
            É necessário preencher corretamente o formulário abaixo com os respectivos dados cadastrais.
            Os campos com <span class="required">*</span> são de preenchimento obrigatório.
        </p>
        <form action="../../crud/public/cadastrar_usuario.php" method="post">
            <div class="input-group">
                <label for="perfil">Perfil <span class="required">*</span></label>
                <div class="input-icon">
                    <i class="fas fa-user-tag"></i>
                    <select id="perfil" name="perfil" required>
                        <option value="1">Funcionário</option>
                        <option value="2">Usuário Comum</option>
                    </select>
                </div>
            </div>

            <div class="input-row">
                <div class="input-group">
                    <label for="nome">Nome <span class="required">*</span></label>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="nome" name="nome" placeholder="Nome" required>
                    </div>
                </div>
                <div class="input-group">
                    <label for="sobrenome">Sobrenome <span class="required">*</span></label>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="sobrenome" name="sobrenome" placeholder="Sobrenome" required>
                    </div>
                </div>
            </div>

            <div class="input-group">
                <label for="cpf">CPF <span class="required">*</span></label>
                <div class="input-icon">
                    <i class="fas fa-id-card"></i>
                    <input type="text" id="cpf" name="cpf" placeholder="CPF" required>
                </div>
            </div>

            <div class="input-group">
                <label for="data_nascimento">Data de Nascimento <span class="required">*</span></label>
                <div class="input-icon">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" id="data_nascimento" name="data_nascimento" required>
                </div>
            </div>

            <div class="input-group">
                <label for="telefone">Telefone <span class="required">*</span></label>
                <div class="input-icon">
                    <i class="fas fa-phone"></i>
                    <input type="text" id="telefone" name="telefone" placeholder="(DDD) Telefone" required>
                </div>
            </div>
            <div class="input-group">
                <label for="email">E-mail <span class="required">*</span></label>
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="E-mail" required>
                </div>
            </div>

            <div class="input-row">
                <div class="input-group">
                    <label for="senha">Senha <span class="required">*</span></label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="senha" name="senha" placeholder="Mínimo de 6 caracteres" required>
                    </div>
                </div>
                <div class="input-group">
                    <label for="confirmar-senha">Confirmar Senha <span class="required">*</span></label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="confirmar-senha" name="confirmar-senha" placeholder="Confirmar Senha" required>
                    </div>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn cadastrar"><i class="fas fa-paper-plane"></i> Cadastrar</button>
            </div>
        </form>
        <p class="termos">
            Ao preencher o formulário você concorda com nossos <a href="#">Termos de uso</a> e nossa <a href="#">Política de Privacidade</a>.
        </p>
    </div>
</body>
</html>
