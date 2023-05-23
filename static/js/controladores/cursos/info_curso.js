var codigo = 0, informacion;
document.addEventListener('DOMContentLoaded', function() {
  let url = new URLSearchParams(window.location.search);
  codigo = url.get('codigo');

  inicializar(codigo)
    .then(() => {
      console.log(informacion);
    })
    .catch(error => console.error(error));
});


function inicializar(codigo) {
  return obtenerCurso(codigo)
    .then(data => {
      informacion = data;
    })
    .catch(error => console.error(error));
}