function cerrarSesion() {
    // Enviar petición para intentar cerrar sesión
    fetch ('../core/cuentas/cerrar_sesion.php', {
        method: 'GET'
    })
    .then (response => response.json())
    .then(data => {
        console.log(data);
        let alertaContainer = document.getElementById('alertas');
        if (data.success) {
            alertaContainer.innerHTML = "<div class='alert alert-success'>La sesión fue cerrada éxitosamente <br>Continuarás en 5 segundos, por favor, espera</div>";
            setTimeout(function() {
                location.reload();
            }, 5000)
        } else {
            alertaContainer.innerHTML = "<p>Se intentó cerrar sesión, pero no tienes ninguna sesión iniciada o no es válida</p>";
        }
    })
    .catch(error => console.error(error))
}