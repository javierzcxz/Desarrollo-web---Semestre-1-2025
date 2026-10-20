<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="login-wrapper" style="margin-top: 120px;">
        <div class="login-card">
            <a class="close_X" href="index.php">&times;</a>
            <h2 class="titulo-login">Iniciar sesión</h2>
            
            <form id="loginForm">
                <div class="Divisor">
                    <img class="Imagenes" src="img/Correo.png">
                    <input class="form" type="email" id="inputCorreo" placeholder="Correo" required>
                </div>
                <div class="Divisor">
                    <img class="Imagenes" src="/img/Contrasena.png">
                    <input class="form" type="password" id="inputPass" placeholder="Contraseña" required>
                </div>
                <button class="Boton" type="button" onclick="entrarAlSistema()">Acceder</button>
            </form>

            <p class="No_tienes">¿No tienes cuenta?</p>
            <a class="Registrarse" href="register.php">Registrarse</a>
        </div>
    </div>
    <script src="js/funciones_casino.js"></script>
    <script src="js/login.js"></script>
</body>
</html>
