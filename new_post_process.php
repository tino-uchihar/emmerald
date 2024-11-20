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

function generateUniqueUrl($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

do {
    $uniqueUrl = generateUniqueUrl();
    $sql = "SELECT * FROM TProyectos WHERE cUrl='$uniqueUrl'";
    $result = $conn->query($sql);
} while ($result->num_rows > 0);

$fechaActual = date('Y-m-d H:i:s');
$sql = "INSERT INTO TProyectos (cTitulo, tDescripcion, dCreacion, cUrl, iUsuario_id, iCategoria_id) VALUES (?, ?, ?, ?, (SELECT iUsuario_id FROM TUsuarios WHERE cUsuario = ?), NULL)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssss', $titulo, $descripcion, $fechaActual, $uniqueUrl, $usuario);

if ($stmt->execute()) {
    $proyectoId = $stmt->insert_id;

    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $imagesArray = [];

    if (isset($_FILES['imagenes']) && !empty($_FILES['imagenes']['tmp_name'][0])) {
        $totalFiles = count($_FILES['imagenes']['name']);

        for ($i = 0; $i < $totalFiles; $i++) {
            $fileName = $_FILES['imagenes']['name'][$i];
            $tmpName = $_FILES['imagenes']['tmp_name'][$i];

            $fileExtension = explode('.', $fileName);
            $fileExtension = strtolower(end($fileExtension));

            if (in_array($_FILES['imagenes']['type'][$i], $allowedFileTypes)) {
                $newFileName = uniqid() . '.' . $fileExtension;
                if (move_uploaded_file($tmpName, 'uploads/' . $newFileName)) {
                    $imagesArray[] = $newFileName;
                } else {
                    echo "Error al mover el archivo $fileName.<br>";
                }
            } else {
                echo "Solo se permiten archivos de tipo jpg, jpeg, png, webp, y gif.<br>";
                exit();
            }
        }

        if (!empty($imagesArray)) {
            $imagesJson = json_encode($imagesArray);
            $sql = "INSERT INTO TArchivos (iProyecto_id, tArchivo) VALUES (?, ?)";
            $stmtArchivo = $conn->prepare($sql);
            $stmtArchivo->bind_param('is', $proyectoId, $imagesJson);

            if (!$stmtArchivo->execute()) {
                echo "Error al insertar archivos: " . $stmtArchivo->error . "<br>";
            } else {
                echo "Archivos subidos y guardados correctamente. <br>";
            }
        }
    } else {
        echo "No se seleccionaron archivos para subir.<br>";
    }

    echo "<script>
        alert('¡Publicación exitosa!');
        window.location.href = 'index.php';
    </script>";
} else {
    echo "Error: " . $stmt->error . "<br>";
}

$stmt->close();
$conn->close();
?>
