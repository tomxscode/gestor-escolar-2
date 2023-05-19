function obtenerInfoActual() {
    return new Promise((resolve, reject) => {
        fetch ('.././core/cuentas/get/info_simple.php', {
            method: 'GET'
        })
        .then(response => response.json())
        .then (data => {
            resolve(data);
        })
        .catch(error => reject(error))
    })
}