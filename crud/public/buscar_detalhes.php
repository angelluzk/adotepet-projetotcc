<?php
require_once '../config/DataBase.php';
require_once '../helpers/format_util.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $db = new DataBase();
    $conn = $db->getConnection();

    $query = "
    SELECT 
        p.nome, p.porte, p.idade, p.sexo, p.descricao, p.raca, p.cor,
        (SELECT MIN(f.url) FROM fotos f WHERE f.pet_id = p.id) AS url_principal,
        GROUP_CONCAT(f.url) AS urls,
        es.nome AS especie,
        u.nome AS protetor_nome, u.sobrenome AS protetor_sobrenome, u.email AS protetor_email, u.telefone AS protetor_telefone,
        e.logradouro, e.bairro, e.localidade, e.uf, e.estado,
        st.nome AS status
    FROM pets p
    LEFT JOIN fotos f ON p.id = f.pet_id
    LEFT JOIN especie es ON p.especie_id = es.id
    LEFT JOIN doacoes d ON p.id = d.pet_id
    LEFT JOIN usuarios u ON d.usuario_id = u.id
    LEFT JOIN enderecos e ON d.endereco_id = e.id
    LEFT JOIN status st ON p.status_id = st.id
    WHERE p.id = ?
    GROUP BY p.id
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pet = $result->fetch_assoc();

        $pet['protetor_telefone'] = formatTelefone($pet['protetor_telefone']);

        $pet['urls'] = explode(',', $pet['urls']);

        echo json_encode($pet);
    } else {
        echo json_encode(['error' => 'Animal não encontrado.']);
    }
} else {
    echo json_encode(['error' => 'ID do animal não fornecido.']);
}
?>