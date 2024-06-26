<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$id_usuario = $_POST['id_usuario'];
$estado_inactivo = '2';

$sql = "UPDATE stc SET estado_ticket = '$estado_inactivo' WHERE id = :id_usuario";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_usuario', $id_usuario);

if ($sentencia->execute()) {
    echo "Usuario eliminado exitosamente"; // Mensaje de éxito
    header('Location:' .$URL.'admin/atencion_cliente/ost');
} else {
    // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
          echo "Error al eliminar al usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}


