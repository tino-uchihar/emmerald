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
            <button id="newPostButton" class="mode-button" onclick="location.href='new_post.php'">Nueva publicación</button>
            <button id="userButton" class="mode-button" onclick="mostrarAside()"><?php echo htmlspecialchars($usuario); ?></button>
        <?php else: ?>
            <button id="ltButton" class="mode-button" onclick="location.href='login.php?mode=login'">Login</button>
            <button id="rtButton" class="mode-button" onclick="location.href='login.php?mode=register'">Register</button>
        <?php endif; ?>
    </div>
</header>

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
</script>
