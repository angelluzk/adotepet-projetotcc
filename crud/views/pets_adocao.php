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
        <div class="header-content">
            <div class="logo">
                <img src="../../img/logo.png" alt="Logo">
                <span>ADOTE<i class="fas fa-paw"></i><span class="highlight">PET</span></span>
            </div>
            <nav>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                    <li><a href="../../crud/views/cadastro_doacoes.php" target="_blank">Doe</a></li>
                    <li><a href="#">Adote</a></li>
                    <li><a href="#">Sobre nós</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="banner">
        <img src="../../img/banner-adotepet.jpg" alt="Banner" class="banner-image">
    </section>

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
</body>

</html>