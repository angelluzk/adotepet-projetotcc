<?php
session_start();

$isLoggedIn = isset($_SESSION['usuario_id']);
$userName = $isLoggedIn ? $_SESSION['usuario_nome'] : 'Visitante';
$userPhoto = '../../img/default-photo.png';
$userType = $isLoggedIn ? $_SESSION['perfil_nome'] : null;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adote Pet - Pets para Adoção</title>

    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/pets_adocao.css">
    <script src="../../javascript/pets_adocao.js" defer></script>
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
                    <li><a href="logout.php">Sair</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </header>
    <main>
        <h1 class="titulo-banner">Por que adotar?</h1>
        <div class="banner">
            <img src="../../img/banner1.png" class="banner-image" alt="Banner 1">
            <img src="../../img/banner2.png" class="banner-image" alt="Banner 2">
            <img src="../../img/banner3.png" class="banner-image" alt="Banner 3">
        </div>
        <hr class="banner-separator">
    </main>
    <section class="filter">
        <label><i class="fas fa-filter"></i> Filtrar por:</label>
        <div class="form-group">
            <div class="input-icon">
                <i class="fas fa-paw"></i>
                <select name="especie" id="especie-filter" class="filter-select">
                    <option value="" disabled selected>Espécie</option>
                    <option value="gato">Gato</option>
                    <option value="cachorro">Cachorro</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon">
                <i class="fas fa-venus-mars"></i>
                <select name="sexo" id="sexo-filter" class="filter-select">
                    <option value="" disabled selected>Sexo</option>
                    <option value="macho">Macho</option>
                    <option value="femea">Fêmea</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon">
                <i class="fas fa-paw"></i>
                <select name="porte" id="porte-filter" class="filter-select">
                    <option value="" disabled selected>Porte</option>
                    <option value="pequeno">Pequeno</option>
                    <option value="medio">Médio</option>
                    <option value="grande">Grande</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon">
                <i class="fas fa-clock"></i>
                <select id="idade-filter" name="idade" class="filter-select">
                    <option value="" disabled selected>Idade</option>
                    <option value="filhote">Filhote (0 a 1 ano)</option>
                    <option value="jovem">Jovem (1 a 3 anos)</option>
                    <option value="adulto">Adulto (3 a 7 anos)</option>
                    <option value="idoso">Idoso (7 anos ou mais)</option>
                </select>
            </div>
        </div>

        <button onclick="filtrarPets()"><i class="fas fa-search"></i> Filtrar</button>
    </section>

    <section class="pet-cards" id="pet-cards-container">
        <!-- Cards dos pets serão adicionados dinamicamente pelo JavaScript -->
    </section>

    <div class="pagination">
        <button onclick="paginaAnterior()"><i class="fas fa-chevron-left"></i> Anterior</button>
        <span id="numeracao-pagina">Página 1</span>
        <button onclick="proximaPagina()">Próxima <i class="fas fa-chevron-right"></i></button>
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
                    <li><a href="#">Início</a></li>
                    <li><a href="#">Sobre Nós</a></li>
                    <li><a href="#">Adotar</a></li>
                    <li><a href="#">Doar</a></li>
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
    </script>
</body>

</html>