document.addEventListener('DOMContentLoaded', function(event) {
  obtenerPorRol(3);
})

function obtenerPorRol(rol) {
  fetch ('.././core/cuentas/obtener_por_rol.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({rol: rol})
  })
  .then(response => response.json())
  .then(data => {
    let select_profesores = document.getElementById('select-profesores');
    data.usuarios.forEach(usuario => {
      select_profesores.innerHTML += `<option value="${usuario.rut}">${formatearRut(usuario.rut)} - ${usuario.nombres} ${usuario.apellidos}</option>`;
    });
  })
  .catch(error => console.error(error));
}