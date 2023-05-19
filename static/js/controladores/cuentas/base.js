function obtenerInfoActual() {
    return fetch('.././core/cuentas/get/info_simple.php', {
        method: 'GET'
    })
        .then(response => response.json());
}

async function pintarInformacion() {
    try {
        // Obtenemos la información utilizando await para esperar la resolución de la promesa
        const informacion = await obtenerInfoActual();
        console.log(informacion);

        // Obtiene todo el formulario por medio de su ID
        var formulario = document.getElementById('micuenta-form');
        // Obtiene todos los elementos del formulario (tipo input) por medio del atributo name
        var inputs = formulario.querySelectorAll('input[name]');
        // Itera todos los inputs
        inputs.forEach(function (input) {
            var nombre = input.name;

            if (nombre === 'sexo') {
                // Verificar el valor del campo de sexo y asignar el texto correspondiente
                input.value = informacion[nombre] === '0' ? 'Femenino' : 'Masculino';
            } else if (nombre === 'rol') {
                // Verificar el valor del campo de rol y asignar el texto correspondiente
                var valorRol = informacion[nombre];

                switch (valorRol) {
                    case 6:
                        input.value = 'Administrador';
                        break;
                    case 5:
                        input.value = 'y';
                        break;
                    default:
                        input.value = '';
                        break;
                }
            } else {
                // Para los demás campos, agregar información al valor del input
                input.value = informacion[nombre];
            }
        });

    } catch (error) {
        console.error(error);
    }
}

// Llama a la función pintarInformacion después de que el DOM haya cargado
document.addEventListener('DOMContentLoaded', pintarInformacion);
