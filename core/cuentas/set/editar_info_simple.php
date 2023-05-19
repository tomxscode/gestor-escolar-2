<?php
require_once '../../database/conexion.php';
require_once '../Cuenta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($conexion);

    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    
    session_start();
    $rut = $_SESSION['usuario_rut'];

    $datos = $usuario->obtenerInfoSimple($rut);
    if ($datos['success']) {
        $email = $datos['email'];
        $telefono = $data->telefono;
        $direccion = $data->direccion;

        // Ejecutando la consulta de modificación de información
        $modificacion = $usuario->modificarDatos($rut, $email, $telefono, $direccion);
        if ($modificacion['success']) {
            $respuesta = $modificacion;
        } else {
            $respuesta = ['success' => false, 'info' => 'Ocurrió un error al modificar la información'];
        }
    } else {
        $respuesta = ['success' => false, 'info' => 'Ocurrió un error al obtener el RUN para la modificación de datos'];
    }
    echo json_encode($respuesta);
}