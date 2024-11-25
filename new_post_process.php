<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $total = count($_FILES['archivos']['name']); // Cambiado 'images' por 'archivos'
    $uploadDir = 'uploads/';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $allowedExtensions = ['jpg', 'jpeg', 'webp', 'png', 'gif', 'mp4'];

    $titulo = $_POST['titulo']; // Cambiado 'cTitulo' por 'titulo'
    $descripcion = $_POST['descripcion']; // Cambiado 'tDescripcion' por 'descripcion'
    $fecha_creacion = date('Y-m-d H:i:s'); // Cambiado 'dCreacion' por 'fecha_creacion'
    $url = 'proyecto_' . time(); // Cambiado 'cUrl' por 'url'
    $usuario = $_SESSION['usuario']; // Nombre de usuario del usuario actual

    // Obtener id_usuario basado en usuario
    $sqlUsuario = "SELECT id_usuario FROM usuarios WHERE usuario='$usuario'"; // Ajustado según nueva base
    $resultUsuario = $conn->query($sqlUsuario);
    if ($resultUsuario->num_rows > 0) {
        $rowUsuario = $resultUsuario->fetch_assoc();
        $id_usuario = $rowUsuario['id_usuario']; // Cambiado 'iUsuario_id' por 'id_usuario'
    } else {
        die("Error: Usuario no encontrado en la base de datos.");
    }

    // Insertar el proyecto en la base de datos
    $sqlProyecto = "INSERT INTO proyectos (titulo, descripcion, fecha_creacion, url, id_usuario, id_categoria) 
                    VALUES ('$titulo', '$descripcion', '$fecha_creacion', '$url', '$id_usuario', NULL)";
    if ($conn->query($sqlProyecto) === TRUE) {
        $id_proyecto = $conn->insert_id; // Cambiado 'iProyecto_id' por 'id_proyecto'
    } else {
        die("Error al guardar el proyecto: " . $conn->error);
    }

    // Guardar archivos
    for ($i = 0; $i < $total; $i++) {
        $tmpFilePath = $_FILES['archivos']['tmp_name'][$i]; // Cambiado 'images' por 'archivos'
        $extension = pathinfo($_FILES['archivos']['name'][$i], PATHINFO_EXTENSION); // Cambiado 'images' por 'archivos'

        if ($tmpFilePath != "" && in_array(strtolower($extension), $allowedExtensions)) {
            $newFileName = uniqid('', true) . '.' . $extension;
            $newFilePath = $uploadDir . $newFileName;
            move_uploaded_file($tmpFilePath, $newFilePath);

            // Insertar archivo en la base de datos
            $sqlArchivo = "INSERT INTO archivos (id_proyecto, archivo) VALUES ('$id_proyecto', '$newFileName')"; // Ajustado según nueva base
            if ($conn->query($sqlArchivo) !== TRUE) {
                die("Error al guardar el archivo: " . $conn->error);
            }
        }
    }

    echo "<script>
            alert('Archivos subidos correctamente y datos guardados!');
            window.location.href = 'index.php';
        </script>";
    exit();
}
?>
