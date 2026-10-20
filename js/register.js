async function registrarNuevoJugador() {

    let username = document.getElementById("regUsername").value;
    let password = document.getElementById("regPass").value;
    let fecha_nacimiento = document.getElementById("regFecha").value;

    if (!username || !password || !fecha_nacimiento) {
        alert("Completa todos los campos");
        return;
    }

    let data = {
        accion: "register",
        username: username,
        password: password,
        fecha_nacimiento: fecha_nacimiento
    };

    try {
        let respuesta = await fetch("api/v1/usuario/index.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });

        let json = await respuesta.json();
        
        if (json.error) {
            alert("Error: " + json.error);
        } else {
            alert("Registro exitoso. Ahora inicia sesión.");
            window.location.href = "login.php";
        }

    } catch (error) {
        console.error("Error:", error);
        alert("Error de conexión con el servidor.");
    }
}
