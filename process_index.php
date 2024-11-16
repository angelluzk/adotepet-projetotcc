<?php
$baseUrl = 'http://localhost/adotepet-projetotcc/';

require_once 'crud/config/DataBase.php';
session_start();

$isLoggedIn = isset($_SESSION['usuario_id']);
$userName = $isLoggedIn ? $_SESSION['usuario_nome'] : 'Visitante';
$userPhoto = 'img/default-photo.png';
$userType = $isLoggedIn ? $_SESSION['perfil_nome'] : null;

$db = new DataBase();
$conn = $db->getConnection();

$sql = "
    SELECT 
        p.id AS pet_id, 
        p.nome AS pet_nome, 
        MIN(f.url) AS foto_url, 
        e.bairro, 
        e.estado, 
        p.criado_em, 
        s.nome AS status_nome
    FROM pets p
    INNER JOIN doacoes d ON p.id = d.pet_id
    INNER JOIN enderecos e ON d.endereco_id = e.id
    INNER JOIN fotos f ON p.id = f.pet_id
    INNER JOIN status s ON p.status_id = s.id
    WHERE s.nome = 'Disponível'
    GROUP BY p.id
    ORDER BY p.criado_em DESC
    LIMIT 4";

$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$pets = [];
while ($row = $result->fetch_assoc()) {
    $pets[] = $row;
}

$stmt->close();
$db->closeConnection();

function time_ago($timestamp)
{
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);
    $hours = round($seconds / 3600);
    $days = round($seconds / 86400);
    $weeks = round($seconds / 604800);
    $months = round($seconds / 2629440);
    $years = round($seconds / 31553280);

    if ($seconds <= 60) {
        return "Agora mesmo";
    } else if ($minutes <= 60) {
        return "$minutes minutos atrás";
    } else if ($hours <= 24) {
        return "$hours horas atrás";
    } else if ($days <= 7) {
        return "$days dias atrás";
    } else if ($weeks <= 4.3) {
        return "$weeks semanas atrás";
    } else if ($months <= 12) {
        return "$months meses atrás";
    } else {
        return "$years anos atrás";
    }
}
?>