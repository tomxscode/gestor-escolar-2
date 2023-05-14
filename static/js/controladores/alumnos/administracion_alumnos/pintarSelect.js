document.addEventListener('DOMContentLoaded', function(event) {
    obtenerCursos()
        .then(data => {
            console.log(data);
            let selectCurso = document.getElementById('select_curso');
            if (data.success) {
                let cursos = data.cursos;
                cursos.forEach(curso => {
                    selectCurso.innerHTML += `<option value ="${curso.curso_id}">${curso.detalle}</option>`;
                })
            }
        })
        .catch(error => {
            console.error(error)
        })
})