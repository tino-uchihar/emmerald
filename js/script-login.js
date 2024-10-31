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
