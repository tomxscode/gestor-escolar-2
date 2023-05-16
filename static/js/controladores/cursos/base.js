document.addEventListener('DOMContentLoaded', function (event) {
  pintarTablaCurso();
})

let cursos_tabla = document.getElementById('tabla-cursos');
let cursoData;

function pintarTablaCurso() {
  fetch('.././core/cursos/cursos_obtener.php', {
    method: 'POST',
  })
    .then(response => response.json())
    .then(data => {
      var filas = [];
      data.cursos.forEach(curso => {
        // crear fila completa para el curso
        crearFilaCurso(curso, fila => {
          filas.push(fila);
          ordenarTabla(filas);
        });
      });
    })
    .catch(error => console.error(error));
}

function crearFilaCurso(curso, callback) {
  let fila = `<tr><td>${curso.curso_id}</td><td>${curso.detalle}</td>`;

  // obtener nombre del profesor
  fetch('.././core/cuentas/obtener_info.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ usuario_rut: (curso.profesor_jefe) })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        fila += `<td>${data.nombres} ${data.apellidos}</td>`;
      } else {
        fila += `<td>Sin profesor asignado</td>`;
      }

      fila += `<td><button class="btn btn-warning" onclick="enviarAlFormulario('${curso.curso_id}')">Editar</button> `;
      fila += `<button type="button" class="btn btn-danger" onclick="eliminarCurso('${curso.curso_id}')">Eliminar</button>`;
      fila += "</td></tr>";

      callback(fila);
    })
    .catch(error => console.error(error))
}

function ordenarTabla(filas) {
  // Ordena la matriz
  filas.sort();

  // Vacía la tabla
  cursos_tabla.innerHTML = '';

  // Agrega los elementos ordenados a la tabla
  filas.forEach(fila => {
    cursos_tabla.innerHTML += fila;
  });
}

function eliminarCurso(codigo) {
  fetch('.././core/cursos/eliminar_curso.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ codigo: codigo })
  })
    .then(response => response.json())
    .then(data => {
      console.log(data)
      if (data.success) {
        setAlerta('success', data.info);
        agregarAlerta('info', 'Actualizando lista de cursos...');
        pintarTablaCurso();
      } else {
        setAlerta('danger', data.info);
      }
    })
    .catch(error => console.error(error))
}