<?php

session_set_cookie_params(0, '/'); 
session_name('BetrayalSession');  
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Betrayal Palace — Inicio</title>
  <meta name="description" content="Casino académico: ruleta, ofertas y los juegos más populares. Maquetación HTML de la primera entrega.">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="icon" type="image/png" href="img/LOGO.png" />
</head>
<body>

  <header class="encabezado" role="banner">
    <div class="logo">
      <a href="index.php" class="enlace" aria-label="Ir al inicio">
        <img src="img/LOGOV.png" alt="Betrayal Palace" class="imagen">
      </a>
    </div>

    <nav class="navegacion" role="navigation" aria-label="Menú principal">
      <ul class="lista">
        <li><a href="#inicio" aria-current="page">Inicio</a></li>
        <li><a href="#top-juegos">Juegos</a></li>
        <li><a href="#bonos">Ofertas</a></li>
        <?php if (isset($_SESSION['usuario'])): ?>
            <li><a href="profile.php">Perfil</a></li>
            <li><a href="wallet.php">Transacciones</a></li>
        <?php endif; ?>
      </ul>
    </nav>

    <div class="acciones">

      <?php if (!isset($_SESSION['usuario'])): ?>

        <a class="boton" href="login.php">Ingresar</a>
        <a class="boton" href="register.php">Registrarse</a>

      <?php else: ?>

        <span style="color: white; margin-right: 10px; font-weight: bold;">
            Hola, <?php echo htmlspecialchars($_SESSION['usuario']['username']); ?>
        </span>
        
        <a href="logout.php" class="boton" style="background:red;">Cerrar Sesión</a>

      <?php endif; ?>

    </div>
  </header>


  <main id="contenido">
    <section id="inicio" aria-label="Destacados del sitio">
      <header>
        <h1>Explora el casino</h1>
        <p>Elige tu próximo paso: ruleta, sala de juegos o nuestras ofertas.</p>
      </header>

      <div class="grilla" role="list">
        <article class="tarjeta" role="listitem">
          <header class="cabecera">
            <h1>Ruleta</h1>
          </header>
          <figure class="figura">
            <img src="img/ruleta.png" alt="Mesa de ruleta" />
          </figure>
          <p class="texto"><b>Pon a prueba tu suerte.</b></p>
          <a class="boton" href="ruleta.php" role="boton">Ir a la ruleta</a>
        </article>

        <article class="tarjeta" role="listitem">
          <header class="cabecera">
            <h1>Otros Juegos</h1>
          </header>
          <figure class="figura">
            <img src="img/juegos.png" alt="Tragamonedas y mesas de cartas" />
          </figure>
          <p class="texto"><b>Variedad de juegos para divertirse.</b></p>
          <a class="boton" href="#top-juegos" role="boton">Ir a</a>
        </article>

        <article class="tarjeta" role="listitem">
          <header class="cabecera">
            <h1>Promociones</h1>
          </header>
          <figure class="figura">
            <img src="img/bonos.png" alt="Imagen promocional de bonos" />
          </figure>
          <p class="texto"><b>Bonos de bienvenida, giros gratis y promociones por tiempo limitado.</b></p>
          <a class="boton" href="#bonos" role="boton">Ver promociones</a>
        </article>
      </div>
    </section>

    <section id="top-juegos" aria-labelledby="titulo-top-juegos">
      <header>
        <h2 id="titulo-top-juegos">Top Juegos</h2>
        <p>Los mas jugados en la semana</p>
      </header>

      <div class="juegos">
        <article class="juego">
          <figure>
            <img src="img/ruleta2.jpg" alt="Portada Ruleta clásica" />
          </figure>
          <h3 class="titulo">Ruleta Clasica</h3>
          <p class="resumen">Gana todo en la ruleta.</p>
          <a href="ruleta.php" class="boton">Jugar</a>
        </article>

        <article class="juego">
          <figure>
            <img src="img/tragaperras.webp" alt="Portada tragaperras" />
          </figure>
          <h3 class="titulo">Tragamonedas</h3>
          <p class="resumen">Rondas rápidas y giros gratis.</p>
          <a href="" class="boton">PROXIMAMENTE</a>
        </article>

        <article class="juego">
          <figure>
            <img src="img/blackjack.jpg" alt="Portada Blackjack" />
          </figure>
          <h3 class="titulo">Blackjack 21</h3>
          <p class="resumen">Llega a 21, pero ten cuidado con pasarte.</p>
          <a href="" class="boton">PROXIMAMENTE</a>
        </article>
      </div>
    </section>

    <section id="bonos" aria-labelledby="titulo-bonos">
      <header>
        <h2 id="titulo-bonos">Ofertas destacadas</h2>
        <p>Aprovecha estos beneficios de bienvenida.</p>
      </header>

      <div class="promos">
        <article class="promo promo-1">
          <h2 class="titulo">Bono hasta $50.000</h2>
          <p class="detalle"><h3>Duplica tu primer depósito. <strong>Promoción limitada.</strong></h3></p>
          <a href="terminos.html#bono1" class="boton">Ver términos</a>
        </article>

        <article class="promo promo-2">
          <h2 class="titulo">10 giros gratis</h2>
          <p class="detalle"><h3>Para usar en tragamonedas seleccionadas.</h3></p>
          <a href="terminos.html#bono2" class="boton">Ver términos</a>
        </article>
      </div>
    </section>

    <section id="desarrolladores" aria-labelledby="titulo-devs">
      <header>
        <h2 id="titulo-devs">Equipo del proyecto</h2>
        <p>Estudiantes de Ingeniería Informática.</p>
      </header>

      <ul class="equipo">
        <li class="miembro"><h3>Ricardo Vargas</h3><p>Universidad Diego Portales — Desarrollo Web</p></li>
        <li class="miembro"><h3>Javier Zavaleta</h3><p>Universidad Diego Portales — Desarrollo Web</p></li>
        <li class="miembro"><h3>Daniel Carmona</h3><p>Universidad Diego Portales — Desarrollo Web</p></li>
      </ul>
    </section>
  </main>

  <footer class="pie" role="contentinfo" aria-label="Información del sitio">
    <section class="acerca">
      <h2 class="sr-only">Sobre el sitio</h2>
      <p><strong>Betrayal Palace</strong> — Proyecto académico de desarrollo web.</p>
      <p>Casino online para jugar y ganar todo sin olvidarse de pasarla bien.</p>
    </section>
    <p class="derechos">&copy; 2025 Betrayal Palace. Proyecto académico.</p>
  </footer>

</body>
</html>