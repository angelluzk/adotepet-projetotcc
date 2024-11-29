<?php
session_start();

$isLoggedIn = isset($_SESSION['usuario_id']);
$userName = $isLoggedIn ? $_SESSION['usuario_nome'] : 'Visitante';
$userPhoto = '../../img/default-photo.png';
$userType = $isLoggedIn ? $_SESSION['perfil_nome'] : null;

if (!$isLoggedIn) {
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
    <title>Cadastro de Doação - Adote Pet</title>
    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/cadastrodoacao.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="wave"></div>
    <header>
        <div class="logo">
            <img src="../../img/logo.png" alt="Logo">
            <span>ADOTE<i class="fas fa-paw"></i><span class="highlight">PET</span></span>
        </div>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="../../index.php">Início</a></li>
                <li class="nav-item"><a href="../../crud/views/cadastro_doacoes.php" target="_blank">Doe</a></li>
                <li class="nav-item"><a href="../../crud/views/pets_adocao.php" target="_blank">Adote</a></li>
                <li class="nav-item"><a href="#">Sobre nós</a></li>
                <?php if ($isLoggedIn): ?>
                    <li class="profile-section">
                        <div class="profile-perfil" onclick="toggleMenu()">
                            <img src="<?php echo $userPhoto; ?>" alt="Foto de <?php echo $userName; ?>" class="user-photo">
                        </div>
                        <div class="dropdown-menu" id="dropdown-menu">
                            <?php if ($_SESSION['perfil_id'] == 1): ?>
                                <a href="painel_admin.php">Perfil</a>
                            <?php else: ?>
                                <a href="perfil_usuario.php">Perfil</a>
                            <?php endif; ?>
                            <a href="../../logout.php">Sair</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a href="../../login.html">Entrar</a></li>
                    <li><a href="../../crud/views/cadastro_usuario.php" class="btn-cadastrar ">Cadastre-se!</a></li>
                <?php endif; ?>
            </ul>
            <div class="mobile-menu">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>

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
                <label for="nome"> Nome do Animal:<span class="required">*</span></label>
                <div class="input-icon">
                    <i class="fas fa-paw"></i>
                    <input type="text" id="nome" name="nome" required placeholder="Nome">
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
                        <input type="text" id="raca" name="raca" required placeholder="Raça">
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
                        <input type="text" id="cor" name="cor" required placeholder="Cor">
                    </div>
                </div>

                <div class="form-group">
                    <label for="idade"> Idade:<span class="required">*</span></label>
                    <div class="input-icon">
                        <i class="fas fa-clock"></i>
                        <input type="number" id="idade" name="idade" required placeholder="Idade">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="descricao"> Descrição:<span class="required">*</span></label>
                <div class="input-icon">
                    <textarea id="descricao" name="descricao" rows="4" required
                        placeholder="Informações do animal (Ex: Se é vacinado, castrado, etc.)"></textarea>
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

    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h2>ADOTE PET</h2>
                <p>Nosso objetivo é encontrar um lar para cada animal de estimação. Junte-se a nós para salvar vidas e
                    oferecer um lar cheio de amor para os pets.</p>
                <div class="socials">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-section links">
                <h2>Links Úteis</h2>
                <ul>
                    <li><a href="../../index.php">Início</a></li>
                    <li><a href="#">Sobre Nós</a></li>
                    <li><a href="../../crud/views/pets_adocao.php">Adotar</a></li>
                    <li><a href="../../crud/views/cadastro_doacoes.php">Doar</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h2>Contato</h2>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> 123 Rua dos Pets, Cidade, Estado</li>
                    <li><i class="fas fa-phone"></i> (61) 0000-0000</li>
                    <li><i class="fas fa-envelope"></i> contato@adotepet.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 ADOTE PET | Todos os direitos reservados</p>
        </div>
    </footer>

    <script src="../../javascript/mobile-navbar.js"></script>
    <script>
        function toggleMenu() {
            const dropdownMenu = document.getElementById('dropdown-menu');
            dropdownMenu.classList.toggle('show');
        }

        window.onclick = function (event) {
            if (!event.target.closest('.profile-section')) {
                const dropdownMenu = document.getElementById('dropdown-menu');
                if (dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                }
            }
        };

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