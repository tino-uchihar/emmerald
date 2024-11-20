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
    fetch('new_post.php')
        .then(response => response.text())
        .then(data => {
            const modalContainer = document.createElement('div');
            modalContainer.innerHTML = data;
            document.body.appendChild(modalContainer);
            const script = document.createElement('script');
            script.src = 'js/script-new_post.js';
            document.body.appendChild(script);
            document.getElementById('closeModalBtn').addEventListener('click', () => {
                modalContainer.remove();
            });
            document.getElementById('cancelBtn').addEventListener('click', () => {
                if (confirm('¿Estás seguro de que deseas cancelar? Se perderán todos los cambios.')) {
                    modalContainer.remove();
                }
            });
        })
        .catch(error => console.error('Error al cargar el modal:', error));
}
</script>
