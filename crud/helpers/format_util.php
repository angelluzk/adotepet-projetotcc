<?php
function formatCPF($cpf): array|string|null {
    $cpf = preg_replace(pattern: '/\D/', replacement: '', subject: $cpf);
    return preg_replace(pattern: '/(\d{3})(\d{3})(\d{3})(\d{2})/', replacement: '$1.$2.$3-$4', subject: $cpf);
}

function formatTelefone($telefone): array|string|null {
    $telefone = preg_replace(pattern: '/\D/', replacement: '', subject: $telefone);
    if (strlen(string: $telefone) == 11) {
        return preg_replace(pattern: '/(\d{2})(\d{5})(\d{4})/', replacement: '($1) $2-$3', subject: $telefone);
    }
    return preg_replace(pattern: '/(\d{2})(\d{4})(\d{4})/', replacement: '($1) $2-$3', subject: $telefone);
}
?>