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
  } catch (error) {
    console.error('Ocurrió un error al procesar la solicitud:', error);
  }
}