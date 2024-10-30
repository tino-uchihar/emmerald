<?php
include 'config.php';

$usuario = $_GET['usuario'];

// Verificar si el usuario existe
$sql = "SELECT * FROM TUsuarios WHERE cUsuario='$usuario'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil - <?php echo $row['cUsuario']; ?></title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <?php include 'includes/header.php'; ?>
        <section class="profile-container">
            <h2><?php echo $row['cNombre']; ?></h2>
            <img src="default-profile.png" alt="Foto de perfil">
            <p><?php echo $row['tBiografia']; ?></p>
            <div class="posts">
                <!-- Aquí irán las publicaciones del usuario -->
            </div>
        </section>
        <?php include 'includes/footer.php'; ?>
    </body>
    </html>
    <?php
} else {
    header("Location: ErrorPerfil.php");
    exit();
}
$conn->close();
?>
