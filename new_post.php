<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
?>

<div class="modal-container" id="newPostModal">
    <div class="modal-content">
        <div class="left-panel">
            <form action="new_post_process.php" method="post" enctype="multipart/form-data">
                <input type="file" id="imageUpload" name="images[]" multiple accept=".jpg, .jpeg, .webp, .png, .gif, .mp4" onchange="handleFileSelect(event)">
                <input type="submit" value="Subir Imágenes">
            </form>
            <div id="carousel">
                <span class="arrow" id="prev">&#9664;</span>
                <span class="arrow" id="next">&#9654;</span>
                <span class="remove" id="removeBtn">&#10005;</span>
            </div>
        </div>
        <div class="right-panel">
            <form action="new_post_process.php" method="post" enctype="multipart/form-data" id="newPostForm">
                <div class="field-label">Título</div>
                <input type="text" class="input-field" id="cTitulo" name="cTitulo" maxlength="100" placeholder="(max 100 caracteres)" required>
                <div class="field-label">Descripción</div>
                <textarea class="input-field" id="tDescripcion" name="tDescripcion" maxlength="500" placeholder="(max 500 caracteres)" required></textarea>
                <div class="buttons">
                    <button type="submit" id="publishBtn">Publicar</button>
                    <button type="button" id="cancelBtn">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

