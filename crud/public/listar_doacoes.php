<?php
require '../config/DataBase.php';
require '../controllers/PetController.php';

$database = new DataBase();
$db = $database->getConnection();

$petController = new PetController($db);

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 8;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$doacoes = $petController->listarDoacoes($searchTerm, $limit, $offset);
$totalDoacoes = $petController->contarDoacoes($searchTerm);
$totalPages = ceil($totalDoacoes / $limit);
?>

<div class="form-container">
    <h2>Lista de Doações</h2>

    <div class="form-buttons">
        <a href="../../crud/views/cadastro_doacoes.php" class="btn-cadastrar-list" target="_blank">Cadastrar Nova
            Doação</a>
    </div>
    <form method="GET" action="listar_doacoes.php">
        <input type="text" name="search" placeholder="Pesquisar doações..."
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
        <button class="btn-cadastrar-list" type="submit">Buscar</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome do Pet</th>
            <th>Nome Protetor</th>
            <th>Espécie</th>
            <th>Raça</th>
            <th>Cor</th>
            <th>Idade</th>
            <th>Porte</th>
            <th>Sexo</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($doacoes) {
            foreach ($doacoes as $doacao): ?>
                <tr>
                    <td><?= htmlspecialchars($doacao['pet_id']) ?></td>
                    <td><?= htmlspecialchars($doacao['nome_pet']) ?></td>
                    <td><?= htmlspecialchars($doacao['usuario_nome'] . ' ' . $doacao['usuario_sobrenome']) ?></td>
                    <td><?= htmlspecialchars($doacao['especie_nome']) ?></td>
                    <td><?= htmlspecialchars($doacao['raca']) ?></td>
                    <td><?= htmlspecialchars($doacao['cor']) ?></td>
                    <td><?= htmlspecialchars($doacao['idade']) ?> anos</td>
                    <td><?= htmlspecialchars($doacao['porte']) ?></td>
                    <td><?= htmlspecialchars($doacao['sexo']) ?></td>
                    <td><?= (new DateTime($doacao['data']))->format('d/m/Y') ?></td>
                    <td>
                        <a href="../public/visualizar_doacao.php?id=<?= $doacao['id'] ?>" class="btn-icone" title="Visualizar">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="../public/editar_doacao.php?id=<?= $doacao['id'] ?>" class="btn-icone" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="../public/deletar_doacao.php?id=<?= $doacao['id'] ?>" class="btn-icone" title="Deletar"
                            onclick="return confirm('Tem certeza que deseja deletar esta doação?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
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
    <?php 
    $start = max(1, $page - 2);
    $end = min($totalPages, $page + 2);

    if ($page > 1): ?>
        <a href="?page=1&search=<?= urlencode($searchTerm) ?>"><<</a>
    <?php endif; ?>

    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($searchTerm) ?>">Anterior</a>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
        <a href="?page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>"
           class="<?= ($i == $page) ? 'active' : '' ?>">
           <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($searchTerm) ?>">Próximo</a>
    <?php endif; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $totalPages ?>&search=<?= urlencode($searchTerm) ?>">>></a>
    <?php endif; ?>
</div>