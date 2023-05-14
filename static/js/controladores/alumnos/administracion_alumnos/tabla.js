let tabla = document.getElementById('tabla-alumnos'),
    cantidadAlumnos = document.getElementById('cantidad'),
    alertasContainer = document.getElementById('alertas'),
    tablaContenedor = document.getElementById('tabla-contenedor');
document.addEventListener('DOMContentLoaded', function (event) {
    // Ocultar tabla:
    tablaContenedor.style.display = 'none';

    // Evento: click al botón
    let btnCurso = document.getElementById('buscarCurso');
    btnCurso.addEventListener('click', function (event) {
        event.preventDefault();
        let cursoSeleccionado = document.getElementById('select_curso').value;
        pintarTabla(`${cursoSeleccionado}`);
    })
});

function pintarTabla(curso) {
    alertasContainer.innerHTML = `<div class="alert alert-info text-center">Consultado por el curso ${curso}, espere un momento...</div>`
    obtenerPorCurso(curso)
        .then(data => {
            if (data.success) {
                tabla.innerHTML = "";
                alertasContainer.innerHTML = "";
                if (data.total_alumnos < 1) {
                    alertasContainer.innerHTML = `<div class="alert alert-info text-center">El curso no contiene registros</div>`
                    throw new Error('No existen alumnos');
                }
                let alumnos = data.alumnos;
                alumnos.forEach(alumno => {
                    let elemento = `
            <tr>
                <td>${formatearRut(alumno.rut_alumno)}</td>
                <td>${alumno.nombre_alumno}</td>
                <td>${alumno.nombre_curso}</td>
                <td>${alumno.profesor_jefe}</td>
                <td>Accion</td>
            </tr>
            `
                    tabla.innerHTML += elemento;
                });
                cantidadAlumnos.innerHTML = data.total_alumnos;
                tablaContenedor.style.display = 'block';
            } else {
                throw new Error('No existen registros para ese curso');
            }
        })
        .catch(error => {
            tablaContenedor.style.display = 'none';
            alertasContainer.innerHTML = '<div class="alert alert-danger text-center">No existen registros en ese curso o no existe</div>';
        })
}