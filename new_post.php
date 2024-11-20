<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Publicación - Esmeralda</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/script-new_post.js"></script>
</head>
<body>
    <div class="modal-container" id="newPostModal">
        <div class="modal-content">
            <div class="left-panel">
                <div id="imageCarousel">
                    <!-- Las imágenes cargadas aparecerán aquí -->
                </div>
                <div class="controls">
                    <span id="imageCount">0/10</span>
                    <button id="addImageBtn">+</button>
                </div>
            </div>
            <div class="right-panel">
                <form action="new_post_process.php" method="post" enctype="multipart/form-data" id="newPostForm">
                    <div class="field-label">Título</div>
                    <input type="text" class="input-field" id="cTitulo" name="cTitulo" maxlength="100" placeholder="(max 100 caracteres)" required>
                    <div class="field-label">Descripción</div>
                    <textarea class="input-field" id="tDescripcion" name="tDescripcion" maxlength="500" placeholder="(max 500 caracteres)" required></textarea>
                    <input type="file" name="imagenes[]" id="imagenes" accept=".jpg, .jpeg, .png, .webp, .gif" multiple>
                    <div class="buttons">
                        <button type="submit">Publicar</button>
                        <button type="button" id="cancelBtn">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
