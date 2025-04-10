function toggleMenu() {
    const dropdownMenu = document.getElementById('dropdown-menu');
    if (dropdownMenu) {
        dropdownMenu.classList.toggle('show');
    }
}

window.onclick = function (event) {
    if (!event.target.closest('.profile-section')) {
        const dropdownMenu = document.getElementById('dropdown-menu');
        if (dropdownMenu && dropdownMenu.classList.contains('show')) {
            dropdownMenu.classList.remove('show');
        }
    }
};

function toggleSidebarMenu() {
    const sidebar = document.querySelector('.admin-barra-nav');
    sidebar.classList.toggle('active');
}

document.addEventListener("DOMContentLoaded", function () {
    const content = document.getElementById('content');
    const toast = document.getElementById('toast');

    const lastSection = localStorage.getItem('lastSection') || 'home';
    loadSection(lastSection);

    function loadSection(section, page = 1, searchTerm = '') {
        let baseUrl = '';

        if (section === 'listar_usuarios' || section === 'listar_doacoes') {
            baseUrl = `../../crud/public/${section}.php`;
        } else if (section === 'aprovar_pets') {
            baseUrl = `../../crud/public/aprovar_pets.php`;
        } else if (section === 'aprovar_colaboradores') {
            baseUrl = `../../crud/public/aprovar_colaboradores.php`;
        } else if (section === 'home') {
            baseUrl = `../../crud/public/dashboard.php`;
        } else {
            baseUrl = `../../crud/views/${section}.php`;
        }

        const url = `${baseUrl}?page=${page}&search=${encodeURIComponent(searchTerm)}`;
        localStorage.setItem('lastSection', section);

        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                content.innerHTML = xhr.responseText;
                attachPaginationEvents(section);
                if (section === 'aprovar_pets') {
                    loadScript('../../javascript/aprovar_pets.js');
                }
                if (section === 'aprovar_colaboradores') {
                    loadScript('../../javascript/aprovar_colaboradores.js');
                }
            }
        };
        xhr.send();
    }

    function loadScript(src) {
        const existingScript = document.querySelector(`script[src="${src}"]`);
        if (existingScript) {
            existingScript.remove();
        }
        const script = document.createElement('script');
        script.src = src;
        script.defer = true;
        document.body.appendChild(script);
    }

    function attachPaginationEvents(section) {
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const urlParams = new URLSearchParams(this.getAttribute('href').split('?')[1]);
                const page = urlParams.get('page');
                const searchTerm = urlParams.get('search') || '';
                loadSection(section, page, searchTerm);
            });
        });
    }

    const menuLinks = document.querySelectorAll('.menu-link');
    menuLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const section = this.getAttribute('data-section');
            loadSection(section);
        });
    });

    window.loadSection = loadSection;
    const userName = document.body.getAttribute('data-user-name');
    const welcomeMessage = document.querySelector('.welcome-message h2');
    if (welcomeMessage) {
        welcomeMessage.innerHTML = `Bem-vindo(a), ${userName}!`;
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const toast = document.getElementById('toast');

    const showToast = (message, type) => {
        if (toast) {
            toast.textContent = message;
            toast.className = `toast ${type}`;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        }
    };

    const handleAction = (petId, action) => {
        fetch('../../crud/public/logica_aprovar_pets.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ pet_id: petId, status: action })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(() => showToast('Erro ao processar a solicitação.', 'error'));
    };

    const confirmAction = (message, callback) => {
        if (confirm(message)) callback();
    };

    document.addEventListener('click', (event) => {
        const button = event.target.closest('.approve-btn, .reject-btn');
        if (button) {
            const petId = button.getAttribute('data-pet-id');
            const action = button.getAttribute('data-action');
            const confirmMessage = action === 'Disponível'
                ? 'Deseja aprovar este pet?'
                : 'Deseja rejeitar este pet?';
            confirmAction(confirmMessage, () => handleAction(petId, action));
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const toast = document.getElementById('toast');

    const showToast = (message, type) => {
        if (toast) {
            toast.textContent = message;
            toast.className = `toast ${type}`;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        }
    };

    const handleAction = (userId, action) => {
        fetch('../../crud/public/aprovar_colaboradores.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: userId, status_id: action })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(() => showToast('Erro ao processar a solicitação.', 'error'));
    };

    const confirmAction = (message, callback) => {
        if (confirm(message)) callback();
    };

    document.addEventListener('click', (event) => {
        const button = event.target.closest('.approve-btn, .reject-btn');
        if (button) {
            const userId = button.getAttribute('data-user-id');
            const action = button.getAttribute('data-action');
            const confirmMessage = action === '5'
                ? 'Deseja aprovar este colaborador?'
                : 'Deseja rejeitar este colaborador?';
            confirmAction(confirmMessage, () => handleAction(userId, action));
        }
    });
});