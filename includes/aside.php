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
        <button id="logoutButton" onclick="location.href='logout.php'">Cerrar Sesión</button>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function cerrarAside() {
        console.log("cerrarAside ejecutado");
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

    // Prevenir que el click dentro del aside cierre el aside
    document.getElementById('user-aside').addEventListener('click', function(event) {
        event.stopPropagation();
        console.log("click dentro del aside, evento parado");
    });
});
</script>
