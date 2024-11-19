<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
$nombre = '@' . htmlspecialchars($usuario); // Añadir @ al nombre del usuario y escapar para evitar XSS
$profile_image = "path_to_profile_image/$usuario.jpg";

// Verificar si la imagen de perfil existe
if (!file_exists($profile_image)) {
    $profile_image = 'images/iconodefault.png'; // Imagen predeterminada
}
?>

<aside class="user-aside" id="user-aside">
    <button class="close-aside" onclick="cerrarAside()">X</button>
    <div class="user-profile">
        <img class="profile-pic" src="<?php echo $profile_image; ?>" alt="Imagen de perfil de <?php echo $usuario; ?>">
        <p><?php echo $nombre; ?></p>
        <button onclick="location.href='profile.php?usuario=<?php echo $usuario; ?>'">Perfil</button>
        <button disabled>Mensajes</button>
        <button disabled>Configuración</button>
        <button id="logoutButton">Cerrar Sesión</button>
    </div>
</aside>

<div id="logoutNotification" class="notification">
    <div class="notification-content">
        <p>¿Seguro?</p>
        <button id="confirmLogout">Sí</button>
        <button onclick="cerrarNotificacion()">No</button>
    </div>
</div>

<script>
function cerrarAside() {
    const aside = document.getElementById('user-aside');
    if (aside) {
        aside.remove();
    }
}

// Cerrar el aside al hacer clic fuera de él
window.addEventListener('click', function(event) {
    const aside = document.getElementById('user-aside');
    if (aside && !aside.contains(event.target) && event.target.id !== 'userButton') {
        cerrarAside();
    }
});

// Mostrar la notificación de cierre de sesión
document.getElementById('logoutButton').addEventListener('click', function(event) {
    event.stopPropagation(); // Prevenir que el click cierre el aside
    document.getElementById('logoutNotification').style.display = 'flex';
});

// Confirmar y proceder con el cierre de sesión (actualmente no hace nada)
document.getElementById('confirmLogout').addEventListener('click', function() {
    alert('Sesión cerrada'); // Aquí podrías agregar la redirección a logout.php si lo deseas
    cerrarNotificacion();
});

function cerrarNotificacion() {
    document.getElementById('logoutNotification').style.display = 'none';
}

// Prevenir que el click dentro del aside cierre el aside
document.getElementById('user-aside').addEventListener('click', function(event) {
    event.stopPropagation();
});
</script>
