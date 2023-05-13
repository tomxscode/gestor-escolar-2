<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once "../core/head.php"; ?>
  <title>Mi cuenta</title>
</head>

<body>
  <?php
  require_once "../core/cuentas/permisos.php";
  if (!visibleDesde(2)) {
    require_once "../views/global/sin_permiso.html";
    exit();
  } else {
    require_once "../views/global/header.php";
  }
  ?>
  <div class="container">
    <div class="row">
      <div class="alertas" id="alertas"></div>
      <div class="col-xl-8">
        <h1>Mi información</h1>
        <?php require_once "../views/cuentas/info_cuenta.html"; ?>
      </div>
    </div>
  </div>
  <script src="../static/js/controladores/modificarSesion.js"></script>
  <!-- jQuery (requerido para los plugins de JavaScript de Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Archivos JavaScript de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>