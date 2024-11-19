<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="left-header">
        <button onclick="location.href='index.php'">Logo</button>
        <button onclick="location.href='index.php'">Esmeralda</button>
    </div>
    <div class="right-header">
        <?php if (isset($_SESSION['usuario'])): ?>
            <button id="newPostButton" class="mode-button" onclick="location.href='new_post.php'">Nueva publicación</button>
            <button id="userButton" class="mode-button" onclick="location.href='profile.php'"><?php echo $_SESSION['usuario']; ?></button>
        <?php else: ?>
            <button id="ltButton" class="mode-button" onclick="location.href='login.php?mode=login'">Login</button>
            <button id="rtButton" class="mode-button" onclick="location.href='login.php?mode=register'">Register</button>
        <?php endif; ?>
    </div>
</header>
