const imgBasePath = 'http://localhost/adotepet-projetotcc/';

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const petId = urlParams.get('id');

    if (petId) {
        carregarDetalhesPet(petId);
    } else {
        document.getElementById('pet-details').innerHTML = '<p>Pet não encontrado.</p>';
    }
});

async function carregarDetalhesPet(id) {
    try {
        const response = await fetch(`../../crud/public/buscar_detalhes.php?id=${id}`);
        if (!response.ok) {
            throw new Error('Erro ao buscar os detalhes do pet');
        }

        const pet = await response.json();
        if (pet.error) {
            document.getElementById('pet-details').innerHTML = `<p>${pet.error}</p>`;
        } else {
            renderizarDetalhesPet(pet);
        }
    } catch (error) {
        console.error('Erro:', error);
        document.getElementById('pet-details').innerHTML = '<p>Erro ao carregar detalhes do pet.</p>';
    }
}

function renderizarDetalhesPet(pet) {
    const container = document.getElementById('pet-details');

    const carouselItems = pet.urls.map(url => `${imgBasePath}${url}`);
    const imgSrc = pet.url_principal ? `${imgBasePath}${pet.url_principal}` : `${imgBasePath}uploads/default.jpg`;

    container.innerHTML = `
        <div class="pet-details-container">
            <div class="carousel-container">
                <div class="carousel-images"></div>
                <button class="carousel-prev">&#10094;</button>
                <button class="carousel-next">&#10095;</button>
                <div class="thumbnail-container"></div>
            </div>
            <div class="pet-info">
                <h2>${pet.nome}</h2>
                <div class="info-line">
                    <p><strong>Sexo:</strong> ${pet.sexo}</p>
                    <p><strong>Porte:</strong> ${pet.porte}</p>
                    <p><strong>Idade:</strong> ${pet.idade} anos</p>
                </div>
                <div class="info-line">
                    <p><strong>Cor:</strong> ${pet.cor}</p>
                    <p><strong>Espécie:</strong> ${pet.especie}</p>
                    <p><strong>Raça:</strong> ${pet.raca}</p>
                </div>
                <hr>
                <h3>Contato sobre o animal</h3>
                <p><strong>Nome do protetor:</strong> ${pet.protetor_nome} ${pet.protetor_sobrenome}</p>
                <p><strong>E-mail:</strong> ${pet.protetor_email}</p>
                <p><strong>Telefone:</strong> ${pet.protetor_telefone}</p>
                <p><strong>Endereço:</strong> ${pet.bairro}, ${pet.estado}</p>
                <button class="adopt-btn" onclick="adoptPet()">Quero Adotar</button>
                <div class="social-icons">
                    <p>Compartilhar</p>
                    <a href="https://api.whatsapp.com/send?text=Olha esse pet que eu encontrei: ${pet.nome} - ${imgSrc}" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.instagram.com/yourprofile" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="javascript:void(0)" onclick="sharePet('${pet.nome}', '${imgSrc}')"><i class="fas fa-share-alt"></i></a>
                </div>
            </div>
        </div>
        <div class="pet-description">
            <h3>Descrição</h3>
            <p>${pet.descricao}</p>
        </div>
    `;

    initCarousel(carouselItems);
}

function initCarousel(images) {
    const carouselImages = document.querySelector('.carousel-images');
    const thumbnailContainer = document.querySelector('.thumbnail-container');
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');

    let currentIndex = 0;

    images.forEach((src, index) => {
        const img = document.createElement('img');
        img.src = src;
        img.classList.add('carousel-image');
        carouselImages.appendChild(img);

        const thumb = document.createElement('img');
        thumb.src = src;
        thumb.classList.add('thumbnail');
        thumb.addEventListener('click', () => {
            currentIndex = index;
            updateCarousel();
        });
        thumbnailContainer.appendChild(thumb);
    });

    function updateCarousel() {
        const offset = -currentIndex * 100;
        carouselImages.style.transform = `translateX(${offset}%)`;

        document.querySelectorAll('.thumbnail-container img').forEach((thumb, index) => {
            thumb.classList.toggle('active', index === currentIndex);
        });
    }

    function nextImage() {
        currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
        updateCarousel();
    }

    function prevImage() {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
        updateCarousel();
    }

    prevButton.addEventListener('click', prevImage);
    nextButton.addEventListener('click', nextImage);

    let autoPlayInterval = setInterval(nextImage, 3000);

    carouselImages.addEventListener('mouseenter', () => {
        clearInterval(autoPlayInterval);
    });

    carouselImages.addEventListener('mouseleave', () => {
        autoPlayInterval = setInterval(nextImage, 3000);
    });

    updateCarousel();
}

function sharePet(nome, imgSrc) {
    const shareText = `Confira este pet que eu encontrei: ${nome} - ${imgSrc}`;
    if (navigator.share) {
        navigator.share({ title: nome, text: shareText, url: imgSrc })
            .catch(error => console.error('Erro ao compartilhar:', error));
    } else {
        alert('Seu navegador não suporta o compartilhamento via Web API.');
    }
}

function toggleMenu() {
    const dropdownMenu = document.getElementById('dropdown-menu');
    dropdownMenu.classList.toggle('show');
}

function closeModal() {
    const modal = document.getElementById('adoption-modal');
    modal.classList.add('hidden');
}

function adoptPet() {
    const modal = document.getElementById('adoption-modal');
    modal.classList.remove('hidden');
}

document.getElementById('adoption-form').addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const petId = new URLSearchParams(window.location.search).get('id');

    formData.append('pet_id', petId);

    const recaptchaResponse = grecaptcha.getResponse();
    if (!recaptchaResponse) {
        alert('Por favor, confirme o reCAPTCHA.');
        return;
    }
    formData.append('g-recaptcha-response', recaptchaResponse);

    try {
        const response = await fetch('../../crud/public/salvar_adocao.php', {
            method: 'POST',
            body: formData,
        });

        const text = await response.text();
        console.log('Resposta do servidor:', text);

        try {
            const result = JSON.parse(text);
            if (result.success) {
                alert('Sua solicitação foi enviada com sucesso!');
                closeModal();
            } else {
                alert(result.error || 'Ocorreu um erro. Tente novamente.');
            }
        } catch (error) {
            console.error('Erro ao processar JSON:', error);
            alert('Erro ao processar a resposta do servidor');
        }
    } catch (error) {
        console.error('Erro ao enviar a adoção:', error);
        alert('Erro ao enviar a solicitação. Tente novamente.');
    }
});