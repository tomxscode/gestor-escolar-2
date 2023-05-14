<?php
require_once "../core/cuentas/permisos.php";

$dominio = "http://localhost/gestor-escolar-2";
// enlaces
$micuenta = $dominio . '/cuenta/micuenta.php';
$inicio = $dominio . '/index.php';
$regAlumno = $dominio . '/alumnos/crear.php';
$cursos = $dominio . '/cursos/index.php';
$iniciarSesion = $dominio . '/cuenta/login.php';
$gestionAlumnos = $dominio . '/administracion/alumnos.php';
$cerrarSesionJS = $dominio . '/static/js/controladores/cuentas/cerrar_sesion.js';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-info pr-5 pl-5 mb-2">
  <a class="navbar-brand" href="<?php echo $inicio; ?>">Mi escuela</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <?php if (sesionAutenticada()) : ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Opción 1</a>
            <a class="dropdown-item" href="#">Opción 2</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Opción 3</a>
          </div>
        </li>

        <?php if (visibleDesde(3)) : ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Administración
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?php echo $cursos; ?>">Cursos</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?php echo $regAlumno; ?>">Registrar alumno</a>
              <a class="dropdown-item" href="<?php echo $gestionAlumnos; ?>">Gestionar alumnos</a>
            </div>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo $micuenta; ?>">Mi cuenta</a>
        </li>
        <li class="nav-item">
          <button class="nav-link btn btn-info" type="menu" onclick="cerrarSesion()">Cerrar sesión</button>
        </li>
      <?php else : ?>
        <li class="nav item">
          <a href="<?php echo $iniciarSesion; ?>" class="nav-link">Iniciar sesión</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
<script src="<?php echo $cerrarSesionJS; ?>"></script>