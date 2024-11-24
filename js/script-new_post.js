

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
