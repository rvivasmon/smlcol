<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');


$id_rol_permiso = $_POST['id_rol_permiso'];

$sql = "DELETE FROM roles_permisos WHERE id_rol_permiso = :id_rol_permiso";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_rol_permiso', $id_rol_permiso);

if ($sentencia->execute()) {
    $_SESSION['mensaje'] = "Se elimino el permiso de la manera correcta en la base de datos";
    $_SESSION['icon'] = "success";
    header('Location:' .$URL.'admin/ti/cargos/');
} else {
    session_start();
    $_SESSION['mensaje'] = "Error, no se pudo eliminar en la base de dats, comuniquese con el administrador";
    $_SESSION[''] = "error";
    header('Location:' .$URL.'admin/ti/cargos/');
} 