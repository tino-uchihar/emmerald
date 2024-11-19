<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $directorio = "uploads/";
    $archivo = $directorio . basename($_FILES["archivo"]["name"]);
    $subidaOk = 1;
    $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

  
    $check = getimagesize($_FILES["archivo"]["tmp_name"]);
    if($check !== false) {
        echo "El archivo es una imagen - " . $check["mime"] . ".";
        $subidaOk = 1;
    } else {
        echo "El archivo no es una imagen.";
        $subidaOk = 0;
    }

  
    if (file_exists($archivo)) {
        echo "Lo siento, el archivo ya existe.";
        $subidaOk = 0;
    }


    if ($_FILES["archivo"]["size"] > 500000) { // 500KB
        echo "Lo siento, el archivo es demasiado grande.";
        $subidaOk = 0;
    }

    if($tipoArchivo != "jpg" && $tipoArchivo != "png" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif" ) {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $subidaOk = 0;
    }

    if ($subidaOk == 0) {
        echo "Lo siento, tu archivo no fue subido.";
  
    } else {
        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo)) {
            echo "El archivo ". basename( $_FILES["archivo"]["name"]). " ha sido subido.";
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    }
}
?>
