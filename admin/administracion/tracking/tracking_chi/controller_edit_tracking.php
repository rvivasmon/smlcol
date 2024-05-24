<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$id = $_POST['id'];
$date_finished = $_POST['date_finished'];
$num_envoys = $_POST['num_envoys'];
$ship = $_POST['ship'];
$guia = $_POST['guia'];
$fecha_guia = $_POST['fecha_guia'];
$obschina = $_POST['obschina'];
$finished = $_POST['finished'];


$sentencia = $pdo->prepare("UPDATE tracking 
SET 
    date_finished = :date_finished, 
    num_envoys = :num_envoys, 
    ship = :ship,
    guia = :guia,
    fecha_guia = :fecha_guia,
    observaciones_china = :obschina,
    finished = :finished
    WHERE 
    id = :id");


$sentencia->bindParam(':id', $id);
$sentencia->bindParam(':date_finished', $date_finished);
$sentencia->bindParam(':num_envoys', $num_envoys);
$sentencia->bindParam(':ship', $ship);
$sentencia->bindParam(':guia', $guia);
$sentencia->bindParam(':fecha_guia', $fecha_guia);
$sentencia->bindParam(':obschina', $obschina);
$sentencia->bindParam(':finished', $finished);


if ($sentencia->execute()) {
  echo "Usuario actualizado exitosamente"; // Mensaje de éxito
  header('Location:' .$URL.'admin/administracion/tracking/tracking_chi/index_tracking.php');
} else {
  // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
        echo "Error al actualizar el usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}



