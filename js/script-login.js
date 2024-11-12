// Función para detectar mayúsculas activas
function detectCapsLock(event) {
    var capsLockOn = event.getModifierState('CapsLock');
    var warning = document.getElementById('caps-warning');
    if (!warning) {
        var warningMessage = document.createElement('p');
        warningMessage.id = 'caps-warning';
        warningMessage.style.color = 'red';
        warningMessage.innerText = '¡Mayúsculas activas!';
        this.parentNode.insertBefore(warningMessage, this.nextSibling);
    }
    if (capsLockOn) {
        warning.style.display = 'block';
    } else {
        warning.style.display = 'none';
    }
}

// Añadir el evento a todos los campos de entrada
var inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
inputs.forEach(function(input) {
    input.addEventListener('keyup', detectCapsLock);
    input.addEventListener('click', detectCapsLock);
});

// Función para validar el correo electrónico
function validateEmail(email) {
    // Verificar el formato del correo electrónico y asegurarse de que no contenga números después del @
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const domainPart = email.split('@')[1];
    return regex.test(email) && !/\d/.test(domainPart);
}

function validateForm() {
    const emailInput = document.getElementById('register-correo');
    if (!validateEmail(emailInput.value)) {
        alert('Por favor, ingrese un correo electrónico válido sin números en el dominio.');
        return false;
    }
    return true;
}




document.addEventListener('DOMContentLoaded', function () {
    // Verifica si estamos en login.php
    const urlParams = new URLSearchParams(window.location.search);
    const mode = urlParams.get('mode');

    if (window.location.pathname.includes('login.php')) {
        // Desactivar los onClick de los botones cuando estamos en login.php
        const buttons = document.querySelectorAll('.mode-button');
        buttons.forEach(button => {
            button.setAttribute('data-href', button.getAttribute('onclick').replace('location.href=', '').replace(/'/g, ""));
            button.removeAttribute('onclick');
        });

        // Función para cambiar el modo dentro de login.php
        function changeMode(newMode) {
            const halfContainers = document.querySelectorAll('.half-container');
            const bgImage = document.querySelector('.background-image');

            console.log('Cambiando al modo:', newMode); // Log de depuración

            // Añadir clases de animación
            halfContainers.forEach(container => {
                container.classList.remove('animate-slide-left', 'animate-slide-right');
                if (newMode === 'login') {
                    container.classList.add('animate-slide-right');
                } else if (newMode === 'register') {
                    container.classList.add('animate-slide-left');
                }
            });

            bgImage.classList.add('animate-fade-out');

            // Esperar a que la animación termine antes de cambiar el contenido
            setTimeout(() => {
                console.log('Redireccionando a:', `login.php?mode=${newMode}`); // Log de depuración
                window.location.href = `login.php?mode=${newMode}`;
            }, 500);
        }

        // Añadir eventos a los botones
        const ltButton = document.getElementById('ltButton');
        const rtButton = document.getElementById('rtButton');

        if (ltButton) {
            ltButton.addEventListener('click', (event) => {
                event.preventDefault();
                console.log('ltButton clickeado'); // Log de depuración
                changeMode('login');
            });
        }

        if (rtButton) {
            rtButton.addEventListener('click', (event) => {
                event.preventDefault();
                console.log('rtButton clickeado'); // Log de depuración
                changeMode('register');
            });
        }
    }
});
