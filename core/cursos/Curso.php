<?php
class Curso {
  private $conexion;
  public function __construct($conexion) {
    $this->conexion = $conexion;
  }

  public function crearCurso($codigo, $concepto, $profesorJefe) {
    if (empty($codigo) || empty($concepto) || empty($profesorJefe)) {
      return ['error' => 'Faltan datos obligatorios'];
    }
    $query = "INSERT INTO cursos (curso_id, detalle, profesor_jefe) VALUES (?,?,?)";
    $stmt = mysqli_prepare($this->conexion, $query);

    if (!$stmt) {
      return ['error' => 'Error al ejecutar la consulta: ' . mysqli_error($this->conexion)];
    }

    mysqli_stmt_bind_param($stmt, "sss", $codigo, $concepto, $profesorJefe);
    $creacionExitosa = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($creacionExitosa) {
      return ['success' => true, 'codigo' => $codigo, 'curso' => $concepto, 'profesor_jefe_rut' => $profesorJefe];
    } else {
      return ['error' => 'Ocurrió un error al registrar el curso'];
    }
  }

  public function obtenerDatos($codigo) {
    $query = "SELECT * FROM cursos WHERE curso_id = ?";
    $stmt = mysqli_prepare($this->conexion, $query);

    if (!$stmt) {
      return ['error' => 'Error al ejecutar la consulta: ' . mysqli_error($this->conexion)];
    }

    mysqli_stmt_bind_param($stmt, "s", $codigo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $curso = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    if ($curso) {
      $respuesta = [
        'success' => true,
        'codigo' => $curso['curso_id'],
        'curso' => $curso['detalle'],
        'profesor_jefe_rut' => $curso['profesor_jefe']
      ];
    } else {
      $respuesta = ['success' => false];
    }
    return json_encode($respuesta);
  }

  public function modificarCurso($codigo, $detalle, $profesorJefe) {
    $query = "UPDATE cursos SET curso_id = ?, detalle = ?, profesor_jefe = ? WHERE curso_id = ?";
    $stmt = mysqli_prepare($this->conexion, $query);

    if (!$stmt) {
      $peticion = ['error' => 'Error al editar el curso'];
    }

    mysqli_stmt_bind_param($stmt, "ssss", $codigo, $detalle, $profesorJefe, $codigo);

    if (mysqli_stmt_execute($stmt)) {
      $peticion = ['success' => 'true', 'info' => 'El curso fue editado satisfactoriamente'];
    } else {
      $peticion = ['error' => 'Error al editar el curso'];
    }

    mysqli_stmt_close($stmt);
    return json_encode($peticion);
  }

  public function obtenerCursos() {
    $query = "SELECT * FROM cursos";
    $stmt = mysqli_prepare($this->conexion, $query);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $cursos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    if ($cursos) {
      $respuesta = [
        'success' => true,
        'cursos' => $cursos
      ];
    } else {
      $respuesta = ['success' => false];
    }
    return json_encode($respuesta);
  }
}
?>