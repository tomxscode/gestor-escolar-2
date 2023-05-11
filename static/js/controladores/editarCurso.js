let btnEditar = document.getElementById('btnEditar');
let btnCrear = document.getElementById('btnCrear');
let codigoCursoInput = document.getElementById("codigo");
let cursoInput = document.getElementById("curso");
let selectInput = document.getElementById("select-profesores");

var codigo, detalle, profesor;

function enviarAlFormulario(codigo_curso) {
  fetch('.././core/cursos/curso_obtener.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ codigo: codigo_curso })
  })
    .then(response => response.json())
    .then(data => {
      btnEditar.style.display = 'inline';
      btnCrear.style.display = 'none';
      codigoCursoInput.value = data.codigo;
      codigo = data.codigo;
      detalle = data.detalle;
      cursoInput.value = data.curso;
      for (let i = 0; i < selectInput.options.length; i++) {
        if (selectInput.options[i].value === data.profesor_jefe_rut) {
          selectInput.value = data.profesor_jefe_rut;
          profesor = data.profesor_jefe_rut;
          break;
        }
      }
    })
    .catch(error => console.error(error));
}

btnEditar.addEventListener('click', function(event) {
  codigo = codigoCursoInput.value;
  detalle = cursoInput.value;
  profesor = selectInput.value;
  event.preventDefault();
  fetch ('.././core/cursos/curso_editar.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({codigo: codigo, detalle: detalle, profesorJefe: profesor})
  })
  .then(response => response.json())
  .then(data => {
    console.log(data);
    let alertas = document.getElementById('alertas');
    if (data.success) {
      alertas.innerHTML = '<div class="alert alert-success">El curso fue modificado exitosamente</div>';
      formCurso.reset();
      pintarTablaCurso();
    } else {
      alertas.innerHTML = '<div class="alert alert-danger">Ocurrió un error al editar el curso</div>';
    }
  })
  .catch(error => console.error(error));

  btnCrear.style.display = "block";
  btnEditar.style.display = "none";
})