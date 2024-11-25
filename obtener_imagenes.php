<?php
include 'config.php';

// Consulta para obtener la primera imagen de cada proyecto ordenada por fecha de creación, más nuevas primero
$sql = "
SELECT TArchivos.tArchivo, TArchivos.iProyecto_id
FROM TArchivos
INNER JOIN TProyectos ON TArchivos.iProyecto_id = TProyectos.iProyecto_id
GROUP BY TArchivos.iProyecto_id
ORDER BY TProyectos.dCreacion DESC";

$result = $conn->query($sql);

$images = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = [
            'archivo' => $row['tArchivo'],
            'proyecto_id' => $row['iProyecto_id']
        ];
    }
} else {
    $no_images = true;
}

$conn->close();

?>
