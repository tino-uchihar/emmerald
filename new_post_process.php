<?php
include 'config.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$titulo = $_POST['cTitulo'] ?? '';
$descripcion = $_POST['tDescripcion'] ?? '';

if (empty($titulo) || empty($descripcion)) {
    echo "El título y la descripción no pueden estar vacíos.";
    exit();
}

// Generar URL única
function generateUniqueUrl($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Verificar que la URL sea única
do {
    $uniqueUrl = generateUniqueUrl();
    $sql = "SELECT * FROM TProyectos WHERE cUrl='$uniqueUrl'";
    $result = $conn->query($sql);
} while ($result->num_rows > 0);

// Insertar el nuevo proyecto en la base de datos
$fechaActual = date('Y-m-d H:i:s');
$sql = "INSERT INTO TProyectos (cTitulo, tDescripcion, dCreacion, cUrl, iUsuario_id, iCategoria_id) VALUES (?, ?, ?, ?, (SELECT iUsuario_id FROM TUsuarios WHERE cUsuario = ?), NULL)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssss', $titulo, $descripcion, $fechaActual, $uniqueUrl, $usuario);

if ($stmt->execute()) {
    $proyectoId = $stmt->insert_id;

    // Insertar las imágenes asociadas al proyecto si existen
    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (isset($_FILES['imagenes']) && !empty($_FILES['imagenes']['tmp_name'][0])) {
        foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
            $file = $_FILES['imagenes']['name'][$key];
            $fileType = $_FILES['imagenes']['type'][$key];
            if (in_array($fileType, $allowedFileTypes)) {
                $path = "uploads/" . basename($file);
                if (move_uploaded_file($tmp_name, $path)) {
                    // Insertar la referencia del archivo en TArchivo
                    $sql = "INSERT INTO TArchivo (iProyecto_id, oArchivo) VALUES (?, ?)";
                    $stmtArchivo = $conn->prepare($sql);
                    $stmtArchivo->bind_param('is', $proyectoId, $path);
                    if (!$stmtArchivo->execute()) {
                        echo "Error al insertar archivo: " . $stmtArchivo->error;
                    }
                }
            } else {
                echo "Solo se permiten archivos de tipo jpg, jpeg, png, webp, y gif.";
                exit();
            }
        }
    }

    // Mostrar notificación y redirigir al usuario a la página de inicio después de la publicación exitosa
    echo "<script>
        alert('¡Publicación exitosa!');
        window.location.href = 'index.php';
    </script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
