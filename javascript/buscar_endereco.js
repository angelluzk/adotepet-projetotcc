$(document).ready(function() {
    $('#cep').on('input', function() {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep.length === 8) {
            buscarEnderecoPorCep(cep);
        } else {
            $('#logradouro').val('');
            $('#bairro').val('');
            $('#localidade').val('');
            $('#uf').val('');
        }
    });

    function buscarEnderecoPorCep(cep) {
        $.ajax({
            url: `https://viacep.com.br/ws/${cep}/json/`,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if (!data.erro) {
                    $('#logradouro').val(data.logradouro || '');
                    $('#bairro').val(data.bairro || '');
                    $('#localidade').val(data.localidade || '');
                    $('#uf').val(data.uf || '');
                } else {
                    alert('Endereço não encontrado para o CEP informado.');
                }
            },
            error: function() {
                alert('Erro ao buscar o endereço. Tente novamente.');
            }
        });
    }
});