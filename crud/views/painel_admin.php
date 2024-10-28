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
    <div class="container">
        <nav>
            <div class="navbar">
                <div class="logo">
                    <img src="../../img/logo.png" alt="">
                </div>
                <ul>
                    <li><a href="painel_admin.php">
                            <i class="fas fa-home"></i>
                            <span class="nav-item">HOME</span>
                        </a>
                    </li>
                    <li><a href="../../crud/public/listar_usuarios.php">
                            <i class="fas fa-user"></i>
                            <span class="nav-item">Usuários</span>
                        </a>
                    </li>
                    <li><a href="#">
                            <i class="fas fa-tasks"></i>
                            <span class="nav-item">Aprovar Doações</span>
                        </a>
                    </li>
                    <li><a href="../../crud/public/listar_doacoes.php">
                            <i class="fas fa-paw"></i>
                            <span class="nav-item">Pets Cadastrados</span>
                        </a>
                    </li>
                    <li><a href="#">
                            <i class="fas fa-cog"></i>
                            <span class="nav-item">Configurações</span>
                        </a>
                    </li>
                    <li><a href="#">
                            <i class="fas fa-question-circle"></i>
                            <span class="nav-item">Help</span>
                        </a>
                    </li>
                    <li><a href="../../index.php" target="_blank">
                            <i class="fas fa-globe"></i>
                            <span class="nav-item">Página Index</span>
                        </a>
                    </li>
                    <li><a href="../../logout.php" class="logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="nav-item">Sair</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="main">
            <div class="main-top">
                <p>Painel Administrativo</p>
            </div>
        </section>
    </div>
</body>

</html>