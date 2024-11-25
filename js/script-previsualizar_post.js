function initializeCarousel() {
    console.log("Inicializando el carrusel...");

    const carouselImages = document.querySelectorAll('.carousel-images img');
    if (!carouselImages.length) {
        console.error("❌ Error: No se encontraron imágenes en el carrusel.");
        return;
    }

    let currentIndex = 0;

    function updateCarousel() {
        carouselImages.forEach((img, index) => {
            img.style.display = index === currentIndex ? 'block' : 'none';
        });
        console.log(`✔ Mostrando imagen en el carrusel: Índice ${currentIndex}`);
    }

    document.getElementById('previewPrev').addEventListener('click', () => {
        console.log("Botón 'Anterior' clicado.");
        currentIndex = (currentIndex - 1 + carouselImages.length) % carouselImages.length;
        updateCarousel();
    });

    document.getElementById('previewNext').addEventListener('click', () => {
        console.log("Botón 'Siguiente' clicado.");
        currentIndex = (currentIndex + 1) % carouselImages.length;
        updateCarousel();
    });

    updateCarousel(); // Muestra la primera imagen
}


// Emitir evento personalizado cuando el script esté listo
document.addEventListener('DOMContentLoaded', () => {
    console.log("✔ Script 'script-previsualizar_post.js' cargado y listo.");
    const event = new Event('initializeReady');
    document.dispatchEvent(event);
});



document.addEventListener('DOMContentLoaded', () => {
    console.log("Evento 'DOMContentLoaded' disparado. Intentando inicializar el carrusel...");
    if (typeof images !== 'undefined' && images.length > 0) {
        initializeCarousel();
    } else {
        console.error("❌ Error: El array 'images' no está disponible al cargar el DOM.");
    }
});
