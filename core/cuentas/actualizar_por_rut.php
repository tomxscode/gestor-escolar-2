<?php
require_once '../database/conexion.php';
require_once 'Cuenta.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $usuario = new Usuario($conexion);

    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    
    session_start();
    $rut = $_SESSION['usuario_rut'];

    $info = $usuario->obtenerDatos($rut);

    $info = json_decode($info, true);
    
    $direccion = $data->direccion ?? $info['direccion'];
    $telefono = $data->telefono ?? $info['telefono'];
    $email = $data->email ?? $info['email'];

    $actualizado = $usuario->actualizarDatosPorRut($rut, $info['nombres'], $info['apellidos'], $email, $direccion, $telefono, $info['rol'], $info['permisos_id']);
    if ($actualizado) {
      echo(json_encode(['success' => true]));
    } else {
      echo(json_encode(['success' => false]));
    }
}
?>