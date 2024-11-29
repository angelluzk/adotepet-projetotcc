<?php
require_once '../config/DataBase.php';

class PetConsulta
{
    private $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function buscarPets($especie = null, $sexo = null, $porte = null, $idade = null)
    {
        $query = "
        SELECT 
            p.id, p.nome, p.porte, p.idade, 
            (SELECT f.url FROM fotos f WHERE f.pet_id = p.id LIMIT 1) AS url,
            IFNULL(e.bairro, 'N/A') AS bairro,
            IFNULL(e.estado, 'N/A') AS estado,
            es.nome AS especie_nome,
            s.nome AS status_nome
        FROM pets p
        LEFT JOIN doacoes d ON p.id = d.pet_id
        LEFT JOIN enderecos e ON d.endereco_id = e.id
        LEFT JOIN especie es ON p.especie_id = es.id
        LEFT JOIN status s ON p.status_id = s.id
        WHERE s.nome IN ('Disponível', 'Em adoção', 'Adotado')
    ";

        $params = [];
        $types = [];

        $filters = [];
        if ($especie) {
            $filters[] = "es.nome = ?";
            $params[] = $especie;
            $types[] = "s";
        }
        if ($sexo) {
            $filters[] = "p.sexo = ?";
            $params[] = $sexo;
            $types[] = "s";
        }
        if ($porte) {
            $filters[] = "p.porte = ?";
            $params[] = $porte;
            $types[] = "s";
        }
        if ($idade) {
            switch ($idade) {
                case 'filhote':
                    $filters[] = "p.idade <= 1";
                    break;
                case 'jovem':
                    $filters[] = "p.idade > 1 AND p.idade <= 3";
                    break;
                case 'adulto':
                    $filters[] = "p.idade > 3 AND p.idade <= 7";
                    break;
                case 'idoso':
                    $filters[] = "p.idade >= 7";
                    break;
            }
        }

        if (!empty($filters)) {
            $query .= " WHERE " . implode(" AND ", $filters);
        }

        $stmt = $this->db->getConnection()->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param(implode("", $types), ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        $pets = [];
        while ($row = $result->fetch_assoc()) {
            $pets[] = $row;
        }

        echo json_encode($pets);
    }
}

$especie = $_GET['especie'] ?? null;
$sexo = $_GET['sexo'] ?? null;
$porte = $_GET['porte'] ?? null;
$idade = $_GET['idade'] ?? null;

$controller = new PetConsulta();
$controller->buscarPets($especie, $sexo, $porte, $idade);
?>