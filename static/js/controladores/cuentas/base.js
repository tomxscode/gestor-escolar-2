// Función para obtener la información actual
function obtenerInfoActual() {
  return new Promise((resolve, reject) => {
    fetch('.././core/cuentas/get/info_simple.php', {
      method: 'GET'
    })
      .then(response => response.json())
      .then(data => {
        resolve(data);
      })
      .catch(error => reject(error));
  });
}

function modificarDatos(email, direccion, telefono) {
  return new Promise((resolve, reject) => {
    fetch('.././core/cuentas/set/editar_info_simple.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ email, direccion, telefono })
    })
      .then(response => response.json())
      .then(data => {
        resolve(data);
      })
      .catch(error => reject(error))
  })

}

// Función para pintar la información del formulario
function pintarInformacion() {
  // Obtenemos la información
  obtenerInfoActual()
    .then(informacion => {
      // Obtiene todo el formulario por medio de su ID
      var formulario = document.getElementById('micuenta-form');
      // Obtiene todos los elementos del formulario (tipo input) por medio del atributo name
      var inputs = formulario.querySelectorAll('input[name]');
      // Itera todos los inputs
      inputs.forEach(function (input) {
        var nombre = input.name;

        if (nombre === 'sexo') {
          // Verificar el valor del campo de sexo y asignar el texto correspondiente
          input.value = informacion[nombre] === '0' ? 'Femenino' : 'Masculino';
        } else if (nombre === 'rol') {
          // Verificar el valor del campo de rol y asignar el texto correspondiente
          var valorRol = informacion[nombre];

          switch (valorRol) {
            case 6:
              input.value = 'Administrador';
              break;
            case 5:
              input.value = 'y';
              break;
            // Agregar más casos según sea necesario para otros valores de rol
            default:
              input.value = '';
              break;
          }
        } else {
          // Para los demás campos, agregar información al valor del input
          input.value = informacion[nombre];
        }
      });
    })
    .catch(error => console.error(error));
}

// Función para validar contraseñas
function validarContrasenas(nueva, validacion) {
  if (nueva.length <= 0 || validacion.length <= 0) {
    informacionPass.innerHTML = "";
    return false;
  } else {
    if (nueva !== validacion) {
      // Agregar información
      informacionPass.innerHTML = "<p style='color: red;'>Las contraseñas no coinciden</p>";
      return false;
    } else {
      informacionPass.innerHTML = "";
      return true;
    }
  }
}

// Obtener elementos del DOM
const formCambioPassword = document.getElementById('form-cambiar-password');
const inputActualPass = document.getElementById('contraActual');
const inputNuevaPass = document.getElementById('nuevaContra');
const inputValidacionPass = document.getElementById('validacionPass');
const alertasModal = document.getElementById('alertas-modal');
const informacionPass = document.getElementById('informacionContrasena');

// Evento para validar la confirmación de contraseña en tiempo real
inputValidacionPass.addEventListener('input', function (event) {
  let nuevaPass = inputNuevaPass.value;
  let validacionPass = inputValidacionPass.value;

  validarContrasenas(nuevaPass, validacionPass);
});

// Evento para enviar el formulario de cambio de contraseña
formCambioPassword.addEventListener('submit', function (event) {
  event.preventDefault();

  let actualPass = inputActualPass.value;
  let nuevaPass = inputNuevaPass.value;
  let validacionPass = inputValidacionPass.value;

  // Validación de contraseñas para continuar
  if (validarContrasenas(nuevaPass, validacionPass)) {
    setAlertaModal('info', 'Se está procesando su cambio de contraseña, espere...');

    fetch('.././core/cuentas/modificar_contrasena.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ contraActual: actualPass, contraNueva: nuevaPass })
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          setAlertaModal('success', 'La contraseña fue cambiada exitosamente');
        } else {
          setAlertaModal('danger', data.error);
        }
      })
      .catch(error => console.error(error));
  } else {
    setAlertaModal('warning', 'Las contraseñas deben coincidir');
  }
});

// Llamada a la función para pintar la información del formulario
pintarInformacion();
