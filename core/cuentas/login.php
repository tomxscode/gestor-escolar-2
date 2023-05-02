<?php
require_once '../database/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['rut'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM usuarios WHERE rut = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    if (!$usuario) {
        echo json_encode(['error' => 'El email o la contraseña son incorrectos.']);
        exit();
    }

    $contrasena_verificada = password_verify($contrasena, $usuario['contrasena']);

    if (!$contrasena_verificada) {
        echo json_encode(['error' => 'El email o la contraseña son incorrectos.']);
        exit();
    }

    session_start();
    $_SESSION['usuario'] = $usuario;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Petición inválida.']);
}