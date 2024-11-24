<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $total = count($_FILES['images']['name']);
    $uploadDir = 'uploads/';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $allowedExtensions = ['jpg', 'jpeg', 'webp', 'png', 'gif', 'mp4'];

    for ($i = 0; $i < $total; $i++) {
        $tmpFilePath = $_FILES['images']['tmp_name'][$i];
        $extension = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);

        if ($tmpFilePath != "" && in_array(strtolower($extension), $allowedExtensions)) {
            $newFileName = uniqid('', true) . '.' . $extension;
            $newFilePath = $uploadDir . $newFileName;
            move_uploaded_file($tmpFilePath, $newFilePath);
        }
    }

    echo "<script>
            alert('Archivos subidos correctamente!');
            window.location.href = 'index.php';
        </script>";
    exit();
    
}
?>
