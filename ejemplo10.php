<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsualización y Carga de Imágenes</title>
    <style>
        #carousel {
            width: 700px;
            height: 700px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .arrow, .remove {
            cursor: pointer;
            user-select: none;
            position: absolute;
        }

        .arrow {
            top: 50%;
            transform: translateY(-50%);
            font-size: 2rem;
        }

        #prev {
            left: 10px;
        }

        #next {
            right: 10px;
        }

        .remove {
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            background: #ff0000;
            color: #fff;
            padding: 0 5px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" id="imageUpload" name="images[]" multiple accept=".jpg, .jpeg, .webp, .png, .gif, .mp4" onchange="handleFileSelect(event)">
        <input type="submit" value="Subir Imágenes">
    </form>
    <div id="carousel">
        <span class="arrow" id="prev">&#9664;</span>
        <span class="arrow" id="next">&#9654;</span>
        <span class="remove" id="removeBtn">&#10005;</span>
    </div>

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

        echo "Imágenes subidas con éxito.";
    }
    ?>

    <script>
        const maxFiles = 10;
        let selectedFiles = [];
        let currentIndex = 0;

        function handleFileSelect(event) {
            const files = Array.from(event.target.files);
            const allowedExtensions = ['jpg', 'jpeg', 'webp', 'png', 'gif', 'mp4'];

            if (files.length > maxFiles) {
                alert(`Puedes seleccionar un máximo de ${maxFiles} archivos.`);
                event.target.value = ''; // Reset input
                return;
            }

            const invalidFiles = files.filter(file => !allowedExtensions.includes(file.name.split('.').pop().toLowerCase()));
            if (invalidFiles.length > 0) {
                alert('Algunos archivos no tienen extensiones permitidas. Solo se permiten: .jpg, .jpeg, .webp, .png, .gif, .mp4');
                event.target.value = ''; // Reset input
                return;
            }

            selectedFiles = files.filter(file => allowedExtensions.includes(file.name.split('.').pop().toLowerCase())).map(file => ({ name: file.name, file: file }));
            currentIndex = 0;
            const carousel = document.getElementById('carousel');
            carousel.style.backgroundImage = '';

            selectedFiles.forEach((fileObj, i) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fileObj.data = e.target.result;
                    if (i === 0) {
                        carousel.style.backgroundImage = `url(${e.target.result})`;
                    }
                };
                reader.readAsDataURL(fileObj.file);
            });

            window.uploadedFiles = selectedFiles.map(fileObj => fileObj.file);
        }

        function updateCarousel() {
            const carousel = document.getElementById('carousel');
            if (selectedFiles.length > 0) {
                carousel.style.backgroundImage = `url(${selectedFiles[currentIndex].data})`;
            } else {
                carousel.style.backgroundImage = '';
            }
        }

        function removeCurrentImage() {
            if (selectedFiles.length === 0) return;

            selectedFiles.splice(currentIndex, 1);
            window.uploadedFiles.splice(currentIndex, 1);

            if (selectedFiles.length > 0) {
                currentIndex = currentIndex % selectedFiles.length;
                updateCarousel();
            } else {
                currentIndex = 0;
                updateCarousel();
            }

            const dataTransfer = new DataTransfer();
            window.uploadedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('imageUpload').files = dataTransfer.files;
        }

        const prev = document.getElementById('prev');
        const next = document.getElementById('next');
        const removeBtn = document.getElementById('removeBtn');

        prev.addEventListener('click', () => {
            if (selectedFiles.length > 0) {
                currentIndex = (currentIndex - 1 + selectedFiles.length) % selectedFiles.length;
                updateCarousel();
            }
        });

        next.addEventListener('click', () => {
            if (selectedFiles.length > 0) {
                currentIndex = (currentIndex + 1) % selectedFiles.length;
                updateCarousel();
            }
        });

        removeBtn.addEventListener('click', () => {
            removeCurrentImage();
        });
    </script>
</body>
</html>
