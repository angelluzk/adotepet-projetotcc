document.addEventListener("DOMContentLoaded", () => {
    const formSteps = document.querySelectorAll(".form-step");
    const btnProximo = document.querySelector(".btn.proximo");
    const btnCadastrar = document.querySelector(".btn.cadastrar");
    let currentStep = 0;

    //Função para mostrar a etapa atual
    function showCurrentStep() {
        formSteps.forEach((step, index) => {
            step.classList.toggle("form-step-active", index === currentStep);
        });
    }

    //Evento para o botão "Próximo"
    btnProximo.addEventListener("click", () => {
        if (currentStep < formSteps.length - 1) {
            currentStep++;
            showCurrentStep();
        }
    });

    //Evento para o botão "Cadastrar"
    btnCadastrar.addEventListener("click", () => {
        if (currentStep === formSteps.length - 1) {
            document.getElementById("formCadastro").submit();
        }
    });

    //Exibir a etapa inicial
    showCurrentStep();
});