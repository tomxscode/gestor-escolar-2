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
  <div class="container">
    <div class="row">
      <div class="col-xl-8">
        <h1>Mi información</h1>
        <?php require_once "../views/cuentas/info_cuenta.html"; ?>
      </div>
    </div>
  </div>
  <script src="../static/js/controladores/modificarSesion.js"></script>
</body>
</html>