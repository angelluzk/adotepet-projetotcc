$(document).ready(function() {
    $('#cep').on('input', function() {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep.length === 8) {
            buscarEnderecoPorCep(cep);
        } else {
            $('#logradouro').val('');
            $('#bairro').val('');
            $('#localidade').val('');
            $('#estado').val('');
            $('#uf').val('');
        }
    });

    function buscarEnderecoPorCep(cep) {
        $.ajax({
            url: `https://viacep.com.br/ws/${cep}/json/`,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (!data.erro) {
                    $('#logradouro').val(data.logradouro || '');
                    $('#bairro').val(data.bairro || '');
                    $('#localidade').val(data.localidade || '');
                    $('#uf').val(data.uf || '');
                    $('#estado').val(obterNomeEstado(data.uf) || '');
                } else {
                    alert('Endereço não encontrado para o CEP informado.');
                }
            },
            error: function() {
                alert('Erro ao buscar o endereço. Tente novamente.');
            }
        });
    }

    function obterNomeEstado(uf) {
        const estados = {
            'AC': 'Acre',
            'AL': 'Alagoas',
            'AP': 'Amapá',
            'AM': 'Amazonas',
            'BA': 'Bahia',
            'CE': 'Ceará',
            'DF': 'Distrito Federal',
            'ES': 'Espírito Santo',
            'GO': 'Goiás',
            'MA': 'Maranhão',
            'MT': 'Mato Grosso',
            'MS': 'Mato Grosso do Sul',
            'MG': 'Minas Gerais',
            'PA': 'Pará',
            'PB': 'Paraíba',
            'PR': 'Paraná',
            'PE': 'Pernambuco',
            'PI': 'Piauí',
            'RJ': 'Rio de Janeiro',
            'RN': 'Rio Grande do Norte',
            'RS': 'Rio Grande do Sul',
            'RO': 'Rondônia',
            'RR': 'Roraima',
            'SC': 'Santa Catarina',
            'SP': 'São Paulo',
            'SE': 'Sergipe',
            'TO': 'Tocantins'
        };
        return estados[uf] || '';
    }
});