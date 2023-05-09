<?php
require_once '../database/conexion.php';
require_once 'Cuenta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $request_body = file_get_contents('php://input');
  $data = json_decode($request_body);
  $rol = $data->rol;
  $usuario = new Usuario($conexion);
  $usuarios = $usuario->obtenerPorRol($rol);
  echo $usuarios;
}
?>