const form = document.querySelector("#form-registro");

form.addEventListener('submit', function (event) {
  event.preventDefault();
  registrarUsuario();
})

document.addEventListener('DOMContentLoaded', function (event) {
  obtenerCursos();
})

function registrarUsuario() {
  const formData = new FormData(form);
  const requestBody = {};

  for (const [key, value] of formData.entries()) {
    requestBody[key] = value;
  }

  //requestBody.contrasena = password_hash(requestBody.contrasena, PASSWORD_DEFAULT);

  fetch('.././core/cuentas/registro.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(requestBody)
  })
    .then(response => response.json())
    .then(data => {
      console.log(data);
      if (data.success) {
        let curso = document.getElementById('select-cursos').value;
        let rut_alumno = document.getElementById('alumno-rut').value;

        // Creación de alumno en la tabla ALUMNOS
        fetch('.././core/alumnos/alumno_crear.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ curso_id: curso, usuario_id: rut_alumno })
        })
          .then(response => response.json())
          .then(dataAlumno => {
            if (dataAlumno.success) {
              let tipo = form.querySelector("#tipo").value;
              let alertasContainer = document.querySelector("#alertas");
              if (tipo === "alumno") {
                alertasContainer.innerHTML = '<div class="alert alert-success">El alumno fue registrado satisfactoriamente</div>';
              }
            }
          })
          .catch(error => {
            console.error(error);
          })

      }
    })
    .catch(error => {
      console.error(error);
    });
}

function obtenerCursos() {
  fetch('.././core/cursos/cursos_obtener.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    }
  })
    .then(response => response.json())
    .then(data => {
      let select_cursos = document.getElementById('select-cursos');
      data.cursos.forEach(curso => {
        select_cursos.innerHTML += `<option value="${curso.curso_id}">${curso.detalle}</option>`;
      });
    })
    .catch(error => console.error(error));
}