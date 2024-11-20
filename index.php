<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esmeralda</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
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
        <?php
        include 'config.php';

        // Clave para desencriptar si estás usando encriptación
        $clave = 'estaesunallavesecreta';

        // Recuperar todas las publicaciones y sus imágenes, ordenadas por fecha
        $sql = "SELECT TProyectos.cTitulo, TProyectos.dCreacion, TArchivos.tArchivo 
                FROM TProyectos 
                JOIN TArchivo ON TProyectos.iProyecto_id = TArchivos.iProyecto_id 
                ORDER BY TProyectos.dCreacion DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="gallery-row">';
            while ($row = $result->fetch_assoc()) {
                $imagenes = json_decode($row['tArchivo']);
                echo '<div class="gallery-item">';
                foreach ($imagenes as $imagen) {
                    echo '<img src="uploads/' . htmlspecialchars($imagen) . '" alt="' . htmlspecialchars($row['cTitulo']) . '" width="200">';
                }
                echo '<p>' . htmlspecialchars($row['cTitulo']) . '</p>';
                echo '</div>';
            }
            echo '</div>'; // Cerrar la fila
        } else {
            echo '<p>No hay publicaciones disponibles.</p>';
        }

        $conn->close();
        ?>
    </section>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
