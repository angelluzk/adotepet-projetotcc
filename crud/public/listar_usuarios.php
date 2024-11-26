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

$resultado = $usuarioController->listar($searchTerm, $limit, $offset);
$usuarios = $resultado['usuarios'];
$totalUsuarios = $resultado['total'];
$totalPages = ceil($totalUsuarios / $limit);
?>

<div class="form-container">
    <h2>Lista de Usuários cadastrados</h2>

    <div class="form-buttons">
        <a href="../../crud/views/cadastro_usuario.php" class="btn-cadastrar-list" target="_blank">Cadastrar Novo
            Usuário</a>
    </div>
    <form method="GET" action="../../crud/public/listar_usuarios.php">
        <input type="text" name="search" placeholder="Pesquisar por ID, Nome ou CPF"
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
        <button class="btn-cadastrar-list" type="submit">Buscar</button>
    </form>
</div>
<div class="main-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Completo</th>
                <th>Data de Nascimento</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($usuarios) {
                foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['id']) ?></td>
                        <td><?= htmlspecialchars($usuario['nome_completo']) ?></td>
                        <td><?= htmlspecialchars((new DateTime($usuario['data_nascimento']))->format('d/m/Y')) ?></td>
                        <td><?= htmlspecialchars(formatCPF($usuario['cpf'])) ?></td>
                        <td><?= htmlspecialchars(formatTelefone($usuario['telefone'])) ?></td>
                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                        <td><?= htmlspecialchars($usuario['perfil_nome']) ?></td>
                        <td>
                            <a href="../public/visualizar_usuario.php?id=<?= $usuario['id'] ?>" class="btn-icone"
                                title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="../public/editar_usuario.php?id=<?= $usuario['id'] ?>" class="btn-icone" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="../public/deletar_usuario.php?id=<?= $usuario['id'] ?>" class="btn-icone" title="Deletar"
                                onclick="return confirm('Tem certeza que deseja deletar este usuário?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
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
        <?php
        $start = max(1, $page - 2);
        $end = min($totalPages, $page + 2);

        if ($page > 1): ?>
            <a href="?page=1&search=<?= urlencode($searchTerm) ?>">
                <<< </a>
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
</div>