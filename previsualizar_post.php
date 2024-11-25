<?php
include 'config.php';
session_start();

$iProyecto_id = $_GET['id'];

// Obtener datos del proyecto
$sqlProyecto = "SELECT TProyectos.cTitulo, TProyectos.tDescripcion, TUsuarios.cNombre
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

$conn->close();
?>

<div class="modal-container-preview" id="previewPostModal">
    <div class="modal-content-preview">
        <div class="grid-container-preview">
            <div class="left-panel-preview">
                <?php foreach ($archivos as $archivo): ?>
                    <img src="uploads/<?php echo $archivo; ?>" alt="Imagen del Proyecto">
                <?php endforeach; ?>
            </div>
            <div class="right-panel-preview">
                <h2><?php echo $proyecto['cTitulo']; ?></h2>
                <p><?php echo $proyecto['tDescripcion']; ?></p>
                <p><strong>Autor:</strong> <?php echo $proyecto['cNombre']; ?></p>
                <div class="buttons-preview">
                    <button type="button">Like</button>
                    <label for="comentarios">Comentarios</label>
                    <textarea id="comentarios" placeholder="Escribe un comentario..."></textarea>
                    <button type="button">Comentar</button>
                    <button type="button" id="closeModalBtnPreview">Salir</button>
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
