<?php
include 'config.php';

// Consulta para obtener la primera imagen de cada proyecto ordenada por fecha de creación, más nuevas primero
$sql = "
SELECT Archivo.tArchivo, Archivo.nProyectoFK
FROM Archivo
INNER JOIN Proyecto ON Archivo.nProyectoFK = Proyecto.nProyectoID
GROUP BY Archivo.nProyectoFK
ORDER BY Proyecto.dCreacion DESC";

$result = $conn->query($sql);

$images = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = [
            'archivo' => $row['tArchivo'],
            'proyecto_id' => $row['nProyectoFK']
        ];
    }
} else {
    $no_images = true;
}

$conn->close();

?>
