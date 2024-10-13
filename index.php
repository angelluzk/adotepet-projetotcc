<?php
session_start();

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
if ($errorMessage) {
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adote Pet</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Candara&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logo.png" alt="Logo Pet Family">
            <span>ADOTE<i class="fas fa-paw"></i><span class="highlight">PET</span></span>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Contato</a></li>
                <li><a href="#">Sobre nós</a></li>
                <li><a href="#">Produtos</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><a href="logout.php" class="btn-entrar">Sair</a></li>
                <?php else: ?>
                    <li><a href="login.html" class="btn-entrar">Entrar</a></li>
                <?php endif; ?>
                <li><a href="crud/views/cadastro_usuario.php" class="btn-cadastrar">Cadastre-se!</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="wave"></div>
        <section class="hero">
            <div class="hero-content">
                <h1>Encontre um Lar Amoroso para Seu Pet ou Adote um Novo Amigo</h1>
                <p>Use nossas ferramentas para divulgar pets disponíveis para adoção ou encontre o companheiro ideal para você. Juntos, podemos transformar vidas!</p>
                <div class="hero-buttons">
                    <a href="<?= $isLoggedIn ? 'crud/views/cadastro_doacoes.php' : 'login.html' ?>" class="hero-button">
                        <img src="img/botaov4.png" alt="Divulgue o Pet">
                    </a>
                    <a href="#" class="hero-button">
                        <img src="img/botaov5.png" alt="Adote um Pet">
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <img src="img/img2.png" alt="Gato e Cães">
            </div>
            <div class="wave"></div>
        </section>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <section class="adoption-section">
            <h2>Veja pets para adoção</h2>
            <p>Pets anunciados em Brasília.</p>
            <div class="adoption-cards">
                <a href="#" class="adoption-card">
                    <img src="img/gato1.png" alt="Marley">
                    <div class="card-content">
                        <h3>Marley</h3>
                        <p>Recanto das Emas, Distrito Federal</p>
                        <span class="time">19 horas atrás</span>
                    </div>
                    <div class="favorite-icon"><i class="fas fa-star"></i></div>
                </a>
                <a href="#" class="adoption-card">
                    <img src="img/gato2.png" alt="Pingo">
                    <div class="card-content">
                        <h3>Milo</h3>
                        <p>Taguatinga, Distrito Federal</p>
                        <span class="time">4 dias atrás</span>
                    </div>
                    <div class="favorite-icon"><i class="fas fa-star"></i></div>
                </a>
                <a href="#" class="adoption-card">
                    <img src="img/cachorro1.png" alt="Djerry">
                    <div class="card-content">
                        <h3>Cleitinho</h3>
                        <p>Samambaia, Distrito Federal</p>
                        <span class="time">6 dias atrás</span>
                    </div>
                    <div class="favorite-icon"><i class="fas fa-star"></i></div>
                </a>
                <a href="#" class="adoption-card">
                    <img src="img/cachorro2.png" alt="Sem Nome">
                    <div class="card-content">
                        <h3>Não possui nome</h3>
                        <p>Ceilândia, Distrito Federal</p>
                        <span class="time">28 minutos atrás</span>
                    </div>
                    <div class="favorite-icon"><i class="fas fa-star"></i></div>
                </a>
            </div>
            <a href="#" class="view-more-button">Ver mais</a>
        </section>
    </main>
    
    <footer>
        <div class="footer-container">
            <div class="footer-section about">
                <h2>ADOTE PET</h2>
                <p>Nosso objetivo é encontrar um lar para cada animal de estimação. Junte-se a nós para salvar vidas e oferecer um lar cheio de amor para os pets.</p>
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

</body>
</html>