function initializeCarousel() {
    console.log("Inicializando el carrusel...");

    if (typeof images === 'undefined' || !Array.isArray(images) || images.length === 0) {
        console.error("❌ Error: 'images' no está definido o está vacío.");
        return;
    } else {
        console.log(`✔ Array 'images' cargado con ${images.length} imagen(es).`, images);
    }

    const previewCarousel = document.getElementById('previewCarousel');
    if (!previewCarousel) {
        console.error("❌ Error: No se encontró el elemento 'previewCarousel' en el DOM.");
        return;
    } else {
        console.log("✔ Elemento 'previewCarousel' encontrado.");
    }

    const prev = document.getElementById('previewPrev');
    const next = document.getElementById('previewNext');

    if (!prev || !next) {
        console.error("❌ Error: No se encontraron los botones de navegación ('prev' o 'next').");
        return;
    } else {
        console.log("✔ Botones de navegación encontrados.");
    }

    let currentIndex = 0;

    function updateCarousel() {
        previewCarousel.style.backgroundImage = `url('${images[currentIndex]}')`;
        console.log(`✔ Mostrando imagen en el carrusel: ${images[currentIndex]} (índice ${currentIndex})`);
    }

    prev.addEventListener('click', () => {
        console.log("Botón 'Anterior' clicado.");
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateCarousel();
    });

    next.addEventListener('click', () => {
        console.log("Botón 'Siguiente' clicado.");
        currentIndex = (currentIndex + 1) % images.length;
        updateCarousel();
    });

    updateCarousel(); // Muestra la primera imagen
}


document.addEventListener('DOMContentLoaded', () => {
    console.log("Evento 'DOMContentLoaded' disparado. Intentando inicializar el carrusel...");
    if (typeof images !== 'undefined' && images.length > 0) {
        initializeCarousel();
    } else {
        console.error("❌ Error: El array 'images' no está disponible al cargar el DOM.");
    }
});
