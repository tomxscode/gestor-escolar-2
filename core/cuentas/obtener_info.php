<?php
require_once '../database/conexion.php';
require_once 'Cuenta.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);

    $usuario = new Usuario($conexion);

    $rut = $_POST['rut'] ?? '';
    echo json_encode($usuario->obtenerDatos($rut));
}
?>