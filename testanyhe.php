<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Subida de Imagen</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="left">
            <img id="vistaPrevia" src="" alt="Vista previa de la imagen">
        </div>
        <div class="right">
            <form action="testanyhe2.php" method="post" enctype="multipart/form-data">
                <input type="file" name="archivo" id="archivo" onchange="mostrarVistaPrevia(event)">
                <input type="text" name="texto" placeholder="Ingresar texto">
                <input type="submit" value="Subir Imagen" name="submit">
                <button type="button">Atrás</button>
            </form>
        </div>
    </div>
    <script>
        function mostrarVistaPrevia(event) {
            var leerArchivo = new FileReader();
            var idImagen = document.getElementById('vistaPrevia');
            
            leerArchivo.onload = function() {
                if (leerArchivo.readyState == 2) {
                    idImagen.src = leerArchivo.result;
                }
            }
            
            leerArchivo.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
