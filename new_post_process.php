<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $total = count($_FILES['images']['name']);
    $uploadDir = 'uploads/';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $allowedExtensions = ['jpg', 'jpeg', 'webp', 'png', 'gif', 'mp4'];

    $cTitulo = $_POST['cTitulo'];
    $tDescripcion = $_POST['tDescripcion'];
    $dCreacion = date('Y-m-d H:i:s');
    $cUrl = 'proyecto_' . time();
    $cUsuario = $_SESSION['usuario']; // Nombre de usuario del usuario actual

    // Obtener iUsuario_id basado en cUsuario
    $sqlUsuario = "SELECT iUsuario_id FROM TUsuarios WHERE cUsuario='$cUsuario'";
    $resultUsuario = $conn->query($sqlUsuario);
    if ($resultUsuario->num_rows > 0) {
        $rowUsuario = $resultUsuario->fetch_assoc();
        $iUsuario_id = $rowUsuario['iUsuario_id'];
    } else {
        die("Error: Usuario no encontrado en la base de datos.");
    }

    // Insertar el proyecto en la base de datos
    $sqlProyecto = "INSERT INTO TProyectos (cTitulo, tDescripcion, dCreacion, cUrl, iUsuario_id, iCategoria_id) VALUES ('$cTitulo', '$tDescripcion', '$dCreacion', '$cUrl', '$iUsuario_id', NULL)";
    if ($conn->query($sqlProyecto) === TRUE) {
        $iProyecto_id = $conn->insert_id; // ID del proyecto recién creado
    } else {
        die("Error al guardar el proyecto: " . $conn->error);
    }

    for ($i = 0; $i < $total; $i++) {
        $tmpFilePath = $_FILES['images']['tmp_name'][$i];
        $extension = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);

        if ($tmpFilePath != "" && in_array(strtolower($extension), $allowedExtensions)) {
            $newFileName = uniqid('', true) . '.' . $extension;
            $newFilePath = $uploadDir . $newFileName;
            move_uploaded_file($tmpFilePath, $newFilePath);

            // Insertar archivo en la base de datos
            $sqlArchivo = "INSERT INTO TArchivos (iProyecto_id, tArchivo) VALUES ('$iProyecto_id', '$newFileName')";
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
