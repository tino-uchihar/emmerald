<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Usuario';
}
?>
<header>
    <div class="left-header">
        <button onclick="location.href='index.php'">Logo</button>
        <button onclick="location.href='index.php'">Esmeralda</button>
    </div>
    <div class="right-header">
        <?php if (isset($_SESSION['usuario'])): ?>
            <button id="newPostButton" class="mode-button" onclick="openNewPostModal()">Nueva publicación</button>
            <button id="userButton" class="mode-button" onclick="mostrarAside()"><?php echo htmlspecialchars($usuario); ?></button>
        <?php else: ?>
            <button id="ltButton" class="mode-button" onclick="location.href='login.php?mode=login'">Login</button>
            <button id="rtButton" class="mode-button" onclick="location.href='login.php?mode=register'">Register</button>
        <?php endif; ?>
    </div>
</header>

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
                <button id="addImageBtn">+</button>
            </div>
            <div class="tags-list" id="tags-list"></div>
            <input type="text" class="input-field" id="etiquetas" placeholder="Agregar etiquetas">
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
function mostrarAside() {
    fetch('includes/aside.php')
        .then(response => response.text())
        .then(data => {
            const asideContainer = document.createElement('div');
            asideContainer.innerHTML = data;
            document.body.appendChild(asideContainer);
            document.addEventListener('click', cerrarAsideAlHacerClickFuera);
        })
        .catch(error => console.error('Error al cargar el aside:', error));
}

function cerrarAsideAlHacerClickFuera(event) {
    const aside = document.getElementById('user-aside');
    if (aside && !aside.contains(event.target) && event.target.id !== 'userButton') {
        cerrarAside();
    }
}

function cerrarAside() {
    const aside = document.getElementById('user-aside');
    if (aside) {
        aside.remove();
    }
    document.removeEventListener('click', cerrarAsideAlHacerClickFuera);
}

function openNewPostModal() {
    document.getElementById('newPostModal').style.display = 'flex';
}

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
            input.accept = 'image/*';
            input.onchange = (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        images.push(reader.result);
                        imageCount.textContent = `${images.length}/10`;
                        displayImage(currentImageIndex);
                    }
                    reader.readAsDataURL(file);
                }
            }
            input.click();
        } else {
            alert('Máximo 10 imágenes por publicación.');
        }
    });

    function displayImage(index) {
        if (images.length > 0) {
            imageCarousel.innerHTML = `
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
            imageCarousel.innerHTML = '';
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
</script>
