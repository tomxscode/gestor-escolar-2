<?php
require_once '../database/conexion.php';
require_once 'Cuenta.php';
session_start();
$rut = $_SESSION['usuario_rut'];

$usuario = new Usuario($conexion);
$data = $usuario->obtenerDatos($rut);

header('Content-Type: application/json');
echo $data;
?>