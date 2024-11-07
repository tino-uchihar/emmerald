<?php
include 'config.php';
session_start();

// Convertir usuario y correo a minúsculas
$nombre = $_POST['nombre'];
$usuario = strtolower($_POST['usuario']);
$correo = strtolower($_POST['correo']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Verificar si el usuario o el correo ya existen
$sql_verificacion = "SELECT * FROM TUsuarios WHERE cUsuario='$usuario' OR cCorreo='$correo'";
$result_verificacion = $conn->query($sql_verificacion);
if ($result_verificacion->num_rows > 0) {
    $row = $result_verificacion->fetch_assoc();
    if ($row['cUsuario'] == $usuario) {
        echo "<script>document.getElementById('register-usuario').value=''; document.getElementById('register-usuario').placeholder='Error!, usuario en uso';</script>";
    }
    if ($row['cCorreo'] == $correo) {
        echo "<script>document.getElementById('register-correo').value=''; document.getElementById('register-correo').placeholder='Error!, correo en uso';</script>";
    }
} else {
    // Si no hay duplicados, realizar el registro
    $sql = "INSERT INTO TUsuarios (cNombre, cUsuario, cCorreo, cPassword) VALUES ('$nombre', '$usuario', '$correo', '$password')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['usuario'] = $usuario;
        echo "<script>alert('Registro exitoso!'); window.location.href='profile.php?usuario=$usuario';</script>"; // Alerta y redirección a profile.php
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
