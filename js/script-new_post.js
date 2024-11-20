document.addEventListener('DOMContentLoaded', () => {
    const imageCarousel = document.getElementById('imageCarousel');
    const fileInput = document.getElementById('imagenes');
    const imageCount = document.getElementById('imageCount');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let images = [];
    let currentImageIndex = 0;

    fileInput.addEventListener('change', (event) => {
        const files = event.target.files;
        images = []; // Reset images array
        if (files.length > 10) {
            alert('Máximo 10 imágenes por publicación.');
            fileInput.value = ''; // Clear the input
            return;
        }

        for (const file of files) {
            const validFileTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (validFileTypes.includes(file.type)) {
                const reader = new FileReader();
                reader.onload = () => {
                    images.push(reader.result);
                    imageCount.textContent = `${images.length}/10`;
                    displayImage(0); // Display the first image initially
                };
                reader.readAsDataURL(file);
            } else {
                alert('Solo se permiten archivos de tipo jpg, jpeg, png, webp, y gif.');
            }
        }
    });

    function displayImage(index) {
        if (images.length > 0) {
            imageCarousel.innerHTML = `
                <div class="image-container">
                    <img src="${images[index]}" alt="Imagen ${index + 1}">
                </div>
            `;
        } else {
            imageCarousel.innerHTML = ''; // Clear carousel if no images
        }
    }

    prevBtn.addEventListener('click', () => {
        if (images.length > 0) {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            displayImage(currentImageIndex);
        }
    });

    nextBtn.addEventListener('click', () => {
        if (images.length > 0) {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            displayImage(currentImageIndex);
        }
    });

    window.removeImage = (index) => {
        images.splice(index, 1);
        imageCount.textContent = `${images.length}/10`;
        if (images.length > 0) {
            currentImageIndex = currentImageIndex % images.length;
            displayImage(currentImageIndex);
        } else {
            imageCarousel.innerHTML = ''; // Clear carousel if no images
        }
    };

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
