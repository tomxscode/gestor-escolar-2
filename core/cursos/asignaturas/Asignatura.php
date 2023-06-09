<?php
class Asignatura {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function crear($codigo, $detalle, $descripcion, $profesor, $curso_id) {
        $query = "INSERT INTO asignaturas (codigo, detalle, descripcion, profesor, curso) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        
        if (!$stmt) {
            return ['success' => false, 'error' => 'Error al ejecutar la consulta: ' . mysqli_error($this->conexion)];
        }

        mysqli_stmt_bind_param($stmt, "sssss", $codigo, $detalle, $descripcion, $profesor, $curso_id);

        $asignaturaCreada = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if (!$asignaturaCreada) {
            return ['success' => false];
        } else {
            return ['success' => true];
        }
    }

    public function obtener($asignatura_id) {
        $query = "SELECT * FROM asignaturas WHERE codigo = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        if (!$stmt) {
            return ['success' => false, 'error' => 'Error al ejecutar la consulta: ' . mysqli_error($this->conexion)];
        }
        mysqli_stmt_bind_param($stmt, "s", $asignatura_id);
        $resultado = mysqli_stmt_get_result($stmt);
        $consulta = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);

        if ($consulta) {
            $respuesta = [
                'success' => true,
                'codigo' => $consulta['codigo'],
                'nombre' => $consulta['detalle'],
                'descripcion' => $consulta['descripcion'],
                'curso' => $consulta['curso'],
                'profesor' => $consulta['profesor']
            ];
        } else {
            $respuesta = ['success' => false];
        }
        return $respuesta;
    }
}
