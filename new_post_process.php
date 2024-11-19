<?php
// new_post_process.php

include 'config.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$titulo = $_POST['cTitulo'];
$descripcion = $_POST['tDescripcion'];

// Insertar el nuevo proyecto en la base de datos
$sql = "INSERT INTO TProyectos (cTitulo, tDescripcion, iUsuario_id) VALUES ('$titulo', '$descripcion', (SELECT iUsuario_id FROM TUsuarios WHERE cUsuario = '$usuario'))";
if ($conn->query($sql) === TRUE) {
    $proyectoId = $conn->insert_id;
    
    // Insertar las imágenes asociadas al proyecto
    foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
        $file = $_FILES['imagenes']['name'][$key];
        $path = "uploads/" . basename($file);
        if (move_uploaded_file($tmp_name, $path)) {
            $sql = "INSERT INTO TArchivo (iProyecto_id, oArchivo) VALUES ('$proyectoId', '$path')";
            $conn->query($sql);
        }
    }

    echo "Publicación exitosa!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
