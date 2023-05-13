<?php
session_start();
function visibleDesde($permiso_requerido)
{
    if (!isset($_SESSION['usuario_rol'])) {
        // Si el rol del usuario no está definido en la sesión, no tiene permiso para acceder
        return false;
    }
    $rol_usuario = $_SESSION['usuario_rol'];
    switch ($rol_usuario) {
        case 6: // Admin
            return true; // El administrador tiene acceso a todo
        case 5: // Inspector
            return $permiso_requerido <= 4; // El inspector tiene acceso a permisos igual o inferiores a Funcionario
        case 4: // Funcionario
            return $permiso_requerido <= 3; // El funcionario tiene acceso a permisos igual o inferiores a Profesor
        case 3: // Profesor
            return $permiso_requerido <= 2; // El profesor tiene acceso a permisos igual o inferiores a Alumno
        case 2: // Alumno
            return $permiso_requerido <= 1; // El alumno tiene acceso a permisos igual o inferiores a Invitado
        default:
            return false; // En cualquier otro caso, no tiene permiso para acceder
    }
}

function sesionAutenticada()
{
    if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['sesion']) && $_SESSION['sesion'] == true) {
        return true;
    } else {
        return false;
    }
}
