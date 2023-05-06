<?php
require_once '../database/conexion.php';
require_once 'Cuenta.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($conexion);
    $rut = $_POST['rut'];
    $contrasena = $_POST['contrasena'];
    echo json_encode($usuario->login($rut, $contrasena));
}
?>