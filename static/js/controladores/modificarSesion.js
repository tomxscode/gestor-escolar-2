document.addEventListener("DOMContentLoaded", function (event) {
  const formMiCuenta = document.getElementById('micuenta-form');
  const btnModificar = document.getElementById('btnModificar');
  const btnGuardar = document.getElementById('btnGuardar');

  btnGuardar.style.display = 'none';

  btnModificar.addEventListener('click', function(event) {
    let inputs = formMiCuenta.querySelectorAll('input');
    inputs.forEach(input => {
      if (input.type == 'email') {
        input.disabled = true;
      } else {
        input.disabled = false;
      }
    })

    // Mostrar botón de Guardar
    btnGuardar.style.display = 'block';
  })

  formMiCuenta.addEventListener('submit', function (event) {
    event.preventDefault();
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

  // Obtiene información y establece valores del formulario
  obtenerInformacion()
    .then(json => establecerValoresFormulario(json))
    .catch(error => console.error(error));
});