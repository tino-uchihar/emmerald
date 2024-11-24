
// funcion para guardar imagenes


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




// Apartir de aqui para que se vea el modal



function openNewPostModal() {
    fetch('new_post.php')
        .then(response => response.text())
        .then(data => {
            const modalContainer = document.createElement('div');
            modalContainer.innerHTML = data;
            document.body.appendChild(modalContainer);
            const script = document.createElement('script');
            script.src = 'js/script-new_post.js';
            document.body.appendChild(script);
            document.getElementById('closeModalBtn').addEventListener('click', () => {
                modalContainer.remove();
            });
            document.getElementById('cancelBtn').addEventListener('click', () => {
                if (confirm('¿Estás seguro de que deseas cancelar? Se perderán todos los cambios.')) {
                    modalContainer.remove();
                }
            });
        })
        .catch(error => console.error('Error al cargar el modal:', error));
}
