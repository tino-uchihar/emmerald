<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página no encontrada</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="error-container">
        <h1>Error 404 - Página no encontrada!</h1>
        <img src="images/404-image.jpg" alt="Error 404">
        <button onclick="location.href='index.php'">Regresar al inicio</button>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
