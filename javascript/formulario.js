document.addEventListener("DOMContentLoaded", () => {
    const formSteps = document.querySelectorAll(".form-step");
    const btnCadastrar = document.querySelector(".btn.cadastrar");
    let currentStep = 0;

    function isFormValid(step) {
        const inputs = formSteps[step].querySelectorAll("input[required], select[required]");
        for (let input of inputs) {
            if (input.offsetParent === null) continue;
            if (!input.value.trim()) {
                alert(`O campo ${input.name} está vazio.`);
                return false;
            }
        }
        return true;
    }

    btnCadastrar.addEventListener("click", (event) => {
        event.preventDefault();

        for (let step = 0; step < formSteps.length; step++) {
            if (!isFormValid(step)) {
                alert("Por favor, preencha todos os campos obrigatórios.");
                return;
            }
        }

        if (!validateForm()) {
            return;
        }

        document.getElementById("formCadastro").submit();
    });
});

function validateForm() {
    const cpf = document.getElementById('cpf').value.replace(/\D/g, '');
    const telefone = document.getElementById('telefone').value.replace(/\D/g, '');
    const cep = document.getElementById('cep').value.replace(/\D/g, '');

    const cpfRegex = /^\d{11}$/;
    const telefoneRegex = /^\d{10,11}$/;
    const cepRegex = /^(\d{5}-\d{3}|\d{8})$/;

    if (!cpfRegex.test(cpf)) {
        alert("CPF inválido. Deve conter exatamente 11 dígitos.");
        return false;
    }

    if (!telefoneRegex.test(telefone)) {
        alert("Telefone inválido. Deve conter 10 ou 11 dígitos.");
        return false;
    }

    if (!cepRegex.test(cep)) {
        alert("CEP inválido. Deve seguir o formato 99999-999 ou 99999999.");
        return false;
    }

    return true;
}

$(document).ready(function () {
    $('#cpf').inputmask('999.999.999-99', { placeholder: '___.___.___-__' });
    $('#telefone').inputmask('(99) 99999-9999', { placeholder: '(__) _____-____' });
    $('#cep').inputmask('99999-999', { placeholder: '_____-___' });
});