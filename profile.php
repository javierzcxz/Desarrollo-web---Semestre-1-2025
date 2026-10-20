<?php

session_set_cookie_params(0, '/');
session_name('BetrayalSession'); 
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$datosUsuario = $_SESSION['usuario'];

$correo = $datosUsuario['username'] ?? "Desconocido";
$jugadorId = $datosUsuario['id'] ?? "0";
$saldo = $datosUsuario['saldo'] ?? "0";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Perfil — Betrayal Palace</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="icon" type="image/png" href="img/LOGO.png">
</head>
<body>

<header class="encabezado">
    <div class="logo">
        <a href="index.php"><img src="img/LOGOV.png" alt="Logo" class="imagen"></a>
    </div>

    <nav class="navegacion">
      <ul class="lista">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="wallet.php">Transacciones</a></li>
        <li><a href="ruleta.php">Ruleta</a></li>
      </ul>
    </nav>

    <div class="acciones">
        <a href="logout.php" class="boton" style="background-color: #d9534f;">Cerrar Sesión</a>
    </div>
</header>

<main style="padding: 40px; text-align: center; color: white;">
    <h1 style="margin-bottom: 30px;">Mi Perfil</h1>

    <section class="tarjeta" style="background-color: #111; padding: 30px; border-radius: 10px; display: inline-block; text-align: left; min-width: 300px; border: 1px solid #333;">
        <p style="margin: 10px 0; font-size: 1.2rem;">
            <strong>Correo:</strong> <span style="color: #ccc;"><?php echo htmlspecialchars($correo); ?></span>
        </p>
        <p style="margin: 10px 0; font-size: 1.2rem;">
            <strong>ID Jugador:</strong> <span style="color: #ccc;"><?php echo htmlspecialchars($jugadorId); ?></span>
        </p>
        <p style="margin: 10px 0; font-size: 1.2rem;">
            <strong>Saldo Actual:</strong> <span style="color: #4CAF50;">$<?php echo number_format($saldo, 0, ',', '.'); ?></span>
        </p>
    </section>

</main>

</body>
</html>