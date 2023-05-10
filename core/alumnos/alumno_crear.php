<?php
require_once '../database/conexion.php';
require_once 'Alumno.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $alumno = new Alumno($conexion);

  $request_body = file_get_contents('php://input');
  $data = json_decode($request_body);

  $curso_id = $data->curso_id;
  $usuario_id = $data->usuario_id;

  echo json_encode($alumno->crearAlumno($usuario_id,$curso_id));
}
?>