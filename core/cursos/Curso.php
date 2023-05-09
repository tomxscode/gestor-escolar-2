<?php
class Curso {
  private $conexion;
  public function __construct($conexion) {
    $this->conexion = $conexion;
  }

  public function crearCurso($codigo, $concepto, $profesorJefe) {
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
}
?>