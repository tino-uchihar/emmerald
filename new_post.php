<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    die("Error: Debes iniciar sesión para publicar un nuevo proyecto.");
}

$usuario = $_SESSION['usuario'];
?>

<div class="modal-container" id="newPostModal">
    <div class="modal-content">
        <form id="newPostForm" action="new_post_process.php" method="post" enctype="multipart/form-data">
            <div class="grid-container">
                <div class="left-panel">
                    <!-- Input para subir múltiples archivos -->
                    <input type="file" id="imageUpload" name="archivos[]" multiple accept=".jpg, .jpeg, .webp, .png, .gif, .mp4" onchange="handleFileSelect(event)" required>
                    <div id="carousel">
                        <span class="arrow" id="prev">&#9664;</span>
                        <span class="arrow" id="next">&#9654;</span>
                        <span class="remove" id="removeBtn">&#10005;</span>
                    </div>
                </div>
                <div class="right-panel">
                    <div class="field-label">Título</div>
                    <textarea class="input-field" id="titulo" name="titulo" maxlength="100" placeholder="(max 100 caracteres)" required></textarea>
                    <div class="field-label">Descripción</div>
                    <textarea class="input-field" id="descripcion" name="descripcion" maxlength="500" placeholder="(max 500 caracteres)" required></textarea>
                    <div class="buttons">
                        <button type="submit" id="publishBtn">Publicar</button>
                        <button type="button" id="cancelBtn" onclick="closeModal()">Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function closeModal() {
        document.getElementById('newPostModal').style.display = 'none';
    }
</script>
