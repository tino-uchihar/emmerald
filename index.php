<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esmeralda</title>
    <link rel="stylesheet" href="css\styles.css">
</head>
<body>
    <?php include 'includes\header.php'; ?>
    <nav>
        <div class="search-bar">
            <button id="clear">Clear</button>
            <input type="text" id="search-bar" placeholder="Buscar...">
            <button id="search">🔍</button>
        </div>
        <div class="categories">
            <button>Categoría 1</button>
            <button>Categoría 2</button>
            <button>Categoría 3</button>
            <button>Categoría 4</button>
            <button>Categoría 5</button>
            <button>Categoría 6</button>
            <button>Categoría 7</button>
        </div>
    </nav>
    <section class="image-gallery">
        <!-- Aquí se mostrarán las imágenes subidas -->
    </section>
    <?php include 'includes\footer.php'; ?>
</body>
</html>
