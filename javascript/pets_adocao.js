const imgBasePath = 'http://localhost/adotepet-projetotcc/';
let paginaAtual = 1;
const petsPorPagina = 20;
let pets = [];

document.addEventListener('DOMContentLoaded', () => {
    carregarPets();
    limparFiltros();
});

async function carregarPets() {
    try {
        const response = await fetch('../../crud/public/buscar_pets.php');
        pets = await response.json();
        console.log('Pets carregados:', pets);
        renderizarCards(paginaAtual);
    } catch (error) {
        console.error('Erro ao carregar os pets:', error);
    }
}

function renderizarCards(pagina) {
    const inicio = (pagina - 1) * petsPorPagina;
    const fim = inicio + petsPorPagina;
    const petsPagina = pets.slice(inicio, fim);

    const container = document.getElementById('pet-cards-container');
    container.innerHTML = '';

    if (petsPagina.length === 0) {
        container.innerHTML = '<p>Nenhum pet encontrado.</p>';
        return;
    }

    petsPagina.forEach(pet => {
        const imgSrc = `${imgBasePath}${pet.url || 'uploads/default.jpg'}`;
        const statusClass = normalizeStatus(pet.status_nome);
        container.innerHTML += `
            <div class="card" onclick="abrirPaginaPet(${pet.id})">
                <img src="${imgSrc}" alt="${pet.nome}" onerror="this.onerror=null; this.src='${imgBasePath}uploads/default.jpg';">
                <div class="card-info">
                    <h3>${pet.nome}</h3>
                    <p>Porte: ${pet.porte || 'N/A'}</p>
                    <p>Idade: ${pet.idade || 'N/A'}</p>
                    <hr>
                    <p>${pet.bairro || 'N/A'}, ${pet.estado || 'N/A'}</p>
                    <button class="adopt-btn" onclick="abrirPaginaPet(${pet.id})">Quero Adotar</button>
                    <span class="status ${statusClass}">${pet.status_nome}</span>
                </div>
            </div>
        `;
    });
}

function normalizeStatus(status) {
    const search = ['á', 'à', 'ã', 'â', 'é', 'ê', 'í', 'ó', 'ô', 'õ', 'ú', 'ç', 'Á', 'À', 'Ã', 'Â', 'É', 'Ê', 'Í', 'Ó', 'Ô', 'Õ', 'Ú', 'Ç'];
    const replace = ['a', 'a', 'a', 'a', 'e', 'e', 'i', 'o', 'o', 'o', 'u', 'c', 'a', 'a', 'a', 'a', 'e', 'e', 'i', 'o', 'o', 'o', 'u', 'c'];

    if (!status) return '';

    const normalizedStatus = status.toLowerCase().replace(/[áàãâéêíóôõúçÁÀÃÂÉÊÍÓÔÕÚÇ]/g, match => replace[search.indexOf(match)]).trim();

    const statusMap = {
        'disponivel': 'disponivel',
        'em adocao': 'em-adocao',
        'adotado': 'adotado'
    };

    return statusMap[normalizedStatus] || 'disponivel';
}

async function filtrarPets() {
    const especie = document.getElementById('especie-filter').value || '';
    const sexo = document.getElementById('sexo-filter').value || '';
    const porte = document.getElementById('porte-filter').value || '';
    const idade = document.getElementById('idade-filter').value || '';

    console.log('Filtros aplicados:', { especie, sexo, porte, idade });

    try {
        const url = `../../crud/public/buscar_pets.php?especie=${especie}&sexo=${sexo}&porte=${porte}&idade=${idade}`;
        console.log('URL da requisição:', url);
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        pets = await response.json();
        console.log('Pets filtrados:', pets);

        paginaAtual = 1;
        renderizarCards(paginaAtual);
        limparFiltros();
    } catch (error) {
        console.error('Erro ao filtrar os pets:', error);
    }
}

function limparFiltros() {
    document.getElementById('especie-filter').value = '';
    document.getElementById('sexo-filter').value = '';
    document.getElementById('porte-filter').value = '';
    document.getElementById('idade-filter').value = '';
}

document.getElementById('filtrar-btn').addEventListener('click', async () => {
    await filtrarPets();
});

function proximaPagina() {
    const totalPaginas = Math.ceil(pets.length / petsPorPagina);
    if (paginaAtual < totalPaginas) {
        paginaAtual++;
        renderizarCards(paginaAtual);
        document.getElementById('numeracao-pagina').innerText = `Página ${paginaAtual}`;
    }
}

function paginaAnterior() {
    if (paginaAtual > 1) {
        paginaAtual--;
        renderizarCards(paginaAtual);
        document.getElementById('numeracao-pagina').innerText = `Página ${paginaAtual}`;
    }
}

function abrirPaginaPet(id) {
    window.location.href = `../../crud/views/pet_detalhes.php?id=${id}`;
}