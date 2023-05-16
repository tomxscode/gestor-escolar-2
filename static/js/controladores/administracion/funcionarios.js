const formulario = document.getElementById('form-registro');
const alertasContainer = document.getElementById('alertas');

formulario.addEventListener('submit', function (event) {
  event.preventDefault();
  // dom
  const rut = formulario.querySelector('[name="rut"]').value;
  const nombres = formulario.querySelector('[name="nombres"]').value;
  const apellidos = formulario.querySelector('[name="apellidos"]').value;
  const email = formulario.querySelector('[name="email"]').value;
  const direccion = formulario.querySelector('[name="direccion"]').value;
  const telefono = formulario.querySelector('[name="telefono"]').value;
  const rol = formulario.querySelector('[name="rol"]').value;
  const sexo = formulario.querySelector('[name="sexo"]').value;

  // validaciones

  // enviar petición al servidor
  crearFuncionario(rut, nombres, apellidos, email, direccion, telefono, rol, sexo);
})

function crearFuncionario(rut, nombres, apellidos, email, direccion, telefono, rol, sexo) {
  fetch('.././core/cuentas/registro.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ rut, nombres, apellidos, email, direccion, telefono, rol, sexo })
  })
    .then(response => response.json())
    .then(data => {
      console.log(data);
      if (data.success) {
        enviarAlerta("success", "El funcionario fue creado exitosamente");
      } else {
        enviarAlerta("danger", "Ocurrió un error al crear el funcionario, re-intente")
      }
    })
}

function enviarAlerta(tipo, alerta) {
  alertasContainer.innerHTML = `<div class="alert alert-${tipo} text-center">${alerta}</div>`;
  console.log(alertasContainer);
}
