<?php
require_once '../database/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rut = $_POST['rut'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $rol = $_POST['rol'];
    $permisos = $_POST['permisos'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $query = "INSERT INTO usuarios (rut, nombres, apellidos, email, contrasena, direccion, telefono, rol, permisos_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $query);

    if (!$stmt) {
      echo json_encode(['error' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
      exit();
  }

    mysqli_stmt_bind_param($stmt, "ssssssiii", $rut, $nombres, $apellidos, $email, $contrasena, $direccion, $telefono, $rol, $permisos);
    $registro_exitoso = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($registro_exitoso) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error al registrar el usuario. Por favor, intenta de nuevo.']);
    }
} else {
    echo json_encode(['error' => 'Petición inválida.']);
}

?>