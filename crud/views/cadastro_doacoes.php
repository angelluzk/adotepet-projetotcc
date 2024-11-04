<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['error_message'] = "Você precisa estar logado para cadastrar um pet.";
    header('Location: ../../login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Doação</title>

    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../../css/cadastrodoacao.css">

</head>

<body>
    <div class="wave"></div>
    <div class="container">
        <div class="header">
            <img src="../../img/logo.png" alt="Logo" class="logo">
        </div>
        <a href="../../index.php" class="link-voltar"><i class="fas fa-arrow-left"></i> Voltar</a>
        <h2>Crie o Cadastro de Doação no Adote Pet</h2>
        <p class="descricao">
            É necessário preencher corretamente o formulário abaixo com os respectivos dados cadastrais.
            Os campos com <span class="required">*</span> são de preenchimento obrigatório.
        </p>
        <form action="../../crud/public/cadastrar_doacoes.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome"> Nome do Pet:<span class="required">*</span></label>
                <div class="input-icon">
                    <i class="fas fa-paw"></i>
                    <input type="text" id="nome" name="nome" required>
                </div>
            </div>

            <div class="input-row">
        <div class="form-group">
            <label for="especie"> Espécie:<span class="required">*</span></label>
            <div class="input-icon">
                <i class="fas fa-paw"></i>
                <select name="especie" id="especie" required>
                    <option value="" disabled selected>Selecione</option>
                    <option value="1">Cachorro</option>
                    <option value="2">Gato</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="raca"> Raça:<span class="required">*</span></label>
            <div class="input-icon">
                <i class="fas fa-dog"></i>
                <input type="text" id="raca" name="raca" required>
            </div>
        </div>
    </div>

    <div class="input-row">
        <div class="form-group">
            <label for="porte"> Porte:<span class="required">*</span></label>
            <div class="input-icon">
                <i class="fas fa-paw"></i>
                <select name="porte" id="porte" required>
                    <option value="" disabled selected>Selecione</option>
                    <option value="Pequeno">Pequeno</option>
                    <option value="Médio">Médio</option>
                    <option value="Grande">Grande</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="sexo"> Sexo:<span class="required">*</span></label>
            <div class="input-icon">
                <i class="fas fa-venus-mars"></i>
                <select name="sexo" id="sexo" required>
                    <option value="" disabled selected>Selecione</option>
                    <option value="Macho">Macho</option>
                    <option value="Fêmea">Fêmea</option>
                </select>
            </div>
        </div>
    </div>

    <div class="input-row">
        <div class="form-group">
            <label for="cor"> Cor:<span class="required">*</span></label>
            <div class="input-icon">
                <i class="fas fa-paint-brush"></i>
                <input type="text" id="cor" name="cor" required>
            </div>
        </div>

        <div class="form-group">
            <label for="idade"> Idade:<span class="required">*</span></label>
            <div class="input-icon">
                <i class="fas fa-clock"></i>
                <input type="number" id="idade" name="idade" required>
            </div>
        </div>
    </div>

            <div class="form-group">
                <label for="descricao"> Descrição:<span class="required">*</span></label>
                <div class="input-icon">
                    <textarea id="descricao" name="descricao" rows="4" required></textarea>
                </div>
            </div>

            <div class="form-group upload-section">
                <label for="foto"><i class="fas fa-image"></i> Fotos do Pet:<span class="required">*</span></label>
                <div class="upload-input">
                    <input type="file" id="foto" name="foto[]" accept="image/*" multiple required>
                    <button type="button" onclick="document.getElementById('foto').click();">Escolher Arquivos</button>
                </div>
                <small>Você pode enviar até 3 fotos.</small>
                <div class="uploaded-files">
                    <h4>Arquivos Selecionados:</h4>
                    <ul id="file-list"></ul>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn cadastrar"><i class="fas fa-paper-plane"></i> Cadastrar</button>
            </div>
        </form>
        <p class="termos">
            Ao preencher o formulário você concorda com nossos <a href="#">Termos de uso</a> e nossa <a
                href="#">Política de Privacidade</a>.
        </p>
    </div>

    <script>
        document.getElementById('foto').addEventListener('change', function () {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = '';
            const files = Array.from(this.files);
            files.forEach(file => {
                const li = document.createElement('li');
                li.textContent = file.name;
                fileList.appendChild(li);
            });
        });
    </script>
</body>

</html>