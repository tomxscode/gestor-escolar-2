<?php
require_once '../database/conexion.php';
require_once 'Curso.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $request_body = file_get_contents('php://input');
  $req = json_decode($request_body);

  $codigo = $req->codigo ?? '';

  $curso = new Curso($conexion);
  $data = $curso->obtenerDatos($codigo);
  echo $data;
}
?>