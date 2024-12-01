<?php
session_start();

$isLoggedIn = isset($_SESSION['usuario_id']);
$userName = $isLoggedIn ? $_SESSION['usuario_nome'] : 'Visitante';
$userPhoto = '../../img/default-photo.png';
$userType = $isLoggedIn ? $_SESSION['perfil_nome'] : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário - Adote Pet</title>
    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/cadastrousuario.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
</head>

<body>
    <header>
        <div class="wave"></div>
        <div class="logo">
            <img src="../../img/logo.png" alt="Logo">
            <span>ADOTE<i class="fas fa-paw"></i><span class="highlight">PET</span></span>
        </div>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="../../index.php">Início</a></li>
                <li class="nav-item"><a href="../../crud/views/cadastro_doacoes.php">Doe</a></li>
                <li class="nav-item"><a href="../../crud/views/pets_adocao.php">Adote</a></li>
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

        <?php if ($isLoggedIn): ?>
            <div id="dropdown-menu" class="dropdown-menu">
                <ul>
                    <?php if ($_SESSION['perfil_id'] == 1): ?>
                        <li><a href="painel_admin.php">Perfil</a></li>
                    <?php else: ?>
                        <li><a href="perfil_usuario.php">Perfil</a></li>
                    <?php endif; ?>
                    <li><a href="../../logout.php">Sair</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </header>

    <div class="container">
        <div class="header-logo-formulario">
            <img src="../../img/logo.png" alt="Logo" class="logo-formulario">
        </div>
        <a href="../../index.php" id="btnVoltar" class="link-voltar"><i class="fas fa-arrow-left"></i> Voltar</a>
        <h2>Crie seu Cadastro no Adote Pet</h2>
        <p class="descricao">
            É necessário preencher corretamente o formulário abaixo com os respectivos dados cadastrais.
            Os campos com <span class="required">*</span> são de preenchimento obrigatório.
        </p>
        <form id="formCadastro" action="../../crud/public/cadastrar_usuario.php" method="POST">
            <div class="form-columns">
                <div class="form-column">
                    <h3>Dados Pessoais</h3>
                    <div class="input-group">
                        <label for="perfil_id">Perfil <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-user-tag"></i>
                            <select id="perfil_id" name="perfil_id" required>
                                <option value="" disabled selected>Selecione</option>
                                <option value="1">Colaborador</option> <!-- Valor 1 é Funcionário, valor 2 é Usuário -->
                                <option value="2">Tutor</option>
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
                        <label for="data_nascimento">Data de Nascimento <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="date" id="data_nascimento" name="data_nascimento" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="cpf">CPF <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-id-card"></i>
                            <input type="text" id="cpf" name="cpf" placeholder="CPF" required>
                            <div class="error-message" id="error-cpf"></div>
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
                                <input type="password" id="senha" name="senha" placeholder="Mínimo de 6 caracteres"
                                    required>
                            </div>
                        </div>
                        <div class="input-group">
                            <label for="confirmar-senha">Confirmar Senha <span class="required">*</span></label>
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="confirmar-senha" name="confirmar-senha"
                                    placeholder="Confirmar Senha" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-column">
                    <h3>Endereço</h3>
                    <div class="input-group">
                        <label for="cep">CEP <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" id="cep" name="cep" placeholder="CEP" autocomplete="postal-code"
                                required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="logradouro">Logradouro <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-road"></i>
                            <input type="text" id="logradouro" name="logradouro" placeholder="Logradouro"
                                autocomplete="address-line1" required>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-group">
                            <label for="bairro">Bairro <span class="required">*</span></label>
                            <div class="input-icon">
                                <i class="fas fa-map"></i>
                                <input type="text" id="bairro" name="bairro" placeholder="Bairro"
                                    autocomplete="address-level2" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <label for="localidade">Localidade <span class="required">*</span></label>
                            <div class="input-icon">
                                <i class="fas fa-city"></i>
                                <input type="text" id="localidade" name="localidade" placeholder="Localidade"
                                    autocomplete="address-level1" required>
                            </div>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-group">
                            <label for="estado">Estado <span class="required">*</span></label>
                            <div class="input-icon">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" id="estado" name="estado" placeholder="Estado"
                                    autocomplete="address-level1" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <label for="uf">UF <span class="required">*</span></label>
                            <div class="input-icon">
                                <i class="fas fa-flag"></i>
                                <input type="text" id="uf" name="uf" placeholder="UF" autocomplete="address-level1"
                                    required>
                            </div>
                        </div>
                    </div>
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
    <script src="../../javascript/buscar_endereco.js"></script>
    <script src="../../javascript/formulario.js"></script>
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
    </script>
</body>

</html>