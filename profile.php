<?php
include 'config.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener los datos del usuario
$usuario = $_SESSION['usuario'];
$sql = "SELECT * FROM Usuarios WHERE cUsuario='$usuario'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    header("Location: ErrorPerfil.php"); // Redirigir a ErrorPerfil.php si el usuario no existe
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?php echo htmlspecialchars($row['cUsuario']); ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section class="profile-container">
        <div class="profile-header">
            <img id="profile-pic" src="images/iconodefault.png" alt="Foto de perfil" class="profile-pic">
            <h2>@<?php echo htmlspecialchars($row['cUsuario']); ?></h2>
            <h3><?php echo htmlspecialchars($row['cNombre']); ?></h3>
            <p><?php echo htmlspecialchars($row['tBiografia']); ?></p>
            <button>Editar Perfil</button>
        </div>
        <div class="profile-content">
            <!-- Aquí se mostrarán las publicaciones del usuario -->
        </div>
    </section>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
