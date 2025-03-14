<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$id_movimiento_diario = $_POST['id_movimiento_diario']; 
$observacion = $_POST['observacion']; 

// Consulta para actualizar solo el campo observacion
$sql = "UPDATE movimiento_diario SET observaciones = :observacion WHERE id_movimiento_diario = :id_movimiento_diario";

// Preparar la consulta
$sentencia = $pdo->prepare($sql);

// Asignar los parámetros 
$sentencia->bindParam(':observacion', $observacion);
$sentencia->bindParam(':id_movimiento_diario', $id_movimiento_diario);

// Ejecutar la consulta
if ($sentencia->execute()) {
    echo "Observación actualizada exitosamente"; 
    header('Location:' .$URL.'admin/almacen/stock/smartled'); // Redireccionar tras éxito
    exit;
} else {
    // Manejo de errores
    $errorInfo = $sentencia->errorInfo();
    echo "Error al actualizar la observación: " . $errorInfo[2]; 
}

?>
