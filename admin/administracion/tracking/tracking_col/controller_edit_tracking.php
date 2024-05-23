<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../llayout/admin/datos_sesion_user.php');

$id = $_POST['id'];
$date1 = $_POST['date'];
$origin = $_POST['origin'];
$tipoproducto = $_POST['tipoproducto'];
$descripcion = $_POST['descripcion'];
$quantitly = $_POST['quantitly'];
$obscolombia = $_POST['obscolombia'];


$sentencia = $pdo->prepare("UPDATE tracking 
SET 
    date = :date1, 
    origin = :origin, 
    type = :tipoproducto,
    category = :descripcion,
    quantitly = :quantitly,
    observaciones_colombia = :obscolombia  
    WHERE 
    id = :id");


$sentencia->bindParam(':id', $id);
$sentencia->bindParam(':date1', $date1);
$sentencia->bindParam(':origin', $origin);
$sentencia->bindParam(':tipoproducto', $tipoproducto);
$sentencia->bindParam(':descripcion', $descripcion);
$sentencia->bindParam(':quantitly', $quantitly);
$sentencia->bindParam(':obscolombia', $obscolombia);


if ($sentencia->execute()) {
  echo "Usuario actualizado exitosamente"; // Mensaje de éxito
  header('Location:' .$URL.'admin/administracion/tracking/tracking_col/index_tracking.php');
} else {
  // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
        echo "Error al actualizar el usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}



