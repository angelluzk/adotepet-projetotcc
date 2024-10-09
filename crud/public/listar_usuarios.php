<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adote Pet - Painel Admin</title>
    <link rel="stylesheet" href="../../css/painel_admin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <div class="container">
        <nav>
            <div class="navbar">
                <div class="logo">
                    <img src="../../img/logo.png" alt="Logo">
                </div>
                <ul>
                    <li><a href="../../crud/views/painel_admin.php">
                            <i class="fas fa-home"></i>
                            <span class="nav-item">HOME</span>
                        </a></li>
                    <li><a href="listar_usuarios.php">
                            <i class="fas fa-user"></i>
                            <span class="nav-item">Usuários</span>
                        </a></li>
                    <li><a href="#">
                            <i class="fas fa-tasks"></i>
                            <span class="nav-item">Aprovar Doações</span>
                        </a></li>
                    <li><a href="listar_doacoes.php">
                            <i class="fas fa-paw"></i>
                            <span class="nav-item">Pets Cadastrados</span>
                        </a></li>
                    <li><a href="#">
                            <i class="fas fa-cog"></i>
                            <span class="nav-item">Configurações</span>
                        </a></li>
                    <li><a href="#">
                            <i class="fas fa-question-circle"></i>
                            <span class="nav-item">Help</span>
                        </a></li>
                    <li><a href="../../index.php" target="blank_">
                            <i class="fas fa-globe"></i>
                            <span class="nav-item">Página Index</span>
                        </a></li>
                    <li><a href="../../logout.php" class="logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="nav-item">Sair</span>
                        </a></li>
                </ul>
            </div>
        </nav>
        <section class="main">
            <div class="main-top">
                <p>Painel Administrativo</p>
            </div>

            <div class="list-container">
                <h2>Lista de Usuários</h2>

                <form method="GET" action="listar_usuarios.php">
                    <input type="text" name="search" placeholder="Pesquisar por ID, Nome ou CPF"
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                    <button type="submit">Buscar</button>
                </form>

                <a href="../../crud/views/cadastro_usuario.php" class="btn-cadastrar" target="_blank">Cadastrar Novo Usuário</a>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome Completo</th>
                            <th>Data de Nascimento</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Data de Criação</th>
                            <th>Perfil</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require '../config/DataBase.php';
                        require '../controllers/UsuarioController.php';
                        require '../helpers/format_util.php';

                        $database = new DataBase();
                        $db = $database->getConnection();

                        $usuarioController = new UsuarioController($db);

                        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                        $limit = 8;
                        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;

                        $usuarios = $usuarioController->listarUsuarios($searchTerm, $limit, $offset);
                        $totalUsuarios = $usuarioController->contarUsuarios($searchTerm);
                        $totalPages = ceil($totalUsuarios / $limit);

                        if ($usuarios) {
                            foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['id']) ?></td>
                                    <td><?= htmlspecialchars($usuario['nome_completo']) ?></td>
                                    <td><?= htmlspecialchars((new DateTime($usuario['data_nascimento']))->format('d/m/Y')) ?>
                                    </td>
                                    <td><?= htmlspecialchars(formatCPF($usuario['cpf'])) ?></td>
                                    <td><?= htmlspecialchars(formatTelefone($usuario['telefone'])) ?></td>
                                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                                    <td><?= (new DateTime($usuario['criado_em']))->format('d/m/Y') ?></td>
                                    <td><?= htmlspecialchars($usuario['perfil_nome']) ?></td>
                                    <td>
                                        <a href="../public/visualizar_usuario.php?id=<?= $usuario['id'] ?>"
                                            class="btn-acoes">Visualizar</a>
                                        <a href="../public/editar_usuario.php?id=<?= $usuario['id'] ?>"
                                            class="btn-acoes">Editar</a>
                                        <a href="../public/deletar_usuario.php?id=<?= $usuario['id'] ?>" class="btn-acoes"
                                            onclick="return confirm('Tem certeza que deseja deletar este usuário?');">Deletar</a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } else {
                            echo "<tr><td colspan='9'>Nenhum usuário encontrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>"
                            class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </section>
    </div>
</body>

</html>