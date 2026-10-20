async function entrarAlSistema() { 
    let correo = document.getElementById("inputCorreo").value;
    let clave = document.getElementById("inputPass").value;

    if (!correo || !clave) { 
        alert("Por favor ingresa tus credenciales.");
        return;
    } 

    let datos = { accion: 'login', correo: correo, clave: clave }; 

    try { 
        let respuesta = await fetch('api/v1/usuario/index.php', { 
            method: 'POST', 
            body: JSON.stringify(datos), 
            headers: { 'Content-Type': 'application/json' } 
        });


        if (!respuesta.ok) {
            throw new Error("Error en el servidor: " + respuesta.status);
        }

        let resultado = await respuesta.json();

        if (resultado.mensaje) { 
            alert("Bienvenido " + resultado.usuario.username); 
            window.location.href = "index.php"; 
        } else { 
            alert("Error: " + (resultado.error || "Credenciales inválidas."));
        } 
    } catch (e) { 
        console.error(e); 
        alert("Error de conexión o respuesta inválida del servidor"); 
    } 
}