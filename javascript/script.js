document.addEventListener('DOMContentLoaded', function() {
    const uploadInput = document.getElementById('fotos');
    const previewContainer = document.getElementById('previewContainer');

    function updatePreview() {
        const files = uploadInput.files;
        previewContainer.innerHTML = '';

        if (files.length < 1) {
            alert('Pelo menos uma foto é obrigatória.');
            return;
        }

        Array.from(files).forEach((file, index) => {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;

                    const removeButton = document.createElement('button');
                    removeButton.textContent = 'x';
                    removeButton.classList.add('remove-button');
                    removeButton.addEventListener('click', () => {
                        // Remove o item do preview
                        previewContainer.removeChild(previewItem);
                        // Remove o arquivo da lista de arquivos
                        const newFiles = Array.from(uploadInput.files).filter((_, i) => i !== index);
                        const dataTransfer = new DataTransfer();
                        newFiles.forEach(file => dataTransfer.items.add(file));
                        uploadInput.files = dataTransfer.files;
                        updatePreview();
                    });

                    const previewItem = document.createElement('div');
                    previewItem.classList.add('preview-item');
                    previewItem.appendChild(img);
                    previewItem.appendChild(removeButton);

                    previewContainer.appendChild(previewItem);
                };

                reader.readAsDataURL(file);
            }
        });

        if (files.length < 1) {
            alert('Você deve enviar pelo menos uma foto.');
        }
    }

    uploadInput.addEventListener('change', updatePreview);

    function nextStep() {
        const currentStep = document.querySelector('.step.active');
        if (currentStep.id === 'step1') {
            document.getElementById('step1').classList.remove('active');
            document.getElementById('step2').classList.add('active');
        } else if (currentStep.id === 'step2') {
            document.getElementById('step2').classList.remove('active');
            document.getElementById('step3').classList.add('active');
        }
    }

    function prevStep() {
        const currentStep = document.querySelector('.step.active');
        if (currentStep.id === 'step2') {
            document.getElementById('step2').classList.remove('active');
            document.getElementById('step1').classList.add('active');
        } else if (currentStep.id === 'step3') {
            document.getElementById('step3').classList.remove('active');
            document.getElementById('step2').classList.add('active');
        }
    }
});
