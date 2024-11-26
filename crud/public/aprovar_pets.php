<?php
require '../config/DataBase.php';

$database = new DataBase();
$conn = $database->getConnection();

$recordsPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$offset = ($page - 1) * $recordsPerPage;

$totalQuery = "
    SELECT COUNT(DISTINCT pets.id) AS total 
    FROM pets
    INNER JOIN especie ON pets.especie_id = especie.id
    INNER JOIN doacoes ON pets.id = doacoes.pet_id
    INNER JOIN usuarios ON doacoes.usuario_id = usuarios.id
    WHERE pets.status_id = (SELECT id FROM status WHERE nome = 'Em análise')
    AND (pets.nome LIKE ? OR especie.nome LIKE ?)
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
    SELECT 
        pets.id AS pet_id,
        pets.nome AS pet_nome,
        especie.nome AS especie,
        CONCAT(usuarios.nome, ' ', usuarios.sobrenome) AS dono_nome_completo,
        MAX(fotos.url) AS foto
    FROM pets
    INNER JOIN especie ON pets.especie_id = especie.id
    INNER JOIN doacoes ON pets.id = doacoes.pet_id
    INNER JOIN usuarios ON doacoes.usuario_id = usuarios.id
    LEFT JOIN fotos ON pets.id = fotos.pet_id
    WHERE pets.status_id = (SELECT id FROM status WHERE nome = 'Em análise')
    AND (pets.nome LIKE ? OR especie.nome LIKE ?)
    GROUP BY pets.id, pets.nome, especie.nome, usuarios.nome, usuarios.sobrenome
    LIMIT ? OFFSET ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssii", $searchWildcard, $searchWildcard, $recordsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="form-container">
    <h2>Lista de doações para aprovação</h2>
    <form method="GET" action="aprovar_pets.php">
        <input type="text" name="search" placeholder="Pesquisar por nome ou espécie"
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
        <button class="btn-cadastrar-list" type="submit">Buscar</button>
    </form>
</div>

<div class="main-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Animal</th>
                <th>Nome do Dono</th>
                <th>Espécie</th>
                <th>Foto</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($pet = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($pet['pet_id']) ?></td>
                        <td><?= htmlspecialchars($pet['pet_nome']) ?></td>
                        <td><?= htmlspecialchars($pet['dono_nome_completo']) ?></td>
                        <td><?= htmlspecialchars($pet['especie']) ?></td>
                        <td>
                            <?php
                            $url = $pet['foto'];
                            $maxLength = 30;
                            echo htmlspecialchars(strlen($url) > $maxLength ? substr($url, 0, $maxLength) . '...' : $url);
                            ?>
                        </td>
                        <td>
                            <a href="../../crud/public/visualizar_pet.php?pet_id=<?= $pet['pet_id'] ?>" class="btn-icone"
                                title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn-icone approve-btn" data-pet-id="<?= $pet['pet_id'] ?>" data-action="Disponível"
                                title="Aprovar">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn-icone reject-btn" data-pet-id="<?= $pet['pet_id'] ?>" data-action="Rejeitado"
                                title="Rejeitar">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum pet encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php
        $start = max(1, $page - 2);
        $end = min($totalPages, $page + 2);

        if ($page > 1): ?>
            <a href="?page=1&search=<?= urlencode($searchTerm) ?>">
                <<< </a>
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
                    <a href="?page=<?= $totalPages ?>&search=<?= urlencode($searchTerm) ?>">>>></a>
                <?php endif; ?>
    </div>
</div>

<div id="toast" class="toast hidden"></div>