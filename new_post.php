<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
?>

<div class="modal-container" id="newPostModal">
    <div class="modal-content">
        <form id="newPostForm" action="new_post_process.php" method="post" enctype="multipart/form-data">
            <div class="grid-container">
                <div class="left-panel">
                    <input type="file" id="imageUpload" name="images[]" multiple accept=".jpg, .jpeg, .webp, .png, .gif, .mp4" onchange="handleFileSelect(event)">
                    <div id="carousel">
                        <span class="arrow" id="prev">&#9664;</span>
                        <span class="arrow" id="next">&#9654;</span>
                        <span class="remove" id="removeBtn">&#10005;</span>
                    </div>
                </div>
                <div class="right-panel">
                    <div class="field-label">Título</div>
                    <input type="text" class="input-field" id="cTitulo" name="cTitulo" maxlength="100" placeholder="(max 100 caracteres)" required>
                    <div class="field-label">Descripción</div>
                    <textarea class="input-field" id="tDescripcion" name="tDescripcion" maxlength="500" placeholder="(max 500 caracteres)" required></textarea>
                    <div class="buttons">
                        <button type="submit" id="publishBtn">Publicar</button>
                        <button type="button" id="cancelBtn">Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
