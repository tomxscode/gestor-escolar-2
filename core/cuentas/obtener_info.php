<?php
require_once '../database/conexion.php';
require_once 'Cuenta.php';

$request_body = file_get_contents('php://input');
$req = json_decode($request_body);

if (empty($req->usuario_rut)) {
  session_start();
  $rut = $_SESSION['usuario_rut'];
} else {
  $rut = $req->usuario_rut;
}

$usuario = new Usuario($conexion);
$data = $usuario->obtenerDatos($rut);

header('Content-Type: application/json');
echo $data;
?>