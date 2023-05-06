<?php

class Usuario {
  private $conexion;

  public function __construct($conexion) {
    $this->conexion = $conexion;
  }

  public function login($rut, $contrasena) {
    $query = "SELECT * FROM usuarios WHERE rut = ?";
    $stmt = mysqli_prepare($this->conexion, $query);
    mysqli_stmt_bind_param($stmt, "s", $rut);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    if (!$usuario) {
      return ['error' => 'El email o la contraseña son incorrectos.'];
    }

    $contrasena_verificada = password_verify($contrasena, $usuario['contrasena']);

    if (!$contrasena_verificada) {
      return ['error' => 'El email o la contraseña son incorrectos.'];
    }

    session_start();
    $_SESSION['usuario_rut'] = $usuario['rut'];
    $_SESSION['usuario_rol'] = $usuario['rol'];
    return ['success' => true];
  }

  public function registro($rut, $nombres, $apellidos, $email, $direccion, $telefono, $rol) {
    $permisos = 1;
    $contrasena = password_hash("tomas12", PASSWORD_DEFAULT);

    $query = "INSERT INTO usuarios (rut, nombres, apellidos, email, contrasena, direccion, telefono, rol, permisos_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($this->conexion, $query);

    if (!$stmt) {
      return ['error' => 'Error al preparar la consulta: ' . mysqli_error($this->conexion)];
    }

    mysqli_stmt_bind_param($stmt, "ssssssiii", $rut, $nombres, $apellidos, $email, $contrasena, $direccion, $telefono, $rol, $permisos);
    $registro_exitoso = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($registro_exitoso) {
      return ['success' => true];
    } else {
      return ['error' => 'Error al registrar el usuario. Por favor, intenta de nuevo.'];
    }
  }

  public function obtenerDatos($rut) {
    $query = "SELECT * FROM usuarios WHERE rut = ?";
    $stmt = mysqli_prepare($this->conexion, $query);
    mysqli_stmt_bind_param($stmt, "s", $rut);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    if ($usuario) {
        $respuesta = [
            'success' => true,
            'rut' => $usuario['rut'],
            'nombres' => $usuario['nombres'],
            'apellidos' => $usuario['apellidos'],
            'email' => $usuario['email'],
            'telefono' => $usuario['telefono'],
            'direccion' => $usuario['direccion'],
            'rol' => $usuario['rol'],
            'permisos_id' => $usuario['permisos_id']
        ];
    } else {
        $respuesta = ['success' => false];
    }
    return json_encode($respuesta);
}
}