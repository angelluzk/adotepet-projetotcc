<?php
require_once '../config/DataBase.php';
session_start();

$isLoggedIn = isset($_SESSION['usuario_id']);
$userName = $isLoggedIn ? $_SESSION['usuario_nome'] : 'Visitante';
$userPhoto = '../../img/default-photo.png';

$database = new DataBase();
$conn = $database->getConnection();

$query = "SELECT COUNT(*) FROM usuarios";
$result = $conn->query($query);
$usuarios_count = $result->fetch_row()[0];

$query = "SELECT COUNT(*) FROM pets";
$result = $conn->query($query);
$pets_count = $result->fetch_row()[0];

$query = "
    SELECT COUNT(*) 
    FROM pets
    WHERE status_id = (SELECT id FROM status WHERE
    nome = 'Adotado')
    ";
$result = $conn->query($query);
$doacoes_count = $result->fetch_row()[0];

$query = "
    SELECT COUNT(*) 
    FROM pets 
    WHERE status_id = (SELECT id FROM status WHERE nome = 'Em análise')
";
$result = $conn->query($query);
$pendencias_count = $result->fetch_row()[0];

$query = "SELECT nome FROM usuarios ORDER BY id DESC LIMIT 1";
$result = $conn->query($query);
$ultimo_usuario = $result->num_rows > 0 ? $result->fetch_assoc()['nome'] : 'Nenhum usuário cadastrado';

$query = "SELECT nome FROM pets ORDER BY id DESC LIMIT 1";
$result = $conn->query($query);
$ultimo_pet = $result->num_rows > 0 ? $result->fetch_assoc()['nome'] : 'Nenhum animal cadastrado';

$query = "
    SELECT p.nome 
    FROM pets p 
    WHERE p.status_id = (SELECT id FROM status WHERE nome = 'Adotado') 
    ORDER BY p.id DESC 
    LIMIT 1";
$result = $conn->query($query);
$ultimo_pet_adotado = $result->num_rows > 0 ? $result->fetch_assoc()['nome'] : 'Nenhum animal adotado';

$query = "
    SELECT MONTH(d.data) AS mes, COUNT(*) AS total
    FROM doacoes d
    JOIN pets p ON d.pet_id = p.id
    GROUP BY MONTH(d.data)
";
$result = $conn->query($query);
$doacoes_por_mes = [];
while ($row = $result->fetch_assoc()) {
    $doacoes_por_mes[] = $row;
}

$labels = [];
$dados = [];
foreach ($doacoes_por_mes as $row) {
    $currentYear = date('Y');
    $labels[] = date('M', strtotime("$currentYear-$row[mes]-01"));
    $dados[] = $row['total'];
}
?>

<!-- Dashboard -->
<div class:="dashboard-container">
    <div class="welcome-message">
        <h2>Bem-vindo(a), <?php echo $userName; ?>!</h2>
        <p>Gerencie o sistema Adote Pet com eficiência e rapidez.</p>
    </div>

    <!-- Estatísticas Resumidas -->
    <div class="dashboard-stats">
        <div class="stat-item">
            <i class="fas fa-user"></i>
            <p>Usuários cadastrados</p>
            <h3 id="stat-usuarios"><?php echo $usuarios_count; ?></h3>
        </div>
        <div class="stat-item">
            <i class="fas fa-paw"></i>
            <p>Animais Cadastrados</p>
            <h3 id="stat-pets"><?php echo $pets_count; ?></h3>
        </div>
        <div class="stat-item">
            <i class="fas fa-hand-holding-heart"></i>
            <p>Total de Animais Adotados</p>
            <h3 id="stat-doacoes"><?php echo $doacoes_count; ?></h3>
        </div>
        <div class="stat-item">
            <i class="fas fa-exclamation-circle"></i>
            <p>Pendências</p>
            <h3 id="stat-pendencias"><?php echo $pendencias_count; ?></h3>
        </div>
    </div>

    <!-- Atalhos Rápidos -->
    <div class="quick-actions">
        <h3>Atalhos Rápidos</h3>
        <a href="#" onclick="loadSection('aprovar_pets')" class="btn"><i class="fas fa-check-circle"></i> Aprovar
            Doações</a>
        <a href="#" onclick="loadSection('listar_usuarios')" class="btn"><i class="fas fa-user"></i> Gerenciar
            Usuários</a>
        <a href="#" onclick="loadSection('listar_doacoes')" class="btn"><i class="fas fa-paw"></i> Gerenciar Pets</a>
    </div>

    <div class="dashboard-sections">
        <!-- Notificações Recentes -->
        <div class="notifications">
            <h3>Notificações Recentes</h3>
            <ul>
                <li><i class="fas fa-user"></i> Novo usuário cadastrado: <strong><?php echo $ultimo_usuario; ?></strong>
                </li>
                <li><i class="fas fa-paw"></i> Novo animal cadastrado: <strong><?php echo $ultimo_pet; ?></strong></li>
                <li><i class="fas fa-hand-holding-heart"></i> Ultimo animal adotado:
                    <strong><?php echo $ultimo_pet_adotado; ?></strong>
                </li>
            </ul>
        </div>

        <!-- Últimos Pets Cadastrados -->
        <div class="recent-pets">
            <h3>Últimos Animais Cadastrados</h3>
            <ul>
                <?php
                $query = "SELECT nome, status_id FROM pets ORDER BY id DESC LIMIT 5";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    if ($row['status_id'] == 1) {
                        $status = 'Disponível';
                        $icon = 'fas fa-paw';
                        $color = '#3498db';
                    } elseif ($row['status_id'] == 2) {
                        $status = 'Em Análise';
                        $icon = 'fas fa-hourglass-half';
                        $color = '#f39c12';
                    } elseif ($row['status_id'] == 3) {
                        $status = 'Em Adoção';
                        $icon = 'fas fa-heart';
                        $color = '#e74c3c';
                    } elseif ($row['status_id'] == 4) {
                        $status = 'Adotado';
                        $icon = 'fas fa-check-circle';
                        $color = '#2ecc71';
                    }

                    echo "<li><i class='$icon' style='color: $color; margin-right: 8px;'></i><strong>{$row['nome']}</strong>  : Status: {$status}</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Tarefas Pendentes -->
        <div class="pending-tasks">
            <h3>Tarefas Pendentes</h3>
            <ul>
                <?php
                $query = "
            SELECT p.nome AS pet_nome, u.nome AS usuario_nome
            FROM pets p
            JOIN doacoes d ON p.id = d.pet_id
            JOIN usuarios u ON d.usuario_id = u.id
            WHERE p.status_id = (SELECT id FROM status WHERE nome = 'Em análise')
            ORDER BY p.id DESC LIMIT 5
        ";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<li><i class='fas fa-check-circle'></i> Aprovar adoção do animal <strong>{$row['pet_nome']}</strong> (Usuário: <strong>{$row['usuario_nome']}</strong>)</li>";
                    }
                } else {
                    echo "<li><i class='fas fa-info-circle'></i> Não há adoções pendentes.</li>";
                }

                $query = "
            SELECT u.nome 
            FROM usuarios u
            JOIN doacoes d ON u.id = d.usuario_id
            JOIN pets p ON d.pet_id = p.id
            WHERE p.status_id = (SELECT id FROM status WHERE nome = 'Em análise')
            ORDER BY u.id DESC LIMIT 5
        ";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<li><i class='fas fa-exclamation-circle'></i> Revisar cadastro do usuário <strong>{$row['nome']}</strong></li>";
                    }
                } else {
                    echo "<li><i class='fas fa-info-circle'></i> Não há usuários pendentes para revisão.</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>