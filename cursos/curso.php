<?php 
// importanción base
require_once "../core/base.php"; 

// Obtener el código
$codigo = $_GET['codigo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once "../core/head.php"; ?>
  <title>CURSO</title>
</head>
<body>
<?php
  require_once "../core/cuentas/permisos.php";
  require_once "../views/global/header.php";
  if (!visibleDesde(3) && sesionAutenticada()) {
    require_once "../views/global/sin_permiso.html";
    exit();
  }
  ?>
  <div class="container">
    <div class="alertas" id="alertas"></div>
    <h1>Opciones del curso <span id="curso-nombre"></span></h1>
    <p>Algunas opciones podrían no funcionar si no posee el rol necesario *</p>
  <script src="../static/js/utilidades.js"></script>
  <script src="../static/js/controladores/cursos/base.js"></script>
  <script src="../static/js/controladores/cursos/info_curso.js"></script>
</body>
</html>