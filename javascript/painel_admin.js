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

document.addEventListener("DOMContentLoaded", function () {
    const content = document.getElementById('content');
    const lastSection = localStorage.getItem('lastSection') || 'home';

    loadSection(lastSection);

    function loadSection(section, page = 1, searchTerm = '') {
        let url = section === 'listar_usuarios' || section === 'listar_doacoes'
            ? `../../crud/public/${section}.php?page=${page}&search=${encodeURIComponent(searchTerm)}`
            : `../../crud/views/${section}.php`;

        localStorage.setItem('lastSection', section);

        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                content.innerHTML = xhr.responseText;

                attachPaginationEvents(section);
            }
        };
        xhr.send();
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

    attachPaginationEvents(lastSection);

    window.loadSection = loadSection;
});