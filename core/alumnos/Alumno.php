<?php
class Alumno {
  private $conexion;

  public function __construct($conexion) {
    $this->conexion = $conexion;
  }

  public function crearAlumno($usuario_rut, $curso_id) {
    $query = "INSERT INTO alumnos (usuario_id, curso_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($this->conexion, $query);

    if (!$stmt) {
      return ['error' => 'Error al ejecutar la consulta' . mysqli_error($this->conexion)];
    }

    mysqli_stmt_bind_param($stmt, "ss", $usuario_rut, $curso_id);
    $creacionExitosa = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($creacionExitosa) {
      return ['success' => true];
    } else {
      return ['success' => false];
    }
  }
}
?>