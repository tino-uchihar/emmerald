<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
?>

<div class="modal-container" id="newPostModal">
    <div class="modal-content">
        <button id="closeModalBtn" class="close-modal-btn">X</button>
        <div class="left-panel">
            <div id="carouselContainer">
                <button id="prevBtn" class="carousel-btn">←</button>
                <div id="imageCarousel">
                    <!-- Las imágenes cargadas aparecerán aquí -->
                </div>
                <button id="nextBtn" class="carousel-btn">→</button>
            </div>
            <div class="controls">
                <span id="imageCount">0/10</span>
                <input type="file" name="imagenes[]" id="imagenes" accept=".jpg, .jpeg, .png, .webp, .gif" multiple>
            </div>
        </div>
        <div class="right-panel">
            <form action="new_post_process.php" method="post" enctype="multipart/form-data" id="newPostForm">
                <div class="field-label">Título</div>
                <input type="text" class="input-field" id="cTitulo" name="cTitulo" maxlength="100" placeholder="(max 100 caracteres)" required>
                <div class="field-label">Descripción</div>
                <textarea class="input-field" id="tDescripcion" name="tDescripcion" maxlength="500" placeholder="(max 500 caracteres)" required></textarea>
                <div class="buttons">
                    <button type="submit">Publicar</button>
                    <button type="button" id="cancelBtn">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageCarousel = document.getElementById('imageCarousel');
    const fileInput = document.getElementById('imagenes');
    const imageCount = document.getElementById('imageCount');
    let images = [];
    let currentImageIndex = 0;

    fileInput.addEventListener('change', function(event) {
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
                reader.onload = function() {
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

    document.getElementById('prevBtn').addEventListener('click', function() {
        if (images.length > 0) {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            displayImage(currentImageIndex);
        }
    });

    document.getElementById('nextBtn').addEventListener('click', function() {
        if (images.length > 0) {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            displayImage(currentImageIndex);
        }
    });

    window.removeImage = function(index) {
        images.splice(index, 1);
        imageCount.textContent = `${images.length}/10`;
        if (images.length > 0) {
            currentImageIndex = currentImageIndex % images.length;
            displayImage(currentImageIndex);
        } else {
            imageCarousel.innerHTML = ''; // Clear carousel if no images
        }
    };

    document.getElementById('closeModalBtn').addEventListener('click', function() {
        document.getElementById('newPostModal').remove();
    });

    document.getElementById('cancelBtn').addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas cancelar? Se perderán todos los cambios.')) {
            document.getElementById('newPostModal').remove();
        }
    });
});
</script>
