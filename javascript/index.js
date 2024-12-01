function showTooltipError(message, redirectUrl) {
    const divulgarButton = document.querySelector('.divulgue-button');
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip-error';
    tooltip.textContent = message;

    divulgarButton.parentNode.appendChild(tooltip);

    const buttonRect = divulgarButton.getBoundingClientRect();
    tooltip.style.top = buttonRect.top + window.scrollY - tooltip.offsetHeight + 15 + 'px';
    tooltip.style.left = buttonRect.left + window.scrollX + (divulgarButton.offsetWidth - tooltip.offsetWidth) / 20 + 'px';

    setTimeout(() => {
        tooltip.remove();
        window.location.href = redirectUrl;
    }, 2000);
}

document.addEventListener('DOMContentLoaded', () => {
    const divulgarButton = document.querySelector('.divulgue-button');

    if (divulgarButton) {
        divulgarButton.addEventListener('click', (event) => {
            event.preventDefault();
            if (!isLoggedIn) {
                showTooltipError('Você precisa estar logado para doar um animalzinho.', 'login.html');
            } else {
                window.location.href = 'crud/views/cadastro_doacoes.php';
            }
        });
    }
});

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