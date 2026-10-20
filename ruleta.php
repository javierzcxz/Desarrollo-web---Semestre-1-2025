<?php

session_set_cookie_params(0, '/');
session_name('BetrayalSession');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}


$datosUsuario = &$_SESSION['usuario'];
$saldo = $datosUsuario['saldo'];

$mensaje = "";
$colorGanador = null;
$NUMERO_GANADOR = null;

$MIN = 500;
$MAX = 100000;


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $monto = intval($_POST["monto"] ?? 0);
    $apuestaColor = $_POST["color"] ?? "";

    $numeroPost = $_POST["numero"] ?? "";
    $numeroApostado = ($numeroPost !== "") ? intval($numeroPost) : null;

    if ($monto < $MIN) {
        $mensaje = "La apuesta mínima es $$MIN.";
    }
    elseif ($monto > $MAX) {
        $mensaje = "La apuesta máxima es $$MAX.";
    }
    elseif ($monto > $saldo) {
        $mensaje = "No tienes saldo suficiente.";
    }
    else {

        $NUMERO_GANADOR = rand(0, 36);

        $rojos = [1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36];
        if ($NUMERO_GANADOR === 0) $colorGanador = "verde";
        else $colorGanador = in_array($NUMERO_GANADOR, $rojos) ? "rojo" : "negro";

        $gananciaTotal = 0;

        if ($numeroApostado !== null && $numeroApostado === $NUMERO_GANADOR) {
            $gananciaTotal += $monto * 35; 
        }


        if ($apuestaColor !== "" && $apuestaColor === $colorGanador) {
            $gananciaTotal += $monto; 
        }


        if ($gananciaTotal > 0) {

            
            $datosUsuario['saldo'] += $gananciaTotal;
            $mensaje = "¡Ganaste $$gananciaTotal! Salió el $NUMERO_GANADOR ($colorGanador).";
        } else {

            $datosUsuario['saldo'] -= $monto;
            $mensaje = "Perdiste $$monto. Salió el $NUMERO_GANADOR ($colorGanador).";
        }


        $saldo = $datosUsuario['saldo'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ruleta — Betrayal Palace</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/ruleta.css">
    <link rel="icon" type="image/png" href="img/LOGO.png">
    
    <script>

        let NUMERO_GANADOR = <?= $NUMERO_GANADOR === null ? "null" : intval($NUMERO_GANADOR) ?>;
    </script>
    <script src="js/ruleta.js" defer></script>
</head>

<body>

<header class="encabezado">
    <div class="logo">
        <a href="index.php"><img src="img/LOGOV.png" class="imagen" alt="Logo"></a>
    </div>

    <nav class="navegacion">
        <ul class="lista">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="wallet.php">Transacciones</a></li>
            <li><a href="profile.php">Perfil</a></li>
        </ul>
    </nav>

    <div class="acciones">
        <span style="color:white; margin-right:15px;">Saldo: $<?= $saldo ?></span>
        <a href="logout.php" class="boton" style="background-color: #d9534f;">Cerrar Sesión</a>
    </div>
</header>

<div class="ruleta-box" style="margin-top: 50px;">

    <h2>Ruleta Europea</h2>
    <p>Apuesta a número y/o color</p>
    <p><b>Saldo Disponible: $<?= $saldo ?></b></p>
    <p style="font-size: 0.9rem; color: #ccc;">Apuesta mínima: $<?= $MIN ?> — máxima: $<?= $MAX ?></p>

    <?php if ($mensaje): ?>
      <div style="background: #333; color: #fff; padding: 10px; margin: 10px auto; border-radius: 5px; border: 1px solid gold;">
          <?= $mensaje ?>
      </div>
    <?php endif; ?>

    <div class="flecha"></div>

    <div id="ruletaWrapper">
        <canvas id="ruletaCanvas" width="400" height="400"></canvas>
    </div>

    <div class="tablero">
        <?php
            echo "<div class='celda verde' data-num='0'>0</div>";
            for ($i=1; $i<=36; $i++){
                $clase = in_array($i, [1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36]) ? "rojo" : "negro";
                echo "<div class='celda $clase' data-num='$i'>$i</div>";
            }
        ?>
        <div id="ficha"></div>
    </div>

    <form method="POST" id="formApuesta" style="margin-top: 20px;">
        <input type="hidden" name="numero" id="numeroInput">

        <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
            <input type="number" name="monto" placeholder="Monto a apostar" required min="<?= $MIN ?>" max="<?= $saldo ?>" class="form-control" style="padding: 10px; border-radius: 5px;">
            
            <select name="color" style="padding: 10px; border-radius: 5px;">
                <option value="">Color (Opcional)</option>
                <option value="rojo">Rojo</option>
                <option value="negro">Negro</option>
            </select>
            
            <button class="boton">GIRAR</button>
        </div>
        <p style="margin-top: 10px; font-size: 0.8rem; color: gray;">*Haz clic en un número del tablero para seleccionarlo.</p>
    </form>

</div>

<footer class="pie">
  <p>&copy; 2025 Betrayal Palace — Ruleta</p>
</footer>

</body>
</html>