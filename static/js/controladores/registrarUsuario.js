const form = document.querySelector("#form-registro");

form.addEventListener('submit', function (event) {
  event.preventDefault();
  registrarUsuario();
})

function registrarUsuario() {
  const form = document.getElementById('form-registro');
  const formData = new FormData(form);
  const requestBody = {};

  for (const [key, value] of formData.entries()) {
    requestBody[key] = value;
  }

  //requestBody.contrasena = password_hash(requestBody.contrasena, PASSWORD_DEFAULT);

  fetch('.././core/cuentas/registro.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(requestBody)
  })
    .then(response => response.json())
    .then(data => {
      console.log(data);
    })
    .catch(error => {
      console.error(error);
    });
}