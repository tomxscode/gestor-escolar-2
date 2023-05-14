document.addEventListener('DOMContentLoaded', function (event) {
    let tabla = document.getElementById('tabla-alumnos'),
        cantidadAlumnos = document.getElementById('cantidad'),
        alertasContainer = document.getElementById('alertas'),
        tablaContenedor = document.getElementById('tabla-contenedor'),
        selectCurso = document.getElementById('select_curso');
    
    // Ocultar tabla:
    tablaContenedor.style.display = 'none';

    obtenerPorCurso('SEPT_A')
        .then(data => {
            if (data.success) {
                let alumnos = data.alumnos;
                alumnos.forEach(alumno => {
                    let elemento = `
                <tr>
                    <td>${alumno.rut_alumno}</td>
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
            alertasContainer.innerHTML += '<div class="alert alert-danger text-center">No existen registros en ese curso o no existe</div>';
        })
});