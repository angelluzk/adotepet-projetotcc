window.onload = function () {
    const messageContainer = document.getElementById('message-container');
    if (messageContainer) {
        messageContainer.style.display = 'block';
        setTimeout(() => {
            messageContainer.style.opacity = '0';
            setTimeout(() => {
                messageContainer.style.display = 'none';
            }, 500);
        }, 3000);
    }
};

function previewImages(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('preview-container');
    const photosAddedText = document.getElementById('fotos-adicionadas').querySelector('p');

    previewContainer.innerHTML = '';

    let fileCount = files.length;

    for (let i = 0; i < fileCount; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function (e) {

            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.display = 'inline-block';

            const imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            imgElement.style.maxWidth = '100px';
            imgElement.style.margin = '5px';

            const removeButton = document.createElement('span');
            removeButton.classList.add('remove-img');
            removeButton.innerHTML = '×';

            removeButton.addEventListener('click', () => {
                wrapper.remove();
                fileCount--;
                photosAddedText.textContent = `Fotos Adicionadas: ${fileCount}`;
            });

            wrapper.appendChild(imgElement);
            wrapper.appendChild(removeButton);
            previewContainer.appendChild(wrapper);
        };

        reader.readAsDataURL(file);
    }

    photosAddedText.textContent = `Fotos Adicionadas: ${fileCount}`;
}

document.getElementById('file-upload-label').onclick = function () {
    document.getElementById('foto').click();
};