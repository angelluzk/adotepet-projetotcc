document.addEventListener("DOMContentLoaded", () => {
    const formSteps = document.querySelectorAll(".form-step");
    const btnProximo = document.querySelector(".btn.proximo");
    const btnCadastrar = document.querySelector(".btn.cadastrar");
    const btnVoltar = document.getElementById("btnVoltar");
    let currentStep = 0;

    function showCurrentStep() {
        formSteps.forEach((step, index) => {
            step.classList.toggle("form-step-active", index === currentStep);
        });

        if (currentStep === 0) {
            btnVoltar.style.display = 'block';
        } else {
            btnVoltar.style.display = 'block';
        }
    }

    function isFormValid(step) {
        const inputs = formSteps[step].querySelectorAll("input[required], select[required]");
        for (let input of inputs) {
            if (!input.value.trim()) {
                return false;
            }
        }
        return true;
    }

    btnProximo.addEventListener("click", () => {
        const senha = document.getElementById("senha").value;
        const confirmarSenha = document.getElementById("confirmar-senha").value;

        if (currentStep === 0) {
            if (!isFormValid(currentStep)) {
                alert("Por favor, preencha todos os campos obrigatórios.");
                return;
            }

            if (senha !== confirmarSenha) {
                alert("As senhas não correspondem.");
                return;
            }
        }

        if (currentStep < formSteps.length - 1) {
            currentStep++;
            showCurrentStep();
        }
    });

    btnVoltar.addEventListener("click", () => {
        if (currentStep > 0) {
            currentStep--;
            showCurrentStep();
        } else {
            window.location.href = "../../index.php";
        }
    });

    btnCadastrar.addEventListener("click", () => {
        if (currentStep === formSteps.length - 1) {
            document.getElementById("formCadastro").submit();
        }
    });

    showCurrentStep();
});