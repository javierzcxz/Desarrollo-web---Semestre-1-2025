function cerrarSesionUsuario() {

    fetch('logout.php', { method: 'GET' })
        .then(response => {
            if (response.ok) {
                window.location.href = 'index.php'; 
            }
        })
        .catch(error => {
            console.error('Error al cerrar sesión:', error);
            alert("Hubo un problema al cerrar sesión.");
        });
}
