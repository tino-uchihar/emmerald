<?php
include 'config.php';
session_start();

$iProyecto_id = $_GET['id'];

// Obtener datos del proyecto
$sqlProyecto = "SELECT TProyectos.cTitulo, TProyectos.tDescripcion, TUsuarios.cUsuario, TUsuarios.tFoto_perfil, TProyectos.dCreacion
                FROM TProyectos 
                INNER JOIN TUsuarios ON TProyectos.iUsuario_id = TUsuarios.iUsuario_id
                WHERE TProyectos.iProyecto_id = '$iProyecto_id'";
$resultProyecto = $conn->query($sqlProyecto);

if ($resultProyecto->num_rows > 0) {
    $proyecto = $resultProyecto->fetch_assoc();
} else {
    die("Proyecto no encontrado.");
}

// Obtener imágenes del proyecto
$sqlArchivos = "SELECT tArchivo FROM TArchivos WHERE iProyecto_id = '$iProyecto_id'";
$resultArchivos = $conn->query($sqlArchivos);

$archivos = [];
if ($resultArchivos->num_rows > 0) {
    while ($row = $resultArchivos->fetch_assoc()) {
        $archivos[] = $row['tArchivo'];
    }
}

// Establecer imagen de perfil por defecto si no tiene una
if (empty($proyecto['tFoto_perfil'])) {
    $proyecto['tFoto_perfil'] = 'images/iconodefault.png';
}

$conn->close();
?>



<div class="modal-container-preview" id="previewPostModal">
    <div class="modal-content-preview">
        <div class="grid-container-preview">
            <div class="left-panel-preview">
                <div id="previewCarousel">
                    <span class="preview-arrow" id="previewPrev">&#9664;</span>
                    <?php foreach ($archivos as $archivo): ?>
                        <img src="uploads/<?php echo $archivo; ?>" alt="Imagen del Proyecto">
                    <?php endforeach; ?>
                    <span class="preview-arrow" id="previewNext">&#9654;</span>
                </div>
            </div>
            <div class="right-panel-preview">
                <div class="parent">
                    <div class="div1">
                        <img src="<?php echo $proyecto['tFoto_perfil']; ?>" alt="Foto de Perfil" class="perfil-foto">
                    </div>
                    <div class="div2">
                        <a href="#"><?php echo $proyecto['cUsuario']; ?></a>
                    </div>
                    <div class="div3">
                        <p><?php echo date('d/m/Y H:i', strtotime($proyecto['dCreacion'])); ?></p>
                    </div>
                    <div class="div4">
                        <h2><?php echo $proyecto['cTitulo']; ?></h2>
                    </div>
                    <div class="div5">
                        <p><?php echo $proyecto['tDescripcion']; ?></p>
                    </div>
                    <div class="div6">
                        <label for="comentarios">Comentarios</label>
                    </div>
                    <div class="div7">
                        <textarea id="comentarios" placeholder="Escribe un comentario..."></textarea>
                    </div>
                    <div class="div8">
                        <button type="button" disabled>Like</button>
                    </div>
                    <div class="div9">
                        <button type="submit" disabled>Comentar</button>
                    </div>
                    <div class="div10">
                        <div class="comments-preview">
                            <!-- Campo para previsualizar comentarios -->
                        </div>
                    </div>
                    <div class="div11">
                        <!-- Vacío pero existente -->
                    </div>
                    <div class="div12">
                        <button type="button" id="closeModalBtnPreview">Salir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('closeModalBtnPreview').addEventListener('click', function() {
    document.getElementById('previewPostModal').remove();
});
</script>
