<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Esmeralda</title>
    <link rel="stylesheet" href="css\styles.css">
</head>
<body>
    <?php include 'includes\header.php'; ?>
    <section class="form-container">
        <h2>Iniciar Sesión</h2>
        <form action="login_process.php" method="post">
            <label for="login-usuario">Usuario</label>
            <input type="text" id="login-usuario" name="usuario" required>
            <label for="login-password">Contraseña</label>
            <input type="password" id="login-password" name="password" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <h2>Registrarse</h2>
        <form action="register_process.php" method="post">
            <label for="register-nombre">Nombre</label>
            <input type="text" id="register-nombre" name="nombre" required>
            <label for="register-usuario">Usuario</label>
            <input type="text" id="register-usuario" name="usuario" required>
            <label for="register-correo">Correo</label>
            <input type="email" id="register-correo" name="correo" required>
            <label for="register-password">Contraseña</label>
            <input type="password" id="register-password" name="password" required>
            <button type="submit">Registrarse</button>
        </form>
    </section>
    <?php include 'includes\footer.php'; ?>
</body>
</html>
