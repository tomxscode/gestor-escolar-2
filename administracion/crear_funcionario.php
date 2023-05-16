<?php require_once "../core/base.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once "../core/head.php"; ?>
  <title>Crear funcionario</title>
</head>
<body>
<?php
  require_once "../core/cuentas/permisos.php";
  require_once "../views/global/header.php";
  if (!visibleDesde(3) && !sesionAutenticada()) {
    require_once "../views/global/sin_permiso.html";
    exit();
  }
  ?>
  <div class="container">
    <div class="alertas" id="alertas"></div>
    <h1>Creación de funcionario</h1>
    <p>Crea un nuevo funcionario por rol</p>
    <div class="row">
      <?php require_once "../views/administracion/crear_funcionario.html"; ?>
    </div>
  </div>
  <script src="../static/js/utilidades.js"></script>
  <script src="../static/js/controladores/administracion/funcionarios.js"></script>
</body>
</html>