
document.addEventListener('DOMContentLoaded', () => {
    const imageCarousel = document.getElementById('imageCarousel');
    const addImageBtn = document.getElementById('addImageBtn');
    const imageCount = document.getElementById('imageCount');
    let images = [];
    let imageIndex = 0;

    addImageBtn.addEventListener('click', () => {
        if (images.length < 10) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        addImage(reader.result, images.length);
                        images.push(reader.result);
                        imageCount.textContent = `${images.length}/10`;
                    }
                    reader.readAsDataURL(file);
                }
            }
            input.click();
        } else {
            alert('Máximo 10 imágenes por publicación.');
        }
    });

    function addImage(src, index) {
        const imgContainer = document.createElement('div');
        imgContainer.classList.add('image-container');
        const img = document.createElement('img');
        img.src = src;
        const removeBtn = document.createElement('button');
        removeBtn.textContent = 'X';
        removeBtn.classList.add('remove-btn');
        removeBtn.onclick = () => {
            imgContainer.remove();
            images.splice(index, 1);
            imageCount.textContent = `${images.length}/10`;
        }
        imgContainer.appendChild(img);
        imgContainer.appendChild(removeBtn);
        imageCarousel.appendChild(imgContainer);
    }

    const cancelBtn = document.getElementById('cancelBtn');
    cancelBtn.addEventListener('click', () => {
        if (confirm('¿Estás seguro de que deseas cancelar? Se perderán todos los cambios.')) {
            document.getElementById('newPostModal').style.display = 'none';
        }
    });
});
