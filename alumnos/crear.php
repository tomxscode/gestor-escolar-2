<?php require_once "../core/base.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once "../core/head.php"; ?>
  <title>Registro de usuario</title>
</head>
<body>
<?php
  require_once "../core/cuentas/permisos.php";
  if (!visibleDesde(3)) {
    require_once "../views/global/sin_permiso.html";
    exit();
  } else {
    require_once "../views/global/header.php";
  }
  ?>
  <div class="container">
    <div class="alertas" id="alertas"></div>
    <h1>Registrar alumno</h1>
    <p>
      Todos los campos requeridos son obligatorios para un mejor funcionamiento del sistema. <br>
      La contraseña por defecto será el rut del alumno.
    </p>
    <?php require_once "../views/alumnos/crear.html"; ?>
  </div>
  <script src="../static/js/controladores/registrarUsuario.js"></script>
</body>
</html>