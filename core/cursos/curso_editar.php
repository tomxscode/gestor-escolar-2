<?php
require_once '../database/conexion.php';
require_once 'Curso.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $curso = new Curso($conexion);

  // Variables que recibe
  $request_body = file_get_contents('php://input');
  $req = json_decode($request_body);

  $codigo = $req->codigo ?? '';
  $detalle = $req->detalle ?? '';
  $profesorJefe = $req->profesorJefe ?? '';

  if (empty($codigo) || empty($detalle) || empty($profesorJefe)) {
    echo json_encode(['success' => 'false', 'info' => 'No se ingresaron datos o los datos no son válidos']);
    exit();
  }

  echo($curso->modificarCurso($codigo, $detalle, $profesorJefe));

}

?>