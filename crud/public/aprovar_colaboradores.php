<?php
require '../config/DataBase.php';

$database = new DataBase();
$conn = $database->getConnection();

$recordsPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$offset = ($page - 1) * $recordsPerPage;

$totalQuery = "
    SELECT COUNT(DISTINCT u.id) AS total
    FROM usuarios u
    LEFT JOIN status s ON u.status_id = s.id
    WHERE u.perfil_id = 1 AND u.status_id NOT IN (5, 6) 
    AND (u.nome LIKE ? OR u.email LIKE ?)
";
$totalStmt = $conn->prepare($totalQuery);
$searchWildcard = "%$searchTerm%";
$totalStmt->bind_param("ss", $searchWildcard, $searchWildcard);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

$query = "
    SELECT u.id, u.nome, u.email, s.nome AS status
    FROM usuarios u
    LEFT JOIN status s ON u.status_id = s.id
    WHERE u.perfil_id = 1 AND u.status_id NOT IN (5, 6)
    AND (u.nome LIKE ? OR u.email LIKE ?)
    LIMIT ? OFFSET ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssii", $searchWildcard, $searchWildcard, $recordsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="form-container">
    <h2>Lista de colaboradores para aprovação</h2>
    <form method="GET" action="aprovar_colaboradores.php">
        <input type="text" name="search" placeholder="Pesquisar por nome ou email"
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
        <button class="btn-cadastrar-list" type="submit">Buscar</button>
    </form>
</div>

<div class="main-container">
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Status Atual</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nome']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['status'] ?? 'Pendente') ?></td>
                        <td>
                            <a href="../../crud/public/visualizar_colaborador.php?id=<?= $row['id'] ?>" class="btn-icone visualizar-btn" title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn-icone approve-btn" data-user-id="<?= $row['id'] ?>" data-action="5" title="Aprovar">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn-icone reject-btn" data-user-id="<?= $row['id'] ?>" data-action="6" title="Rejeitar">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum colaborador encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php
        $start = max(1, $page - 2);
        $end = min($totalPages, $page + 2);

        if ($page > 1): ?>
            <a href="?page=1&search=<?= urlencode($searchTerm) ?>"><<<</a>
            <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($searchTerm) ?>">Anterior</a>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>" class="<?= ($i == $page) ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($searchTerm) ?>">Próximo</a>
            <a href="?page=<?= $totalPages ?>&search=<?= urlencode($searchTerm) ?>">>>></a>
        <?php endif; ?>
    </div>
</div>

<div id="toast" class="toast hidden"></div>
