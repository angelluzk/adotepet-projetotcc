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
    <title>Adote Pet - Painel Admin</title>
    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/painel_admin.css" />
</head>

<body>
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

    <div class="admin-container">
        <nav class="admin-sidebar">
            <div class="admin-barra-nav">
                <ul>
                    <li><a href="#" onclick="loadSection('home')"><i class="fas fa-home"></i> HOME</a></li>
                    <li><a href="#" onclick="loadSection('aprovar_pets')"><i class="fas fa-check-circle"></i> Aprovar
                            Doações</a></li>
                    <li><a href="#" onclick="loadSection('listar_usuarios')"><i class="fas fa-user"></i> Usuários
                            Cadastrados</a>
                    </li>
                    <li><a href="#" onclick="loadSection('listar_doacoes')"><i class="fas fa-paw"></i> Animais
                            Cadastrados</a></li>
                    <li><a href="#" onclick="loadSection('config')"><i class="fas fa-cog"></i> Configurações</a></li>
                    <li><a href="#" onclick="loadSection('help')"><i class="fas fa-question-circle"></i> Help</a></li>
                    <li><a href="../../index.php" target="_blank"><i class="fas fa-globe"></i> Página Index</a></li>
                    <li><a href="../../logout.php" class="admin-logout"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Conteúdo Principal -->
        <section class="admin-main">
            <div class="admin-main-top">
                <p>Painel Administrativo</p>
            </div>
            <section id="content" class="admin-main-content">
                <!-- Aqui será carregado o conteúdo dinâmico -->
            </section>
        </section>
    </div>

    <script src="../../javascript/mobile-navbar.js"></script>
    <script src="../../javascript/painel_admin.js"></script>
    <script>
        function loadSection(section) {
            const content = document.getElementById('content');
            content.innerHTML = '<p>Carregando...</p>';

            const baseUrl = '../../crud/views/';

            fetch(`${baseUrl}${section}.php`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao carregar a seção: ' + response.statusText);
                    }
                    return response.text();
                })
                .then(html => {
                    content.innerHTML = html;
                })
                .catch(error => {
                    content.innerHTML = `<p>Erro ao carregar o conteúdo: ${error.message}</p>`;
                });
        }
    </script>
</body>

</html>