document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('photo');
    const preview = document.getElementById('photo-preview');
    const placeholder = document.getElementById('photo-placeholder');
    const filenameEl = document.getElementById('photo-filename');
    const removeBtn = document.getElementById('photo-remove');

    if (!input || !preview) {
        return;
    }

    const originalSrc = preview.getAttribute('src') || '';
    const originalFilename = filenameEl ? filenameEl.textContent.trim() : '';
    const hadOriginalPhoto = !preview.classList.contains('hidden');

    function showPreview(src, filename) {
        preview.src = src;
        preview.classList.remove('hidden');

        if (placeholder) {
            placeholder.classList.add('hidden');
        }

        if (filenameEl) {
            filenameEl.textContent = filename;
        }

        if (removeBtn) {
            removeBtn.classList.remove('hidden');
        }
    }

    function resetPreview() {
        if (hadOriginalPhoto) {
            preview.src = originalSrc;
            preview.classList.remove('hidden');

            if (placeholder) {
                placeholder.classList.add('hidden');
            }
        } else {
            preview.classList.add('hidden');
            preview.removeAttribute('src');

            if (placeholder) {
                placeholder.classList.remove('hidden');
            }
        }

        if (filenameEl) {
            filenameEl.textContent = originalFilename || 'Nenhuma imagem selecionada';
        }

        if (removeBtn) {
            removeBtn.classList.toggle('hidden', !hadOriginalPhoto);
        }
    }

    input.addEventListener('change', function() {
        const file = input.files && input.files[0];

        if (!file) {
            resetPreview();
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            showPreview(e.target.result, file.name);
        };
        reader.readAsDataURL(file);
    });

    if (removeBtn) {
        removeBtn.addEventListener('click', function(event) {
            // O botão fica dentro do <label for="photo"> que envolve o card inteiro;
            // sem isso, o clique borbulharia até o label e reabriria o seletor de arquivo.
            event.preventDefault();
            input.value = '';
            resetPreview();
        });
    }
});
