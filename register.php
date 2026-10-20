<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="login-wrapper" style="margin-top: 120px;">
        <div class="login-card">
            <a class="close_X" href="index.php">&times;</a>
            <h2 class="titulo-login">Crear Cuenta</h2>
            
            <form id="registerForm">
                <div class="Divisor">
                    <img class="Imagenes" src="/img/Correo.png">
                    <input class="form" type="email" id="regCorreo" placeholder="Correo" required>
                </div>
                <div class="Divisor">
                    <img class="Imagenes" src="/img/Nombre.png">
                    <input class="form" type="text" id="regNombre" placeholder="Nombre" required>
                </div>
                <div class="Divisor">
                    <img class="Imagenes" src="/img/Usuario.png">
                    <input class="form" type="text" id="regAlias" placeholder="Alias" required>
                </div>
                <div class="Divisor">
                    <img class="Imagenes" src="/img/Contrasena.png">
                    <input class="form" type="password" id="regPass" placeholder="Contraseña" required>
                </div>
                <div class="Divisor">
                    <input class="form" type="date" id="regFecha" required>
                </div>
                <button class="Boton" type="button" onclick="registrarNuevoJugador(event)">Registrarse</button>
            </form>

            <a class="Registrarse" href="login.php">Ya tengo cuenta</a>
        </div>
    </div>

    <!-- SCRIPT CORRECTO -->
    <script src="/js/funciones_casino.js"></script>
</body>
</html>
