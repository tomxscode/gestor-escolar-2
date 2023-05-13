<?php
require_once './permisos.php';
if (!sesionAutenticada()) {
    echo json_encode(['success' => false]);
} else {
    session_destroy();
    echo json_encode(['success' => true]);
}
