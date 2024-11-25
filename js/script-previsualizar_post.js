// función para manejar el carrusel de previsualización

const previewImages = document.querySelectorAll('#previewCarousel img');
let previewCurrentIndex = 0;

function updatePreviewCarousel() {
    previewImages.forEach((img, index) => {
        img.style.display = index === previewCurrentIndex ? 'block' : 'none';
    });
}

const previewPrev = document.getElementById('previewPrev');
const previewNext = document.getElementById('previewNext');

previewPrev.addEventListener('click', () => {
    if (previewImages.length > 0) {
        previewCurrentIndex = (previewCurrentIndex - 1 + previewImages.length) % previewImages.length;
        updatePreviewCarousel();
    }
});

previewNext.addEventListener('click', () => {
    if (previewImages.length > 0) {
        previewCurrentIndex = (previewCurrentIndex + 1) % previewImages.length;
        updatePreviewCarousel();
    }
});

document.addEventListener('DOMContentLoaded', () => {
    updatePreviewCarousel();
});
