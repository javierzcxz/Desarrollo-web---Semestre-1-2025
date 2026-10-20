<?php
session_set_cookie_params(0, '/');
session_name('BetrayalSession');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

$usuario = $_SESSION['usuario'];
$saldo = $usuario['saldo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Betrayal Palace — Billetera</title>
  <link rel="icon" type="image/png" href="img/LOGO.png">
  <link rel="stylesheet" href="css/styles.css">
  <style>
      .wallet-container {
          max-width: 800px;
          margin: 0 auto;
          color: white;
          padding: 20px;
      }
      .saldo-card {
          background: linear-gradient(135deg, #1e1e1e 0%, #2a2a2a 100%);
          border: 1px solid #444;
          border-radius: 15px;
          padding: 30px;
          text-align: center;
          margin-bottom: 30px;
          box-shadow: 0 4px 15px rgba(0,0,0,0.5);
      }
      .saldo-numero {
          font-size: 3rem;
          color: #4CAF50;
          font-weight: bold;
          margin: 10px 0;
      }
      .form-carga {
          background-color: #111;
          padding: 20px;
          border-radius: 10px;
          border: 1px solid #333;
          margin-bottom: 30px;
      }
      .input-monto {
          padding: 15px;
          font-size: 1.2rem;
          border-radius: 5px;
          border: 1px solid #555;
          background-color: #222;
          color: white;
          width: 200px;
          text-align: center;
      }
      .btn-pagar {
          padding: 15px 30px;
          font-size: 1.2rem;
          background-color: #d32f2f;
          color: white;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          transition: 0.3s;
          margin-left: 10px;
      }
      .btn-pagar:hover {
          background-color: #b71c1c;
      }
      .tabla-transacciones {
          width: 100%;
          border-collapse: collapse;
          margin-top: 20px;
          background-color: #1a1a1a;
      }
      .tabla-transacciones th, .tabla-transacciones td {
          padding: 15px;
          border-bottom: 1px solid #333;
          text-align: center;
      }
      .tabla-transacciones th { background-color: #333; }
  </style>
</head>
<body>

<header class="encabezado">
    <div class="logo">
      <a href="index.php"><img src="img/LOGOV.png" class="imagen" alt="Logo"></a>
    </div>

    <nav class="navegacion">
      <ul class="lista">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="profile.php">Mi Perfil</a></li>
        <li><a href="ruleta.php">Ruleta</a></li>
      </ul>
    </nav>

    <div class="acciones">
      <a href="logout.php" class="boton" style="background-color: #d9534f;">Cerrar Sesión</a>
    </div>
</header>

<main class="contenido wallet-container">
  <h1>Billetera Virtual</h1>

  <section class="saldo-card">
      <p style="font-size: 1.2rem; color: #ccc;">Saldo Disponible</p>
      <div class="saldo-numero" id="saldoDisplay">$<?php echo number_format($saldo, 0, ',', '.'); ?></div>
  </section>

  <section class="form-carga">
      <h2>Recargar Saldo</h2>
      <p style="color: gray; margin-bottom: 15px;">Selecciona el monto que deseas ingresar a tu cuenta.</p>
      
      <div style="display: flex; justify-content: center; align-items: center; gap: 10px; flex-wrap: wrap;">
          <span style="font-size: 1.5rem;">$</span>
          <input type="number" id="inputMonto" class="input-monto" placeholder="0" min="1000" step="1000">
          <button class="btn-pagar" onclick="cargarSaldo()">Pagar</button>
      </div>
      <p style="margin-top: 10px; font-size: 0.9rem; color: #666;">Método de pago simulado: WebPay / Tarjeta</p>
  </section>

  <h2>Historial Reciente</h2>
  <table class="tabla-transacciones">
      <thead>
          <tr>
              <th>Fecha</th>
              <th>Detalle</th>
              <th>Monto</th>
              <th>Estado</th>
          </tr>
      </thead>
      <tbody>
          <tr>
              <td>Hoy</td>
              <td>Consulta de Saldo</td>
              <td style="color: #aaa;">$0</td>
              <td>Exitoso</td>
          </tr>
      </tbody>
  </table>

</main>

<script>
async function cargarSaldo() {
    let input = document.getElementById('inputMonto');
    let monto = parseInt(input.value);

    if (!monto || monto <= 0) {
        alert("Por favor ingresa un monto válido mayor a 0.");
        return;
    }

    if (!confirm("¿Estás seguro de recargar $" + monto + "?")) {
        return;
    }

    let datos = {
        accion: 'depositar',
        monto: monto
    };

    try {
        let respuesta = await fetch('api/v1/usuario/index.php', {
            method: 'POST',
            body: JSON.stringify(datos),
            headers: { 'Content-Type': 'application/json' }
        });

        let resultado = await respuesta.json();

        if (resultado.nuevo_saldo !== undefined) {
            alert("¡Carga Exitosa! Tu nuevo saldo es: $" + resultado.nuevo_saldo);
            document.getElementById('saldoDisplay').innerText = "$" + new Intl.NumberFormat('es-CL').format(resultado.nuevo_saldo);
            input.value = ""; 
        } else {
            alert("Error: " + (resultado.error || "No se pudo realizar la carga."));
        }

    } catch (e) {
        console.error(e);
        alert("Error de conexión con el servidor.");
    }
}
</script>

</body>
</html>