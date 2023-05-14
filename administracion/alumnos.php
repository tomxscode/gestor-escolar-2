<?php require_once "../core/base.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once "../core/head.php"; ?>
  <title>Alumnos</title>
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
    <h1>Gestión de alumnos</h1>
    <p>Seleccione alguna opción para continuar</p>
    <div class="row">
      <?php require_once "../views/administracion/alumnos.html"; ?>
    </div>
  </div>
  <script src="../static/js/utilidades.js"></script>
  <script src="../static/js/utilidades.js"></script>
  <script src="../static/js/controladores/alumnos/base.js"></script>
  <script src="../static/js/controladores/alumnos/administracion_alumnos/tabla.js"></script>
  <script src="../static/js/controladores/alumnos/administracion_alumnos/pintarSelect.js"></script>
</body>
</html>