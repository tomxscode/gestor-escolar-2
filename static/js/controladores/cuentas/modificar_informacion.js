const formModificarDatos = document.getElementById('modificarDatos');
let datos = formModificarDatos.getElementsByTagName('input');

formModificarDatos.addEventListener('submit', function (event) {
  event.preventDefault();
  let
    email = datos['email'].value,
    telefono = datos['telefono'].value,
    direccion = datos['direccion'].value
    ;
  // Llamando a la función para modificar la información
  modificarDatos(email, direccion, telefono)
    .then(data => {
      console.log(data);
      if (data.success) {
        setAlertaModal('success', 'La información fue modificada con éxito');
        agregarAlertaModal('info', 'La ventana será recargada en 3 segundos...');
      }
    })
    .catch(error => console.error(error))
})