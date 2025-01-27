<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

// Validar el rol_id recibido
if (isset($_GET['rol_id'])) {
    $rol_id = $_GET['rol_id'];

    // Obtener los permisos asignados
    $query_roles_permisos = $pdo->prepare("SELECT permiso_id FROM roles_permisos WHERE rol_id = :rol_id AND estado = '1'");
    $query_roles_permisos->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
    $query_roles_permisos->execute();
    $assigned_permissions = $query_roles_permisos->fetchAll(PDO::FETCH_COLUMN);

    // Obtener los permisos no asignados
    $sql_permisos = "SELECT * FROM t_permisos WHERE estado = '1' ORDER BY nombre_url ASC";
    $query_permisos = $pdo->prepare($sql_permisos);
    $query_permisos->execute();
    $permisos = $query_permisos->fetchAll(PDO::FETCH_ASSOC);

    // Generar las opciones del select
    foreach ($permisos as $permiso) {
        if (!in_array($permiso['id_permisos'], $assigned_permissions)) {
            $id_permiso = $permiso['id_permisos'];
            $nombre_url = $permiso['nombre_url'];
            echo "<option value=\"$id_permiso\">$nombre_url</option>";
        }
    }
}
