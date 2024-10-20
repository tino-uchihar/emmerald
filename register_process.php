<?php
include 'config.php';

$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$correo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO TUsuarios (cNombre, cUsuario, cCorreo, cPassword) VALUES ('$nombre', '$usuario', '$correo', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registro exitoso!";
    // Aquí puedes redirigir al usuario a la página de inicio de sesión
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
