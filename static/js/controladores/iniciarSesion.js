const form = document.querySelector("#login-form");

form.addEventListener('submit', function (event) {
  event.preventDefault();
  iniciarSesion();
})

async function iniciarSesion() {
  const form = document.getElementById('login-form');
  const formData = new FormData(form);

  try {
    const response = await fetch('.././core/cuentas/login.php', {
      method: 'POST',
      body: formData
    });

    if (!response.ok) {
      throw new Error('Respuesta del servidor inválida');
    }

    const data = await response.json();
    if (data.error) {
      console.log(data.error);
    }
    
    console.log(data);
    let alertasContainer = document.getElementById('alertas');
    if (data.success) {
      alertasContainer.innerHTML = '<div class="alert alert-success"><p>La sesión fue iniciada correctamente <br>Continuarás dentro de 5 segundos, por favor, espera...</p></div>';
      setTimeout(function() {
        location.reload();
      }, 5000);
    } else {
      alertasContainer.innerHTML = '<div class="alert alert-danger"><p>' + data.error + '</p></div>'; 
    }
  } catch (error) {
    console.error('Ocurrió un error al procesar la solicitud:', error);
  }
}