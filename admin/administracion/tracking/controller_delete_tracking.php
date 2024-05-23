<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$id_usuario = $_POST['id'];
$estado_inactivo = '2';

$sql = "UPDATE tracking SET estado = :estado_inactivo WHERE id = :id_usuario";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_usuario', $id_usuario);
$sentencia->bindParam(':estado_inactivo', $estado_inactivo);

if ($sentencia->execute()) {
    echo "Usuario eliminado exitosamente"; // Mensaje de éxito
    header('Location:' .$URL.'admin/administracion/tracking/index_tracking.php');
} else {
    // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
        echo "Error al eliminar al usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}


