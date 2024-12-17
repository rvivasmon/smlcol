<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rol_id = $_POST['rol_id'];
    $permisos = $_POST['permisos'] ?? [];

    // Elimina permisos previos para el rol
    $pdo->prepare("DELETE FROM menu_roles_permisos WHERE rol_id = $rol_id");

    // Inserta los permisos seleccionados
    foreach ($permisos as $permiso_id) {
        $pdo->prepare("INSERT INTO menu_roles_permisos (rol_id, permiso_id) VALUES ($rol_id, $permiso_id)");
    }

    echo "Permisos asignados correctamente.";
}
?>
