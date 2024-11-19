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
            <button id="newPostButton" class="mode-button">Nueva publicación</button>
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
            <div id="imageCarousel">
                <!-- Las imágenes cargadas aparecerán aquí -->
            </div>
            <div class="controls">
                <span id="imageCount">0/10</span>
                <button id="addImageBtn">+</button>
            </div>
        </div>
        <div class="right-panel">
            <form action="new_post_process.php" method="post" enctype="multipart/form-data" id="newPostForm">
                <label for="cTitulo">Título del Proyecto (max 100 caracteres)</label>
                <input type="text" id="cTitulo" name="cTitulo" maxlength="100" required>
                <label for="tDescripcion">Descripción (max 500 caracteres)</label>
                <textarea id="tDescripcion" name="tDescripcion" maxlength="500" required></textarea>
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
    // Cargar el contenido del aside.php de manera asíncrona y agregarlo a la página
    fetch('includes/aside.php')
        .then(response => response.text())
        .then(data => {
            // Crear un contenedor para el aside y agregar el HTML recibido
            const asideContainer = document.createElement('div');
            asideContainer.innerHTML = data;
            document.body.appendChild(asideContainer);
            
            // Agregar listener para cerrar el aside al hacer clic fuera de él
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
    // Remover el listener cuando se cierre el aside
    document.removeEventListener('click', cerrarAsideAlHacerClickFuera);
}

function openNewPostModal() {
    document.getElementById('newPostModal').style.display = 'flex';
}

document.addEventListener('DOMContentLoaded', () => {
    const imageCarousel = document.getElementById('imageCarousel');
    const addImageBtn = document.getElementById('addImageBtn');
    const imageCount = document.getElementById('imageCount');
    let images = [];
    let imageIndex = 0;

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
                        addImage(reader.result, images.length);
                        images.push(reader.result);
                        imageCount.textContent = `${images.length}/10`;
                    }
                    reader.readAsDataURL(file);
                }
            }
            input.click();
        } else {
            alert('Máximo 10 imágenes por publicación.');
        }
    });

    function addImage(src, index) {
        const imgContainer = document.createElement('div');
        imgContainer.classList.add('image-container');
        const img = document.createElement('img');
        img.src = src;
        const removeBtn = document.createElement('button');
        removeBtn.textContent = 'X';
        removeBtn.classList.add('remove-btn');
        removeBtn.onclick = () => {
            imgContainer.remove();
            images.splice(index, 1);
            imageCount.textContent = `${images.length}/10`;
        }
        imgContainer.appendChild(img);
        imgContainer.appendChild(removeBtn);
        imageCarousel.appendChild(imgContainer);
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
</script>
