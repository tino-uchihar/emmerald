<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Esmeralda</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section class="form-container">
        <?php
        $mode = isset($_GET['mode']) ? $_GET['mode'] : 'login';
        ?>
        <div class="half-container">
            <?php if ($mode == 'login'): ?>
                <form action="login_process.php" method="post">
                    <h2>Iniciar Sesión</h2>
                    <label for="login-usuario">Usuario</label>
                    <input type="text" id="login-usuario" name="usuario" maxlength="24" required>
                    <label for="login-password">Contraseña</label>
                    <input type="password" id="login-password" name="password" required>
                    <button type="submit">Iniciar Sesión</button>
                </form>
            <?php else: ?>
                <div class="background-image" id="login-bg">
                    <p>Bienvenido de nuevo</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="half-container">
            <?php if ($mode == 'register'): ?>
                <form action="register_process.php" method="post" onsubmit="return validateForm()">
                    <h2>Registrarse</h2>
                    <label for="register-nombre">Nombre</label>
                    <input type="text" id="register-nombre" name="nombre" maxlength="48" required>
                    <label for="register-usuario">Usuario</label>
                    <input type="text" id="register-usuario" name="usuario" maxlength="24" required>
                    <label for="register-correo">Correo</label>
                    <input type="email" id="register-correo" name="correo" maxlength="100" required>
                    <label for="register-password">Contraseña</label>
                    <input type="password" id="register-password" name="password" required>
                    <p id="caps-warning" style="color:red; display:none;">¡Mayúsculas activas!</p>
                    <button type="submit">Registrarse</button>
                </form>
            <?php else: ?>
                <div class="background-image" id="register-bg">
                    <p>Gracias por unirte!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php include 'includes/footer.php'; ?>
    <script src="js/script-login.js"></script>
</body>
</html>
