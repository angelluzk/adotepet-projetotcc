<?php
session_start();

require_once '../../crud/config/DataBase.php';

$isLoggedIn = isset($_SESSION['usuario_id']);
$userName = $isLoggedIn ? $_SESSION['usuario_nome'] : 'Visitante';
$userPhoto = '../../img/default-photo.png';
$userType = $isLoggedIn ? $_SESSION['perfil_nome'] : null;

if ($isLoggedIn) {
    $usuarioId = $_SESSION['usuario_id'];

    $db = new DataBase();
    $conn = $db->getConnection();

    $query = "
    SELECT u.nome, u.sobrenome, u.email, u.data_nascimento, u.telefone, e.cep, e.logradouro, e.bairro, e.localidade, e.uf, e.estado
    FROM usuarios u
    LEFT JOIN enderecos e ON u.id = e.usuario_id
    WHERE u.id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        echo "Usuário não encontrado!";
        exit();
    }

    $db->closeConnection();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Usuário</title>

    <link rel="icon" href="../../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/perfil_usuario.css">
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
                <li class="nav-item"><a href="#">Início</a></li>
                <li class="nav-item"><a href="#">Doe</a></li>
                <li class="nav-item"><a href="#">Adote</a></li>
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

    <div class="profile-container">
        <aside class="sidebar">
            <div class="profile-info">
                <img src="<?php echo $userPhoto; ?>" alt="Foto do usuário" class="profile-pic">
                <h2><?php echo htmlspecialchars($userData['nome'] . ' ' . $userData['sobrenome']); ?></h2>
                <p class="email"><?php echo htmlspecialchars($userData['email']); ?></p>

            </div>
            <nav class="profile-menu">
                <ul>
                    <li><a href="#" data-section="editar-perfil" onclick="switchSection(event)">Editar Perfil</a></li>
                    <li><a href="#" data-section="minhas-doacoes" onclick="switchSection(event)">Minhas Doações</a></li>
                    <li><a href="#" data-section="pets-adotados" onclick="switchSection(event)">Pets Adotados</a></li>
                    <li><a href="#" data-section="pets-favoritos" onclick="switchSection(event)">Pets Favoritos</a></li>
                </ul>
            </nav>
        </aside>

        <main class="profile-content">
            <section id="minhas-doacoes" class="content-section">
                <h2>Minhas Doações</h2>
                <div class="donation-cards">
                    <div class="donation-card">
                        <img src="../../img/gato1.png" alt="Pet">
                        <div class="card-content">
                            <h3>Pet 1</h3>
                            <p>Status: Disponível</p>
                            <div class="action-buttons">
                                <button class="edit-btn">Editar</button>
                                <button class="delete-btn">Excluir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="pets-adotados" class="content-section">
                <h2>Pets que Adotei</h2>
                <div class="adopted-cards">
                    <div class="adopted-card">
                        <img src="../../img/gato2.png" alt="Pet">
                        <div class="card-content">
                            <h3>Pet 2</h3>
                            <p>Data de Adoção: 20/10/2024</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="pets-favoritos" class="content-section">
                <h2>Pets Adicionados aos Favoritos</h2>
                <div class="favorites-cards">
                    <div class="favorite-card">
                        <img src="../../img/cachorro1.png" alt="Pet Favorito">
                        <div class="card-content">
                            <h3>Pet Favorito 1</h3>
                            <p>Status: Disponível</p>
                        </div>
                    </div>
                    <div class="favorite-card">
                        <img src="../../img/cachorro2.png" alt="Pet Favorito">
                        <div class="card-content">
                            <h3>Pet Favorito 2</h3>
                            <p>Status: Em Adoção</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="editar-perfil" class="content-section">
                <h2>Editar Perfil</h2>
                <?php
                if (!empty($errors)) {
                    echo '<div class="error-messages">';
                    foreach ($errors as $error) {
                        echo '<p>' . $error . '</p>';
                    }
                    echo '</div>';
                }
                ?>
                <form action="../../crud/public/atualizar_perfil.php" method="POST" class="edit-profile-form"
                    id="editar-perfil-form">
                    <div class="section-row">
                        <div class="section-container dados-pessoais">
                            <h3>Dados Pessoais</h3>
                            <div class="input-row">
                                <div class="input-group">
                                    <label for="nome">Nome <span class="required"></span></label>
                                    <div class="input-icon">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="nome" name="nome"
                                            value="<?php echo $userData['nome']; ?>" required disabled>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="sobrenome">Sobrenome <span class="required"></span></label>
                                    <div class="input-icon">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="sobrenome" name="sobrenome"
                                            value="<?php echo $userData['sobrenome']; ?>" required disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-group input-data-nascimento">
                                    <label for="data_nascimento">Data de Nascimento</label>
                                    <div class="input-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                        <input type="date" id="data_nascimento" name="data_nascimento"
                                            value="<?php echo $userData['data_nascimento']; ?>" required disabled>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="telefone">Telefone</label>
                                    <div class="input-icon">
                                        <i class="fas fa-phone"></i>
                                        <input type="tel" id="telefone" name="telefone"
                                            value="<?php echo $userData['telefone']; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-group">
                                    <label for="email">E-mail <span class="required"></span></label>
                                    <div class="input-icon">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" id="email" name="email"
                                            value="<?php echo $userData['email']; ?>" required disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section-container endereco">
                            <h3>Endereço</h3>
                            <div class="input-row">
                                <div class="input-group">
                                    <label for="cep">CEP <span class="required"></span></label>
                                    <div class="input-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <input type="text" id="cep" name="cep" value="<?php echo $userData['cep']; ?>"
                                            required disabled>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="logradouro">Logradouro <span class="required"></span></label>
                                    <div class="input-icon">
                                        <i class="fas fa-road"></i>
                                        <input type="text" id="logradouro" name="logradouro"
                                            value="<?php echo $userData['logradouro']; ?>" required disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-group">
                                    <label for="bairro">Bairro <span class="required"></span></label>
                                    <div class="input-icon">
                                        <i class="fas fa-map"></i>
                                        <input type="text" id="bairro" name="bairro"
                                            value="<?php echo $userData['bairro']; ?>" required disabled>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="localidade">Localidade <span class="required"></span></label>
                                    <div class="input-icon">
                                        <i class="fas fa-city"></i>
                                        <input type="text" id="localidade" name="localidade"
                                            value="<?php echo $userData['localidade']; ?>" required disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-group input-uf">
                                    <label for="uf">UF <span class="required"></span></label>
                                    <div class="input-icon">
                                        <i class="fas fa-flag"></i>
                                        <input type="text" id="uf" name="uf" value="<?php echo $userData['uf']; ?>"
                                            maxlength="2" required disabled>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="estado">Estado <span class="required"></span></label>
                                    <div class="input-icon">
                                        <i class="fas fa-map-signs"></i>
                                        <input type="text" id="estado" name="estado"
                                            value="<?php echo $userData['estado']; ?>" required disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-container senha">
                        <h3>Senha</h3>
                        <div class="input-row">
                            <div class="input-group">
                                <label for="senha_atual">Nova Senha</label>
                                <div class="input-icon">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" id="senha_atual" name="senha_atual"
                                        placeholder="Mínimo de 6 caracteres" disabled>
                                </div>
                            </div>
                            <div class="input-group">
                                <label for="nova_senha">Confirmar Nova Senha</label>
                                <div class="input-icon">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" id="nova_senha" name="nova_senha"
                                        placeholder="Confirmar Senha" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="button-container">
                        <button type="submit" class="save-btn">Salvar Alterações</button>
                        <button type="button" class="edit-btn" id="edit-btn">Editar Perfil</button>
                    </div>
                </form>
            </section>

        </main>
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

    <script src="../../javascript/perfil_usuario.js"></script>

    <script src="../../javascript/mobile-navbar.js"></script>

</body>

</html>