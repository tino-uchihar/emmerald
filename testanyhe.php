<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Imagen</title>
</head>
<body>
    <form action="testanyhe2.php" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Selecciona una imagen para subir:</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Subir Imagen" name="submit">
    </form>
</body>
</html>