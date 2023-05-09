var formCurso = document.getElementById('crear-curso');

formCurso.addEventListener('submit', function(event) {
  event.preventDefault();
  let codigo = document.getElementById('codigo').value;
  let curso = document.getElementById('curso').value;
  let profesor = document.getElementById('select-profesores').value;

  crearCurso(codigo, curso, profesor);
})

function crearCurso(codigo, detalle, profesor) {
  fetch ('.././core/cursos/curso_crear.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({codigo: codigo, detalle: detalle, profesor: profesor})
  })
  .then(response => response.json())
  .then(data => {
    let alertas = document.getElementById('alertas');
    if (data.success) {
      alertas.innerHTML = '<div class="alert alert-success">El curso se creó satisfactoriamente</div>';
      formCurso.reset();
    } else {
      alertas.innerHTML = '<div class="alert alert-danger">Ocurrió un error al registrar el curso</div>';
    }
  })
  .catch(error => console.error(error));
}

const codigoInput = document.getElementById('codigo');
const errorMensaje = document.getElementById('codigo-error');

codigoInput.addEventListener('input', function() {
  const valor = this.value;
  const maxLength = 6;
  
  if (valor.length > maxLength) {
    // Si el valor del input es mayor al maxLength, se muestra un mensaje de error
    errorMensaje.classList.add('text-danger');
    errorMensaje.textContent = 'Solo se aceptan ' + maxLength + ' caracteres';
    
    // Se elimina el último caracter ingresado
    this.value = valor.slice(0, maxLength);
  } else {
    // Si el valor del input es válido, se oculta el mensaje de error
    errorMensaje.classList.remove('text-danger');
    errorMensaje.textContent = '';
  }
});