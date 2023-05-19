<?php

// NECESITA REESTRUCTURACIÓN DEL CÓDIGO

class Usuario
{
  // INFO
  // SEXO 1: hombre 0: mujer
  private $conexion;

  public function __construct($conexion)
  {
    $this->conexion = $conexion;
  }

  public function login($rut, $contrasena)
  {
    $query = "SELECT * FROM usuarios WHERE rut = ?";
    $stmt = mysqli_prepare($this->conexion, $query);
    mysqli_stmt_bind_param($stmt, "s", $rut);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    if (!$usuario) {
      return ['success' => false, 'error' => 'El email o la contraseña son incorrectos.'];
    }

    $contrasena_verificada = password_verify($contrasena, $usuario['contrasena']);

    if (!$contrasena_verificada) {
      return ['success' => false, 'error' => 'El email o la contraseña son incorrectos.'];
    }

    session_start();
    $_SESSION['usuario_rut'] = $usuario['rut'];
    $_SESSION['usuario_rol'] = $usuario['rol'];
    $_SESSION['usuario_permisos'] = $usuario['permisos_id'];
    $_SESSION['sesion'] = true;
    return ['success' => true];
  }

  public function getRut() {
    // Iniciando sesión
    session_start();
    // Comprobamos que hay una sesión activa y existe usuario_rut
    if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['usuario_rut'])) {
      return ['success' => true, 'rut' => $_SESSION['usuario_rut']];
    } else {
      return ['success' => false];
    }
  }

  public function obtenerInfoSimple($rut) {
    $query = "SELECT rut, nombres, apellidos, email, direccion, telefono, sexo, rol FROM usuarios WHERE rut = ?";
    $stmt = mysqli_prepare($this->conexion, $query);
  
    if (!$stmt) {
      return ['success' => false, 'info' => 'Error al preparar la consulta: ' . mysqli_error($this->conexion)];
    }
  
    mysqli_stmt_bind_param($stmt, "s", $rut);
  
    if (!mysqli_stmt_execute($stmt)) {
      return ['success' => false, 'info' => 'Error al ejecutar la consulta: ' . mysqli_stmt_error($stmt)];
    }
  
    $resultado = mysqli_stmt_get_result($stmt);
    $datos = mysqli_fetch_assoc($resultado);
  
    mysqli_stmt_close($stmt);
  
    if ($datos) {
      $respuesta = [
        'success' => true,
        'nombres' => $datos['nombres'],
        'apellidos' => $datos['apellidos'],
        'email' => $datos['email'],
        'direccion' => $datos['direccion'],
        'telefono' => $datos['telefono'],
        'sexo' => $datos['sexo'],
        'rol' => $datos['rol']
      ];
    } else {
      $respuesta = ['success' => false];
    }
    return $respuesta;
  }
  
  

  public function registro($rut, $nombres, $apellidos, $email, $direccion, $telefono, $rol, $sexo)
  {
    // Verificar que todos los campos estén llenos
    if (!empty($rol) && !$rol == 2) {
      if (empty($rut) || empty($nombres) || empty($apellidos) || empty($email) || empty($direccion) || empty($telefono) || empty($rol) || empty($sexo)) {
        return ['error' => 'Por favor, completa todos los campos'];
      }
    } 
    

    $permisos = 1;
    $contrasena = password_hash($rut, PASSWORD_DEFAULT);

    $query = "INSERT INTO usuarios (rut, nombres, apellidos, email, contrasena, direccion, telefono, rol, sexo, permisos_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($this->conexion, $query);

    if (!$stmt) {
      return ['error' => 'Error al preparar la consulta: ' . mysqli_error($this->conexion)];
    }

    mysqli_stmt_bind_param($stmt, "ssssssiiii", $rut, $nombres, $apellidos, $email, $contrasena, $direccion, $telefono, $rol, $sexo, $permisos);
    $registro_exitoso = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($registro_exitoso) {
      return ['success' => true];
    } else {
      return ['error' => 'Error al registrar el usuario. Por favor, intenta de nuevo.'];
    }
  }


  public function obtenerDatos($rut)
  {
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
        'permisos_id' => $usuario['permisos_id'],
        'sexo' => $usuario['sexo']
      ];
    } else {
      $respuesta = ['success' => false];
    }
    return json_encode($respuesta);
  }

  public function obtenerPorRol($rol)
  {
    $query = "SELECT * FROM usuarios WHERE rol = ?";
    $stmt = mysqli_prepare($this->conexion, $query);
    mysqli_stmt_bind_param($stmt, "s", $rol);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuarios = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    if ($usuarios) {
      $respuesta = [
        'success' => true,
        'usuarios' => $usuarios
      ];
    } else {
      $respuesta = ['success' => false];
    }
    return json_encode($respuesta);
  }

  public function actualizarDatosPorRut($rut, $nombres, $apellidos, $email, $direccion, $telefono, $rol, $permisos_id)
  {
    $query = "UPDATE usuarios SET nombres = ?, apellidos = ?, email = ?, direccion = ?, telefono = ?, rol = ?, permisos_id = ? WHERE rut = ?";

    $stmt = $this->conexion->prepare($query);
    $stmt->bind_param("ssssiiis", $nombres, $apellidos, $email, $direccion, $telefono, $rol, $permisos_id, $rut);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function modificarPassword($rut, $passwordActual, $nuevaPassword)
  {
    if ($this->checkContrasena($rut, $passwordActual)) {
      $query = "SELECT contrasena FROM usuarios WHERE rut = ?";
      $stmt = mysqli_prepare($this->conexion, $query);
      mysqli_stmt_bind_param($stmt, "s", $rut);
      mysqli_stmt_execute($stmt);
      $resultado = mysqli_stmt_get_result($stmt);
      $password = mysqli_fetch_assoc($resultado)['contrasena'];
      mysqli_stmt_close($stmt);

      if (password_verify($nuevaPassword, $password)) {
        return ['success' => false, 'error' => 'La contraseña nueva es igual a la actual'];
      }

      $nuevaPasswordHash = password_hash($nuevaPassword, PASSWORD_DEFAULT);
      $query = "UPDATE usuarios SET contrasena = ? WHERE rut = ?";
      $stmt = mysqli_prepare($this->conexion, $query);
      mysqli_stmt_bind_param($stmt, "ss", $nuevaPasswordHash, $rut);
      mysqli_stmt_execute($stmt);
      $afectados = mysqli_stmt_affected_rows($stmt);
      mysqli_stmt_close($stmt);

      if ($afectados > 0) {
        return ['success' => true];
      } else {
        return ['success' => false, 'error' => 'No se pudo cambiar la contraseña'];
      }
    } else {
      return ['success' => false, 'error' => 'La contraseña actual no es correcta'];
    }
  }

  // Comprueba que una contraseña es válida.
  public function checkContrasena($rut, $password)
  {
    $query = "SELECT contrasena FROM usuarios WHERE rut = ?";
    $stmt = mysqli_prepare($this->conexion, $query);
    mysqli_stmt_bind_param($stmt, "s", $rut);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $passwordActual = mysqli_fetch_assoc($resultado)['contrasena'];
    mysqli_stmt_close($stmt);

    if (password_verify($password, $passwordActual)) {
      return true;
    } else {
      return false;
    }
  }
}
