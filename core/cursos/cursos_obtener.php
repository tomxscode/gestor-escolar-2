<?php
require_once '../database/conexion.php';
require_once 'Curso.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $curso = new Curso($conexion);
  $data = $curso->obtenerCursos();
  echo $data;
}
?>