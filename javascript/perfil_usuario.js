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

    if (this.textContent === 'Editar Perfil') {
        this.textContent = 'Cancelar Edição';
    } else {
        this.textContent = 'Editar Perfil';
    }
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

function openModal(petId) {
    fetch(`../../crud/public/get_pet_info.php?pet_id=${petId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(pet => {
            if (pet.error) {
                alert(pet.error);
                return;
            }
            
            document.getElementById('pet_id').value = pet.pet_id;
            document.getElementById('pet_nome').value = pet.pet_nome;
            document.getElementById('pet_raca').value = pet.pet_raca;
            document.getElementById('pet_porte').value = pet.pet_porte;
            document.getElementById('pet_sexo').value = pet.pet_sexo;
            document.getElementById('pet_cor').value = pet.pet_cor;
            document.getElementById('pet_idade').value = pet.pet_idade;
            document.getElementById('pet_status').value = pet.status_id;
            document.getElementById('pet_descricao').value = pet.pet_descricao;

            document.querySelector(".modal-overlay").classList.add("show");
            document.getElementById('editModal').classList.remove('d-none');
        })
        .catch(error => {
            console.error('Erro ao carregar os dados do pet:', error);
            alert('Não foi possível carregar os dados do pet.');
        });
}

function closeModal() {
    document.querySelector(".modal-overlay").classList.remove("show");
    document.getElementById('editModal').classList.add('d-none');
}

function deletePet(petId) {
    const confirmation = confirm("Tem certeza de que deseja excluir este pet?");
    
    if (confirmation) {
        fetch(`delete_pet.php?pet_id=${petId}`, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pet excluído com sucesso!');
                location.reload();
            } else {
                alert('Erro ao excluir pet.');
            }
        })
        .catch(error => {
            console.error('Erro ao excluir pet:', error);
            alert('Erro ao excluir pet. Tente novamente.');
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    carregarFavoritos();
    
    window.addEventListener('favoritoAtualizado', (event) => {
        carregarFavoritos();
    });
});

async function carregarFavoritos() {
    try {
        const response = await fetch('../../crud/public/obter_favoritos.php');
        if (!response.ok) throw new Error('Erro ao buscar os favoritos.');

        const favoritos = await response.json();
        const favoritesContainer = document.querySelector('.favorites-cards');

        if (favoritos.error) {
            favoritesContainer.innerHTML = `<p>${favoritos.error}</p>`;
            return;
        }

        favoritesContainer.innerHTML = favoritos.map(fav => `
            <div class="favorite-card">
                <img src="${fav.imagem || '../../img/default-pet.png'}" alt="${fav.nome}">
                <div class="card-content">
                    <h3>${fav.nome}</h3>
                    <p>Status: ${fav.status}</p>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Erro ao carregar favoritos:', error);
        document.querySelector('.favorites-cards').innerHTML = '<p>Erro ao carregar favoritos.</p>';
    }
}