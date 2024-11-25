<?php
include 'config.php';
session_start();

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$sql = "SELECT * FROM Usuarios WHERE cUsuario='$usuario'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['cPassword'])) {
        $_SESSION['usuario'] = $usuario;
        header("Location: profile.php?usuario=$usuario");
        exit();
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

$conn->close();
?>
