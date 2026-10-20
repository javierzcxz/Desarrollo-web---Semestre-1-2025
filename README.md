# Betrayal Palace

Casino online de carácter académico, desarrollado en equipo para el ramo Desarrollo Web de la Universidad Diego Portales. El sitio permite crear una cuenta, iniciar sesión, mantener una billetera con su historial de movimientos y jugar a la ruleta apostando saldo de la propia cuenta.

Integrantes: Ricardo Vargas, Javier Zavaleta y Daniel Carmona.

## Qué hace el proyecto

Un usuario nuevo se registra, recibe un bono de bienvenida y puede revisar su perfil y sus transacciones desde el menú. En la ruleta se elige una mesa según el monto mínimo y máximo de apuesta, y se pueden hacer apuestas a color, a altos y bajos, por docenas, por columnas o a un número en particular. Cada apuesta, abono, retiro o premio queda registrado en el historial de la billetera.

En la página de inicio también aparecen la tragamonedas y el blackjack, pero esos juegos quedaron como "próximamente" y no están implementados.

## Tecnologías

El sitio está hecho en PHP sin framework, con HTML, CSS y JavaScript en el lado del cliente. Los datos se guardan en MySQL y se acceden con mysqli. Las páginas se comunican con una API REST propia que vive en `api/v1`, y esa API está documentada con Swagger.

## Cómo correrlo en local

Se necesita PHP 8 o superior y MySQL (o MariaDB) funcionando en el equipo.

Primero se crea la base de datos y se importa el archivo SQL que viene en el repositorio. Luego se levanta el servidor de desarrollo que trae PHP, desde la carpeta del proyecto:

```
mysql -u root -e 'CREATE DATABASE `BD-betrayal`;'
mysql -u root BD-betrayal < coningen_udp252_bp.sql
php -S localhost:8000
```

Después se abre http://localhost:8000 en el navegador.

Los datos de conexión están en `api/v1/conexion.php` y vienen configurados para un MySQL local: servidor `localhost`, usuario `root`, sin contraseña y base `BD-betrayal`. Si tu MySQL usa otra contraseña u otro nombre de base, hay que cambiarlos ahí.

La base no trae usuarios cargados, así que lo primero es crear una cuenta desde la opción de registro. La documentación de la API queda disponible en http://localhost:8000/api/documentation/.

## Estructura del repositorio

Las páginas del sitio (`index.php`, `login.php`, `register.php`, `profile.php`, `wallet.php`, `ruleta.php` y `logout.php`) están en la raíz, junto con `navbar.php`, que se reutiliza en varias de ellas. Los estilos están en `css`, las imágenes en `img` y los scripts en `js`.

La carpeta `api/v1` tiene un directorio por cada recurso (usuarios, billetera, mesas, apuestas, etc.), cada uno con su modelo y su punto de entrada, y en `api/documentation` está la interfaz de Swagger. El archivo `coningen_udp252_bp.sql` contiene las tablas y los datos de catálogo que el sitio necesita para funcionar, como géneros, nacionalidades, mesas y opciones de apuesta.

La carpeta `pruebas` guarda un primer prototipo del registro de usuarios. No lo usa el proyecto final y no coincide con la base de datos actual; se dejó solo como referencia del proceso de desarrollo.

## Sobre el alcance del trabajo

La estructura base de la API y su documentación con Swagger fueron material entregado en el curso. El trabajo del equipo se centró en el sitio web: el diseño de las páginas, los estilos, el sistema de sesiones y la conexión de cada pantalla con la API.
