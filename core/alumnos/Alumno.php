<?php
class Alumno
{
  private $conexion;

  public function __construct($conexion)
  {
    $this->conexion = $conexion;
  }

  public function crearAlumno($usuario_rut, $curso_id)
  {
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

  public function obtener($rut)
  {
    $query = "SELECT CONCAT(usuarios.nombres, ' ', usuarios.apellidos) AS nombre_completo, usuarios.rut,
                 cursos.curso_id, cursos.detalle, CONCAT(profesor_jefe.nombres, ' ', profesor_jefe.apellidos) AS profesor_jefe
          FROM usuarios
          INNER JOIN alumnos ON usuarios.rut = alumnos.usuario_id
          INNER JOIN cursos ON alumnos.curso_id = cursos.curso_id
          INNER JOIN usuarios AS profesor_jefe ON cursos.profesor_jefe = profesor_jefe.rut
          WHERE usuarios.rut = ?";
    $stmt = mysqli_prepare($this->conexion, $query);
    if (!$stmt) {
      return ['success' => false, 'error' => 'Error al preparar la consulta: ' . mysqli_error($this->conexion)];
    }

    mysqli_stmt_bind_param($stmt, "s", $rut);
    $resultado = mysqli_stmt_execute($stmt);

    if ($resultado === false) {
      return ['success' => false, 'error' => 'Error al ejecutar la consulta: ' . mysqli_error($this->conexion)];
    }

    $resultado = mysqli_stmt_get_result($stmt);
    $consulta = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    if ($consulta) {
      $respuesta = [
        'success' => true,
        'nombre_alumno' => $consulta['nombre_completo'],
        'rut_alumno' => $consulta['rut'],
        'codigo_curso' => $consulta['curso_id'],
        'nombre_curso' => $consulta['detalle'],
        'profesor_jefe' => $consulta['profesor_jefe']
      ];
    } else {
      $respuesta = ['success' => false];
    }
    return $respuesta;
  }



  public function obtenerPorCurso($codigo)
  {
    $query = "SELECT alumnos.usuario_id FROM cursos 
              JOIN alumnos ON cursos.curso_id = alumnos.curso_id
              WHERE cursos.curso_id = ?";
    $stmt = mysqli_prepare($this->conexion, $query);

    if (!$stmt) {
      return ['success' => false, 'error' => 'Error al preparar la consulta: ' . mysqli_error($this->conexion)];
    }

    mysqli_stmt_bind_param($stmt, "s", $codigo);
    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
      return ['success' => false, 'error' => 'Error al ejecutar la consulta: ' . mysqli_error($this->conexion)];
    }

    $resultado = mysqli_stmt_get_result($stmt);
    $consulta = mysqli_fetch_all($resultado);
    if ($consulta) {
      $alumnos = array();
      for ($i = 0; $i < count($consulta); $i++) {
        $rut = $consulta[$i][0];
        $alumno = $this->obtener($rut);
        if ($alumno['success']) {
          $alumnos[] = $alumno;
        }
      }
      $total_alumnos = count($alumnos);
      return ['success' => true, 'alumnos' => $alumnos, 'total_alumnos' => $total_alumnos];
    } else {
      return ['success' => false];
    }
  }
}
