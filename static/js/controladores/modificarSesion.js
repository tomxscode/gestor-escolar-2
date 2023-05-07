document.addEventListener("DOMContentLoaded", function (event) {
  const formMiCuenta = document.getElementById('micuenta-form');
  const btnModificar = document.getElementById('btnModificar');
  const btnGuardar = document.getElementById('btnGuardar');
  const alertasContainer = document.getElementById('alertasContainer');

  btnGuardar.style.display = 'none';

  var direccionInput, telefonoInput;
  direccionInput = document.querySelector('input[name="direccion"]');
  telefonoInput = document.querySelector('input[name="telefono"]');

  btnModificar.addEventListener('click', function(event) {
    direccionInput.disabled = false;
    telefonoInput.disabled = false;

    // Mostrar botón de Guardar
    btnGuardar.style.display = 'block';
  })

  formMiCuenta.addEventListener('submit', function (event) {
    event.preventDefault();
  });

  direccionInput.addEventListener('input', function() {
    if (direccionInput.value.trim() === '') {
      direccionInput.classList.add('is-invalid');
    } else {
      direccionInput.classList.remove('is-invalid');
    }
  });
  
  telefonoInput.addEventListener('input', function() {
    if (telefonoInput.value.trim() === '') {
      telefonoInput.classList.add('is-invalid');
    } else {
      telefonoInput.classList.remove('is-invalid');
    }
  });

  btnGuardar.addEventListener('click', function(event) {
    let dirValue = direccionInput.value;
    let telValue = telefonoInput.value;
    if (dirValue.length > 0 && telValue.length > 0) {
      fetch('.././core/cuentas/actualizar_por_rut.php', {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({direccion: dirValue, telefono: telValue})
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            let alerta = '<div class="alert alert-success">Se actualizó la información con éxito</div>';
            alertasContainer.innerHTML = alerta;
          } else {
            let alerta = '<div class="alert alert-danger">No se pudo actualizar la información, reintente</div>';
            alertasContainer.innerHTML = alerta;
          }
        })
        .catch(error => console.error(error))
    } else {
      // si la longitud es 0 para ambos, remarcar en rojo los inputs
      if (dirValue.length === 0) {
        direccionInput.classList.add('is-invalid');
      }
      if (telValue.length === 0) {
        telefonoInput.classList.add('is-invalid');
      }
    }
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