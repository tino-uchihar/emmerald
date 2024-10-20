<?php
include 'config.php';

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$sql = "SELECT * FROM TUsuarios WHERE cUsuario='$usuario'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['cPassword'])) {
        echo "Inicio de sesión exitoso!";
        // Aquí puedes iniciar la sesión y redirigir al usuario
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

$conn->close();
?>
