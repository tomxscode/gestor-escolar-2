<?php
require_once '../database/conexion.php';
require_once 'Alumno.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $alumno = new Alumno($conexion);

  $request_body = file_get_contents('php://input');
  $data = json_decode($request_body);

  $codigo = $data->codigo;

  echo json_encode($alumno->obtenerPorCurso($codigo));
}
?>