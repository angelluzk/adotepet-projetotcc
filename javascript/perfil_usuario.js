function toggleMenu() {
    const dropdownMenu = document.getElementById('dropdown-menu');
    dropdownMenu.classList.toggle('show');
}

window.onclick = function (event) {
    if (!event.target.closest('.profile-section')) {
        const menu = document.getElementById('dropdown-menu');
        if (menu.style.display === 'block') {
            toggleMenu();
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