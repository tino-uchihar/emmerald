function initializeCarousel() {
    const previewCarousel = document.getElementById('previewCarousel');
    const prev = document.getElementById('previewPrev');
    const next = document.getElementById('previewNext');
    let currentIndex = 0;

    function updateCarousel() {
        if (images.length > 0) {
            previewCarousel.style.backgroundImage = `url('${images[currentIndex]}')`;
            console.log(`Imagen actual: ${images[currentIndex]}`);
        } else {
            previewCarousel.style.backgroundImage = '';
        }
    }

    prev.addEventListener('click', () => {
        console.log('Botón Anterior clicado');
        if (images.length > 0) {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateCarousel();
        }
    });

    next.addEventListener('click', () => {
        console.log('Botón Siguiente clicado');
        if (images.length > 0) {
            currentIndex = (currentIndex + 1) % images.length;
            updateCarousel();
        }
    });

    // Inicializar el carrusel con la primera imagen
    updateCarousel();
}

document.addEventListener('DOMContentLoaded', initializeCarousel);


function openPreviewModal(id) {
    fetch(`previsualizar_post.php?id=${id}`)
        .then(response => response.text())
        .then(data => {
            const modalContainer = document.createElement('div');
            modalContainer.innerHTML = data;
            document.body.appendChild(modalContainer);

            // Verificar si el script ya está cargado
            if (!document.getElementById('script-previsualizar_post')) {
                const script = document.createElement('script');
                script.src = 'js/script-previsualizar_post.js';
                script.id = 'script-previsualizar_post';
                document.body.appendChild(script);
            } else {
                // Si el script ya está cargado, inicializamos directamente el carrusel
                if (typeof initializeCarousel === 'function') {
                    initializeCarousel();
                }
            }

            modalContainer.querySelector('#closeModalBtnPreview').addEventListener('click', () => {
                modalContainer.remove();
            });
        })
        .catch(error => console.error('Error al cargar el modal:', error));
}