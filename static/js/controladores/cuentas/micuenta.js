var rutUsuario = 0;
document.addEventListener('DOMContentLoaded', function (event) {
  // Llamada a la función para obtener y almacenar el rut
  obtenerRut()
    .then(() => {
      // La variable rutUsuario contiene el rut del usuario aquí
      console.log(rutUsuario);
      // Puedes utilizar rutUsuario en otras partes de tu proyecto
    })
    .catch(error => {
      // Maneja los errores aquí
      console.error(error);
    });
})

const
  formCambioPassword = document.getElementById('form-cambiar-password'),
  // inputs
  inputActualPass = document.getElementById('contraActual'),
  inputNuevaPass = document.getElementById('nuevaContra'),
  inputValidacionPass = document.getElementById('validacionPass'),
  // contenedores
  alertasModal = document.getElementById('alertas-modal'),
  informacionPass = document.getElementById('informacionContrasena')
  ;

inputValidacionPass.addEventListener('input', function (event) {
  let
    nuevaPass = inputNuevaPass.value,
    validacionPass = inputValidacionPass.value
    ;

  validarContrasenas(nuevaPass, validacionPass);
})

formCambioPassword.addEventListener('submit', function (event) {
  event.preventDefault();

  let
    actualPass = inputActualPass.value,
    nuevaPass = inputNuevaPass.value,
    validacionPass = inputValidacionPass.value
    ;
  // Validación de contraseñas para continuar, seguridad 1
  if (validarContrasenas(nuevaPass, validacionPass)) {
    console.log("exito")
    setAlertaModal('info', 'Se está procesando su cambio de contraseña, espere...')
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
          setAlertaModal('success', 'La contraseña fue cambiada exitosamente')
        } else {
          setAlertaModal('danger', data.error)
        }
      })
      .catch(error => console.error(error))
  } else {
    setAlertaModal('warning', 'Las contraseñas deben coincidir');
  }
})

function validarContrasenas(nueva, validacion) {
  if (nueva.length <= 0 || validacion.length <= 0) {
    informacionPass.innerHTML = "";
    return false;
  } else {
    if (nueva != validacion) {
      // Agregar información
      informacionPass.innerHTML = "<p style='color: red;'>Las contraseñas no coinciden</p>";
      return false;
    } else {
      informacionPass.innerHTML = "";
      return true;
    }
  }

}

function obtenerRut() {
  return fetch('.././core/cuentas/obtener_info.php', {
    method: 'POST',
    body: JSON.stringify({}),
    headers: { 'Content-Type': 'application/json' }
  })
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error('Error en la respuesta de la solicitud');
      }
    })
    .then(data => {
      return data.rut; // Asignar el valor del rut a la variable
    })
    .catch(error => {
      console.error(error);
      throw error; // Rechaza la promesa con el error capturado
    });
}