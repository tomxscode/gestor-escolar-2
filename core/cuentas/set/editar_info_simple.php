<?php
require_once '../../database/conexion.php';
require_once '../Cuenta.php';
require_once '../permisos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = new Usuario($conexion);

  $request_body = file_get_contents('php://input');
  $data = json_decode($request_body);

  $rut = $_SESSION['usuario_rut'];
  $email = $data->email ?? '';

  if (accesoMenorQue(2) || empty($email)) {
    $datos = $usuario->obtenerInfoSimple($rut);
    if ($datos['success']) {
      $email = $datos['email'];
    } else {
      echo json_encode(['success' => false, 'info' => 'Ocurrió un error al obtener la información actual']);
    }
  }

  $telefono = $data->telefono ?? '';
  $direccion = $data->direccion ?? '';

  // Ejecutando la consulta de modificación de información
  $modificacion = $usuario->modificarDatos($rut, $email, $telefono, $direccion);
  if ($modificacion['success']) {
    $respuesta = $modificacion;
  } else {
    $respuesta = ['success' => false, 'info' => 'Ocurrió un error al modificar la información'];
  }
  echo json_encode($respuesta);
}
