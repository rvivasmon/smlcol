<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$id_cargo = $_POST['id_cargo'];
$estado_inactivo = '2';

$sql = "UPDATE cargo SET estado = '$estado_inactivo' WHERE id_cargo = :id_cargo";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_cargo', $id_cargo);

if ($sentencia->execute()) {
    echo "Usuario eliminado exitosamente"; // Mensaje de éxito
    header('Location:' .$URL.'admin/ti/cargos/');
} else {
    // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
        echo "Error al eliminar al usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}