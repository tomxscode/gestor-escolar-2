<?php
require_once '../database/conexion.php';
require_once 'Curso.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $codigo = $_POST['codigo'];

  $curso = new Curso($conexion);
  $data = $curso->obtenerDatos($codigo);
  echo $data;
}
?>