<?php require_once "../core/base.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once "../core/head.php"; ?>
  <title>Gestión de cursos</title>
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
    <h1>Gestión de cursos</h1>
    <p>¿Qué deseas hacer hoy?</p>
    <div class="row">
      <div class="col-md-8">
        <h2>Listar cursos</h2>
      </div>
      <div class="col-md-4">
        <h2>Crear curso</h2>
        <?php require_once "../views/cursos/crear.html"; ?>
      </div>
    </div>
  </div>
  <script src="../static/js/utilidades.js"></script>
  <script src="../static/js/controladores/cuentas.js"></script>
  <script src="../static/js/controladores/crear_curso.js"></script>
</body>
</html>