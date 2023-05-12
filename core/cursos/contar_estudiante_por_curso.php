<?php
require_once '../database/conexion.php';
require_once 'Curso.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $curso = new Curso($conexion);

  $request_body = file_get_contents('php://input');
  $data = json_decode($request_body);

  $codigo = $data->codigo;

  echo json_encode($curso->contarEstudiantes($codigo));
}
?>