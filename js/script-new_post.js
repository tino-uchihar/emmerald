document.addEventListener('DOMContentLoaded', () => {
    const imageCarousel = document.getElementById('imageCarousel');
    const addImageBtn = document.getElementById('addImageBtn');
    const imageCount = document.getElementById('imageCount');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let images = [];
    let currentImageIndex = 0;

    addImageBtn.addEventListener('click', () => {
        if (images.length < 10) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.jpg, .jpeg, .png, .webp, .gif';
            input.onchange = (event) => {
                const file = event.target.files[0];
                if (file) {
                    const validFileTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
                    if (validFileTypes.includes(file.type)) {
                        const reader = new FileReader();
                        reader.onload = () => {
                            images.push(reader.result);
                            imageCount.textContent = `${images.length}/10`;
                            displayImage(images.length - 1);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        alert('Solo se permiten archivos de tipo jpg, jpeg, png, webp, y gif.');
                    }
                }
            };
            input.click();
        } else {
            alert('Máximo 10 imágenes por publicación.');
        }
    });

    function displayImage(index) {
        if (images.length > 0) {
            imageCarousel.innerHTML += `
                <div class="image-container">
                    <img src="${images[index]}" alt="Imagen ${index + 1}">
                    <button class="remove-btn" onclick="removeImage(${index})">X</button>
                </div>
            `;
        }
    }

    prevBtn.addEventListener('click', () => {
        if (images.length > 0) {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            renderCarousel();
        }
    });

    nextBtn.addEventListener('click', () => {
        if (images.length > 0) {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            renderCarousel();
        }
    });

    window.removeImage = (index) => {
        images.splice(index, 1);
        imageCount.textContent = `${images.length}/10`;
        renderCarousel();
    };

    function renderCarousel() {
        imageCarousel.innerHTML = '';
        images.forEach((img, index) => displayImage(index));
    }

    const newPostButton = document.getElementById('newPostButton');
    const newPostModal = document.getElementById('newPostModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    newPostButton.addEventListener('click', () => {
        newPostModal.style.display = 'flex';
    });

    closeModalBtn.addEventListener('click', () => {
        newPostModal.style.display = 'none';
    });

    cancelBtn.addEventListener('click', () => {
        if (confirm('¿Estás seguro de que deseas cancelar? Se perderán todos los cambios.')) {
            newPostModal.style.display = 'none';
        }
    });
});
