document.addEventListener('DOMContentLoaded', () => {
    // Lógica de login/register
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const welcomeSection = document.getElementById('welcome-section');
    const formContainer = document.getElementById('form-container');
    const switchToRegisterBtn = document.getElementById('switch-to-register');
    const switchToLoginBtn = document.getElementById('switch-to-login');

    // Imagen de fondo aleatoria
    const images = ['img1.jpg', 'img2.jpg', 'img3.jpg']; // Lista de imágenes
    const randomImage = images[Math.floor(Math.random() * images.length)];
    document.getElementById('background').style.backgroundImage = `url(${randomImage})`;

    // Funciones para cambiar entre login y registro
    function showLogin() {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        welcomeSection.textContent = 'Bienvenido de vuelta!';
    }

    function showRegister() {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        welcomeSection.textContent = 'Eres nuevo? Regístrate!';
    }

    // Detectar el botón presionado en el index
    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get('action');
    if (action === 'register') {
        showRegister();
    } else {
        showLogin();
    }

    switchToRegisterBtn.addEventListener('click', showRegister);
    switchToLoginBtn.addEventListener('click', showLogin);

    // Lógica de redirección desde index.html
    const loginButton = document.getElementById('login-btn');
    const registerButton = document.getElementById('register-btn');
    if (loginButton) {
        loginButton.addEventListener('click', function() {
            window.location.href = 'login.html?action=login';
        });
    }
    if (registerButton) {
        registerButton.addEventListener('click', function() {
            window.location.href = 'login.html?action=register';
        });
    }
});
