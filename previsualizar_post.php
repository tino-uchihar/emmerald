<?php
include 'config.php';
session_start();

// Validar el parámetro `id` para evitar inyecciones SQL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$iProyecto_id = intval($_GET['id']);

// Obtener datos del proyecto
$sqlProyecto = "SELECT Proyectos.cTitulo, Proyectos.tDescripcion, Usuarios.cUsuario, Usuarios.tFoto_perfil, Proyectos.dCreacion
                FROM Proyectos 
                INNER JOIN Usuarios ON Proyectos.iUsuario_id = Usuarios.iUsuario_id
                WHERE Proyectos.iProyecto_id = ?";
$stmt = $conn->prepare($sqlProyecto);
if (!$stmt) {
    die("Error en la consulta SQL: " . $conn->error);
}

$stmt->bind_param("i", $iProyecto_id);
$stmt->execute();
$resultProyecto = $stmt->get_result();

if ($resultProyecto->num_rows > 0) {
    $proyecto = $resultProyecto->fetch_assoc();
} else {
    die("Proyecto no encontrado.");
}

// Obtener imágenes del proyecto
$sqlArchivos = "SELECT tArchivo FROM Archivos WHERE iProyecto_id = ?";
$stmt = $conn->prepare($sqlArchivos);
if (!$stmt) {
    die("Error en la consulta SQL: " . $conn->error);
}

$stmt->bind_param("i", $iProyecto_id);
$stmt->execute();
$resultArchivos = $stmt->get_result();

$archivos = [];
if ($resultArchivos->num_rows > 0) {
    while ($row = $resultArchivos->fetch_assoc()) {
        // Agregar la ruta completa a cada archivo
        $archivos[] = 'uploads/' . $row['tArchivo'];
    }
}

// Establecer imagen de perfil por defecto si no tiene una
if (empty($proyecto['tFoto_perfil'])) {
    $proyecto['tFoto_perfil'] = 'images/iconodefault.png';
}

$conn->close();
?>

<script>
const images = <?php echo json_encode($archivos); ?>;
if (typeof initializeCarousel === 'function') {
    console.log("✔ 'images' definido correctamente. Inicializando el carrusel...");
    initializeCarousel();
} else {
    console.log("❌ 'initializeCarousel' aún no está disponible. Esperando a que el script se cargue.");
    document.addEventListener('initializeReady', () => {
        console.log("✔ Evento 'initializeReady' recibido. Inicializando el carrusel...");
        initializeCarousel();
    });
}
</script>

<div class="modal-container-preview" id="previewPostModal">
    <div class="modal-content-preview">
        <div class="grid-container-preview">
            <div class="left-panel-preview">
                <div id="previewCarousel">
                    <span class="preview-arrow" id="previewPrev">◀</span>
                    <div class="carousel-images">
                        <?php foreach ($archivos as $archivo): ?>
                            <img src="<?php echo $archivo; ?>" alt="Imagen del Proyecto">
                        <?php endforeach; ?>
                    </div>
                    <span class="preview-arrow" id="previewNext">▶</span>
                </div>
            </div>
            <div class="right-panel-preview">
                <div class="parent">
                    <div class="div1">
                        <img src="<?php echo $proyecto['tFoto_perfil']; ?>" alt="Foto de Perfil" class="perfil-foto">
                    </div>
                    <div class="div2">
                        <a href="#"><?php echo htmlspecialchars($proyecto['cUsuario']); ?></a>
                    </div>
                    <div class="div3">
                        <p><?php echo date('d/m/Y H:i', strtotime($proyecto['dCreacion'])); ?></p>
                    </div>
                    <div class="div4">
                        <h2><?php echo htmlspecialchars($proyecto['cTitulo']); ?></h2>
                    </div>
                    <div class="div5">
                        <p><?php echo htmlspecialchars($proyecto['tDescripcion']); ?></p>
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
