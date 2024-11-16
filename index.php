<?php
require_once 'process_index.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adote Pet</title>

    <link rel="icon" href="img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="img/logo.png" alt="Logo">
            <span>ADOTE<i class="fas fa-paw"></i><span class="highlight">PET</span></span>
        </div>
        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="index.php">Início</a></li>
                <li class="nav-item"><a href="crud/views/cadastro_doacoes.php">Doe</a></li>
                <li class="nav-item"><a href="crud/views/pets_adocao.php">Adote</a></li>
                <li class="nav-item"><a href="#">Sobre nós</a></li>

                <?php if ($isLoggedIn): ?>
                    <li class="profile-section">
                        <div class="profile-perfil" onclick="toggleMenu()">
                            <img src="<?php echo $userPhoto; ?>" alt="Foto de <?php echo $userName; ?>" class="user-photo">
                        </div>
                        <div class="dropdown-menu" id="dropdown-menu">
                            <?php if ($_SESSION['perfil_id'] == 1): ?>
                                <a href="crud/views/painel_admin.php">Perfil</a>
                            <?php else: ?>
                                <a href="crud/views/perfil_usuario.php">Perfil</a>
                            <?php endif; ?>
                            <a href="logout.php">Sair</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a href="login.html">Entrar</a></li>
                    <li><a href="crud/views/cadastro_usuario.php" class="btn-cadastrar">Cadastre-se!</a></li>
                <?php endif; ?>
            </ul>

            <div class="mobile-menu">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>

    <main>
        <div class="wave"></div>
        <section class="hero">
            <div class="hero-content">
                <h1>Encontre um Lar Amoroso para Seu Pet ou Adote um Novo Amigo</h1>
                <p>Use nossas ferramentas para divulgar pets disponíveis para adoção ou encontre o companheiro ideal
                    para você. Juntos, podemos transformar vidas!</p>
                <div class="hero-buttons">
                    <a href="#" class="hero-button divulgue-button">
                        <img src="img/botaov4.png" alt="Divulgue o Pet">
                    </a>
                    <a href="crud/views/pets_adocao.php" class="hero-button">
                        <img src="img/botaov5.png" alt="Adote um Pet">
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <img src="img/img2.png" alt="Gato e Cães">
            </div>
            <div class="wave"></div>
        </section>

        <section class="adoption-section">
            <h2>Veja pets para adoção</h2>
            <p>Pets anunciados em Brasília.</p>
            <div class="adoption-cards">
                <?php foreach ($pets as $pet): ?>
                    <a href="crud/views/pet_detalhes.php?id=<?php echo $pet['pet_id']; ?>" class="adoption-card"
                        target="_blank">
                        <img src="<?php echo $baseUrl . htmlspecialchars($pet['foto_url']); ?>"
                            alt="<?php echo htmlspecialchars($pet['pet_nome']); ?>">

                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($pet['pet_nome']); ?></h3>
                            <p><?php echo htmlspecialchars($pet['bairro']) . ', ' . htmlspecialchars($pet['estado']); ?></p>
                            <span class="time"><?php echo time_ago($pet['criado_em']); ?></span>
                        </div>
                        <div class="favorite-icon"><i class="fas fa-star"></i></div>
                    </a>
                <?php endforeach; ?>
            </div>
            <a href="crud/views/pets_adocao.php" class="view-more-button">Ver mais</a>
        </section>
    </main>

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
                    <li><a href="index.php">Início</a></li>
                    <li><a href="#">Sobre Nós</a></li>
                    <li><a href="crud/views/pets_adocao.php">Adotar</a></li>
                    <li><a href="crud/views/cadastro_doacoes.php">Doar</a></li>
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

    <script>
        const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
    </script>

    <script src="javascript/mobile-navbar.js"></script>
    <script src="javascript/index.js"></script>
</body>

</html>