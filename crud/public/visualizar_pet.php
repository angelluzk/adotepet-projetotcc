<?php
require_once '../../crud/config/DataBase.php';

$database = new DataBase();
$conn = $database->getConnection();

const IMG_BASE_PATH = 'http://localhost/adotepet-projetotcc/';

if (!isset($_GET['pet_id'])) {
    die("Pet ID não fornecido.");
}

$pet_id = intval($_GET['pet_id']);

$query = "
    SELECT 
        pets.id AS pet_id,
        pets.nome AS pet_nome,
        pets.raca,
        pets.porte,
        pets.sexo,
        pets.cor,
        pets.idade,
        pets.descricao,
        pets.criado_em,
        especie.nome AS especie_nome,
        usuarios.nome AS dono_nome,
        usuarios.sobrenome AS dono_sobrenome
    FROM pets
    INNER JOIN especie ON pets.especie_id = especie.id
    INNER JOIN doacoes ON pets.id = doacoes.pet_id
    INNER JOIN usuarios ON doacoes.usuario_id = usuarios.id
    WHERE pets.id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pet_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Pet não encontrado.");
}

$pet = $result->fetch_assoc();

$queryFotos = "SELECT url FROM fotos WHERE pet_id = ?";
$stmtFotos = $conn->prepare($queryFotos);
$stmtFotos->bind_param("i", $pet_id);
$stmtFotos->execute();
$resultFotos = $stmtFotos->get_result();

$fotos = [];
while ($row = $resultFotos->fetch_assoc()) {
    $fotos[] = IMG_BASE_PATH . $row['url'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pet</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="pet-details">
        <h1>Detalhes do Pet</h1>
        <p><strong>Nome:</strong> <?= htmlspecialchars($pet['pet_nome']) ?></p>
        <p><strong>Espécie:</strong> <?= htmlspecialchars($pet['especie_nome']) ?></p>
        <p><strong>Raça:</strong> <?= htmlspecialchars($pet['raca']) ?></p>
        <p><strong>Porte:</strong> <?= htmlspecialchars($pet['porte']) ?></p>
        <p><strong>Sexo:</strong> <?= htmlspecialchars($pet['sexo']) ?></p>
        <p><strong>Cor:</strong> <?= htmlspecialchars($pet['cor']) ?></p>
        <p><strong>Idade:</strong> <?= htmlspecialchars($pet['idade']) ?> anos</p>
        <p><strong>Descrição:</strong> <?= htmlspecialchars($pet['descricao']) ?></p>
        <p><strong>Criado em:</strong> <?= htmlspecialchars($pet['criado_em']) ?></p>
        <h2>Dono do Pet</h2>
        <p><strong>Nome do Dono:</strong> <?= htmlspecialchars($pet['dono_nome'] . ' ' . $pet['dono_sobrenome']) ?></p>
        <h2>Fotos do Pet</h2>
        <div class="pet-photos">
            <?php foreach ($fotos as $foto): ?>
                <img src="<?= htmlspecialchars($foto) ?>" alt="Foto do Pet">
            <?php endforeach; ?>
        </div>
        <a href="../../crud/views/painel_admin.php" class="btn-voltar">Voltar</a>
    </div>
</body>

</html>