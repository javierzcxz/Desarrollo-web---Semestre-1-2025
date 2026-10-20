async function registrarNuevoJugador(event) {
    event.preventDefault(); 

    let nombre = document.getElementById("regNombre").value;
    let alias = document.getElementById("regAlias").value;
    let correo = document.getElementById("regCorreo").value;
    let clave = document.getElementById("regPass").value;


    if (!nombre || !alias || !correo || !clave) {
        alert("Por favor completa todos los campos");
        return;
    }


    console.log('Datos del registro:', { nombre, alias, correo, clave });


    let datos = {
        accion: 'register',  
        correo: correo,
        nombre: nombre,
        alias: alias,
        clave: clave
    };

    try {

        let respuesta = await fetch('api/v1/usuario/index.php', {
            method: 'POST',
            body: JSON.stringify(datos),
            headers: { 'Content-Type': 'application/json' }
        });


        let resultado = await respuesta.json();


        console.log('Respuesta de la API:', resultado);


        if (resultado.mensaje) {
            alert("Cuenta creada correctamente.");
            window.location.href = "login.php"; 
        } else {

            alert("Error: " + resultado.error);
        }
    } catch (e) {

        console.error(e);
        alert("Error de conexión");
    }
}
