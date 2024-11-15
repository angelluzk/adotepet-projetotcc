function toggleMenu() {
    const dropdownMenu = document.getElementById('dropdown-menu');
    dropdownMenu.classList.toggle('show');
}

window.onclick = function (event) {
    if (!event.target.closest('.profile-section')) {
        const dropdownMenu = document.getElementById('dropdown-menu');
        if (dropdownMenu.classList.contains('show')) {
            dropdownMenu.classList.remove('show');
        }
    }
};

function switchSection(event) {
    event.preventDefault();
    const sectionId = event.target.getAttribute('data-section');

    document.querySelectorAll('.profile-menu a').forEach(link => link.classList.remove('active'));
    document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));

    event.target.classList.add('active');
    document.getElementById(sectionId).classList.add('active');
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.profile-menu a[data-section="editar-perfil"]').click();
});

document.getElementById('edit-btn').addEventListener('click', function () {
    const formElements = document.querySelectorAll('#editar-perfil-form input');

    formElements.forEach(input => {
        input.disabled = !input.disabled;
    });

    this.textContent = this.textContent === 'Editar' ? 'Cancelar Edição' : 'Editar';
});

document.querySelector('form').addEventListener('submit', function (event) {
    var senhaAtual = document.getElementById('senha_atual').value;
    var novaSenha = document.getElementById('nova_senha').value;
    var confirmarSenha = document.getElementById('confirmar-senha').value;

    if (senhaAtual && novaSenha && novaSenha !== confirmarSenha) {
        alert("As senhas não coincidem. Tente novamente.");
        event.preventDefault();
    }
});

window.onload = function () {
    if (document.querySelector('.error-message')) {
        setTimeout(function () {
            document.querySelector('.alert-container').style.display = 'none';
        }, 5000);
    }
};

function editPet(petId) {
    window.location.href = `editar_pet.php?pet_id=${petId}`;
}

function deletePet(petId) {
    if (confirm("Tem certeza de que deseja excluir este pet?")) {
        fetch(`deletar_pet.php?pet_id=${petId}`, { method: 'GET' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Pet excluído com sucesso!");
                    location.reload();
                } else {
                    alert("Erro ao excluir o pet: " + data.error);
                }
            })
            .catch(error => {
                console.error("Erro na requisição:", error);
            });
    }
}