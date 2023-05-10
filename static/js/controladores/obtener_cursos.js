document.addEventListener('DOMContentLoaded', function (event) {
  pintarTablaCurso();
})

let cursos_tabla = document.getElementById('tabla-cursos');

function pintarTablaCurso() {
  fetch('.././core/cursos/cursos_obtener.php', {
    method: 'POST',
  })
    .then(response => response.json())
    .then(data => {
      var filas = [];
      data.cursos.forEach(curso => {
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

            fila += `<td>Accion</td></tr>`;
            filas.push(fila);
            ordenarTabla(filas);
          })
          .catch(error => console.error(error))
      });
    })
    .catch(error => console.error(error));
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
