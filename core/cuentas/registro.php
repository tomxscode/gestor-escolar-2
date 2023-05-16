<?php
require_once '../database/conexion.php';
require_once 'Cuenta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($conexion);

    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    
    $rut = $data->rut;
    $nombres = $data->nombres;
    $apellidos = $data->apellidos;
    $email = $data->email;
    $direccion = $data->direccion;
    $telefono = $data->telefono;
    $rol = $data->rol;
    $sexo = $data->sexo;
    //$sexo = 0;
    $permisos = 1;
    $contrasena = password_hash($rut, PASSWORD_DEFAULT);
    echo json_encode($usuario->registro($rut, $nombres, $apellidos, $email, $direccion, $telefono, $rol, $sexo));
}
?>