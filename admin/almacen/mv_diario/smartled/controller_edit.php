<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$id_movimiento = $_POST['id_movimiento1'];
$op_destino = $_POST['op_destino'];
$observacion = $_POST['observacion'];

$sql = "UPDATE movimiento_diario SET op = :op_destino, observaciones = :observacion WHERE id_movimiento_diario = :id_movimiento";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_movimiento', $id_movimiento);
$sentencia->bindParam(':op_destino', $op_destino);
$sentencia->bindParam(':observacion', $observacion);

if ($sentencia->execute()) {
    echo "Movimiento actualizado exitosamente."; // Mensaje de texto
    header('Location: ' . $URL . 'admin/almacen/mv_diario/index.php');
} else {
    // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
        echo "Error al actualizar el movimiento: " . $errorInfo[2]; // Mensaje de error con detalles
}
?>
