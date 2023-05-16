<?php
require_once '../database/conexion.php';
require_once 'Cuenta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = new Usuario($conexion);

  $request_body = file_get_contents('php://input');
  $data = json_decode($request_body);

  session_start();
  $rut = $_SESSION['usuario_rut'];
  $contraActual = $data->contraActual;
  $contraNueva = $data->contraNueva;

  $respuesta = $usuario->modificarPassword($rut, $contraActual, $contraNueva);
  echo json_encode($respuesta);
}