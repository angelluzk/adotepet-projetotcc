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
                        </a>
                    </li>
                    <li><a href="listar_usuarios.php">
                            <i class="fas fa-user"></i>
                            <span class="nav-item">Usuários</span>
                        </a>
                    </li>
                    <li><a href="#">
                            <i class="fas fa-tasks"></i>
                            <span class="nav-item">Aprovar Doações</span>
                        </a>
                    </li>
                    <li><a href="listar_doacoes.php">
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
            
            <div class="list-container">
                <h2>Pets Cadastrados</h2>
                
                <form method="GET" action="listar_doacoes.php">
                    <input type="text" name="search" placeholder="Pesquisar doações..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                    <button type="submit">Buscar</button>
                </form>

                <a href="../../crud/views/cadastro_doacoes.php" class="btn-cadastrar" target="_blank">Cadastrar Nova Doação</a>
                
                <table>
                    <thead>
                        <tr>
                            <th>ID do Pet</th>
                            <th>Nome do Pet</th> <!-- Nome do pet adicionado -->
                            <th>Nome Protetor</th>
                            <th>Espécie</th>
                            <th>Raça</th>
                            <th>Cor</th>
                            <th>Idade</th>
                            <th>Porte</th> <!-- Porte adicionado -->
                            <th>Sexo</th> <!-- Sexo adicionado -->
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require '../config/DataBase.php';
                        require '../controllers/PetController.php';

                        $database = new DataBase();
                        $db = $database->getConnection();

                        $petController = new PetController($db);

                        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                        $limit = 8;
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;

                        $doacoes = $petController->listarDoacoes($searchTerm, $limit, $offset);
                        $totalDoacoes = $petController->contarDoacoes($searchTerm);
                        $totalPages = ceil($totalDoacoes / $limit);

                        if ($doacoes) {
                            foreach ($doacoes as $doacao) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($doacao['pet_id']) ?></td>
                                    <td><?= htmlspecialchars($doacao['nome_pet']) ?></td> <!-- Nome do pet exibido -->
                                    <td><?= htmlspecialchars($doacao['usuario_nome'] . ' ' . $doacao['usuario_sobrenome']) ?></td>
                                    <td><?= htmlspecialchars($doacao['especie_nome']) ?></td>
                                    <td><?= htmlspecialchars($doacao['raca']) ?></td>
                                    <td><?= htmlspecialchars($doacao['cor']) ?></td>
                                    <td><?= htmlspecialchars($doacao['idade']) ?> anos</td>
                                    <td><?= htmlspecialchars($doacao['porte']) ?></td> <!-- Porte exibido -->
                                    <td><?= htmlspecialchars($doacao['sexo']) ?></td> <!-- Sexo exibido -->
                                    <td><?= (new DateTime($doacao['data']))->format('d/m/Y') ?></td>
                                    <td>
                                        <a href="../public/visualizar_doacao.php?id=<?= $doacao['id'] ?>" class="btn-acoes">Visualizar</a>
                                        <a href="../public/editar_doacao.php?id=<?= $doacao['id'] ?>" class="btn-acoes">Editar</a>
                                        <a href="../public/deletar_doacao.php?id=<?= $doacao['id'] ?>" class="btn-acoes" onclick="return confirm('Tem certeza que deseja deletar esta doação?');">Deletar</a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } else {
                            echo "<tr><td colspan='11'>Nenhuma doação encontrada.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <a href="?page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </section>
    </div>
</body>

</html>