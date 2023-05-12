function obtenerInfo(codigo) {
  fetch ('.././core/cursos/informacion_curso.php', {
    method: 'POST',
    body: JSON.stringify({codigo: codigo}),
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    return data;
  })
  .catch(error => console.error(error))
}

obtenerInfo("123456")

function pintarInformacion() {

}