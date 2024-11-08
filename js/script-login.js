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
