<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$id_permisos = $_POST['id_permisos'];
$nombre_url = $_POST['nombre_url'];
$url = $_POST['url'];
$estado_inactivo = '2';

$sql = "UPDATE permisos SET estado = '$estado_inactivo' WHERE id_permisos = :id_permisos";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_permisos', $id_permisos);


if ($sentencia->execute()) {
    echo "Usuario eliminado exitosamente"; // Mensaje de éxito
    header('Location:' .$URL.'admin/ti/permisos/');
} else {
    // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
        echo "Error al eliminar al usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}