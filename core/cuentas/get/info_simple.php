<?php
require_once '../../database/conexion.php';
require_once '../Cuenta.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $usuario = new Usuario($conexion);

    // Obtenemos el rut del usuario
    $rut = $usuario->getRut();

    if ($rut['success']) {
        $respuesta = $usuario->obtenerInfoSimple($rut['rut']);
        echo json_encode($respuesta);
      } else {
        // Manejar el caso en el que no se obtenga el rut correctamente
        $respuesta = ['success' => false, 'info' => 'No se pudo obtener el rut del usuario'];
        echo json_encode($respuesta);
      }
}