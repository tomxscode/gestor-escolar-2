<?php
require_once '../database/conexion.php';
require_once 'Curso.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $curso = new Curso($conexion);

  // Variables que recibe
  $request_body = file_get_contents('php://input');
  $req = json_decode($request_body);

  $codigo = $req->codigo ?? '';

  echo(json_encode($curso->eliminar($codigo)));
}