function obtenerPorRut(rut) {
    fetch ('.././core/alumnos/alumno_obtener.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({rut})
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => console.error(error))
}

function obtenerPorCurso(curso) {
    fetch ('.././core/alumnos/obtener_por_curso.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({codigo: curso})
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => console.error(error))
}