<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logueado = isset($_SESSION['usuario']);
$user = $logueado ? $_SESSION['usuario'] : null;
?>

<div class="encabezado">
    <div class="logo">
        <a href="index.php"><img src="img/LOGOV.png" alt="Logo" class="imagen" style="height:80px;"></a>
    </div>
    
    <nav class="navegacion">
        <ul class="lista" style="display:flex; gap:20px; list-style:none;">
            <li><a href="index.php" style="color:white; text-decoration:none;">Inicio</a></li>
            
            <?php if ($logueado): ?>
                <li><a href="ruleta.php" style="color:white; text-decoration:none;">Jugar</a></li>
                <li><a href="wallet.php" style="color:white; text-decoration:none;">Billetera</a></li>
                <li><a href="profile.php" style="color:white; text-decoration:none;">Mi Perfil</a></li>
            <?php else: ?>
                <li><a href="index.php#juegos" style="color:white; text-decoration:none;">Juegos</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="acciones">
        <?php if ($logueado): ?>
            <span style="color:white; margin-right:15px; font-weight:bold;">
                Hola, <?php echo htmlspecialchars($user['username']); ?>
            </span>
            <a href="logout.php" class="boton" style="background-color: #d9534f;">Salir</a>
        <?php else: ?>
            <a href="login.php" class="boton" style="margin-right:10px;">Ingresar</a>
            <a href="register.php" class="boton">Registrarse</a>
        <?php endif; ?>
    </div>
</div>