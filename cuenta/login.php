<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once "../core/head.php"; ?>
  <title>Inicio de sesión</title>
</head>

<body>
  <?php
  require_once "../views/global/header.php";
  ?>
  <div class="container">
    <?php 
    if (!sesionAutenticada()) {
      require_once "../views/cuentas/login.html"; 
    } else {
      echo "
        <div class ='alert alert-info text-center' id='alertas'>
          <h5>Ya tienes una sesión iniciada</h5>
          <p>Selecciona una opción del panel de navegación para continuar</p>
        </div>";
    }
    ?>
  </div>
  <script src="../static/js/controladores/iniciarSesion.js"></script>
</body>

</html>