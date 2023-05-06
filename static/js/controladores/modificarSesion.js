const formMiCuenta = document.getElementById('micuenta-form');

formMiCuenta.addEventListener('submit', function (event) {
  event.preventDefault();
  obtenerInformacion()
    .then(json => establecerValoresFormulario(json))
    .catch(error => console.error(error));
});

function obtenerInformacion() {
  return fetch('.././core/cuentas/obtener_info.php', {
    method: 'POST',
    body: JSON.stringify({}),
    headers: { 'Content-Type': 'application/json' }
  })
    .then(response => response.json())
    .catch(error => console.error(error));
}

function establecerValoresFormulario(json) {
  for (let key in json) {
    const input = formMiCuenta.querySelector(`[name="${key}"]`);
    if (input) {
      input.value = json[key];
    }
  }
}