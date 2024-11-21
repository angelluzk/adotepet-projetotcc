<?php
require_once '../../crud/config/DataBase.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Usuário não autenticado.']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$imgBasePath = '../../';

try {
    $db = new DataBase();
    $conn = $db->getConnection();

    $query = "
    SELECT 
        p.id, p.nome, 
        (SELECT MIN(f.url) FROM fotos f WHERE f.pet_id = p.id) AS imagem,
        s.nome AS status
    FROM favoritos fav
    INNER JOIN pets p ON fav.pet_id = p.id
    LEFT JOIN status s ON p.status_id = s.id
    WHERE fav.usuario_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $favoritos = [];
    while ($row = $result->fetch_assoc()) {
        if ($row['imagem']) {
            $row['imagem'] = $imgBasePath . $row['imagem'];
        } else {
            $row['imagem'] = '../../img/default-pet.png';
        }
        $favoritos[] = $row;
    }

    echo json_encode($favoritos);
} catch (Exception $e) {
    echo json_encode(['error' => 'Erro ao buscar favoritos: ' . $e->getMessage()]);
}
?>