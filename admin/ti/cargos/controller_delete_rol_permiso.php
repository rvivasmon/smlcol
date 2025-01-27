<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

// Obtener el ID del rol-permiso
$id_rol_permiso = $_POST['id_rol_permiso'];

// Validar que el ID exista y sea válido
if (!isset($id_rol_permiso) || empty($id_rol_permiso)) {
    $_SESSION['mensaje'] = "Error: ID no válido";
    $_SESSION['icon'] = "error";
    header('Location:' .$URL.'admin/ti/cargos/');
    exit;
}

try {
    // Eliminar el registro
    $sql = "DELETE FROM roles_permisos WHERE id_rol_permiso = :id_rol_permiso";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':id_rol_permiso', $id_rol_permiso);

    if ($sentencia->execute()) {
        $_SESSION['mensaje'] = "Permiso eliminado correctamente";
        $_SESSION['icon'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el permiso";
        $_SESSION['icon'] = "error";
    }

    header('Location:' .$URL.'admin/ti/cargos/');
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    $_SESSION['icon'] = "error";
    header('Location:' .$URL.'admin/ti/cargos/');
}
?>
