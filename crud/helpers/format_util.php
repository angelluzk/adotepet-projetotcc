<?php
function formatCPF($cpf) {
    $cpf = preg_replace('/\D/', '', $cpf);
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

function formatTelefone($telefone) {
    $telefone = preg_replace('/\D/', '', $telefone);
    if (strlen($telefone) == 11) {
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
    }
    return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
}

function formatDateTime($dateTime) {
    if (!$dateTime) {
        return '';
    }
    $date = new DateTime($dateTime);
    return $date->format('d/m/Y H:i:s');
}
?>