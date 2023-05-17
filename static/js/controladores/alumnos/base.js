function obtenerPorRut(rut) {
    return new Promise((resolve, reject) => {
        fetch('.././core/alumnos/alumno_obtener.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ rut })
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error en la respuesta de la solicitud');
            }
        })
        .then(data => {
            resolve(data);
        })
        .catch(error => {
            reject(error);
        });
    });
}


function obtenerPorCurso(curso) {
    return new Promise((resolve, reject) => {
        fetch('.././core/alumnos/obtener_por_curso.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ codigo: curso })
        })
            .then(response => response.json())
            .then(data => {
                resolve(data);
            })
            .catch(error => reject(error))
    });
}

function obtenerCursos() {
    return new Promise((resolve, reject) => {
        fetch('.././core/cursos/cursos_obtener.php', {
            method: 'GET'
        })
            .then(response => response.json())
            .then(data => {
                resolve(data);
            })
            .catch(error => reject(error))
    })
}