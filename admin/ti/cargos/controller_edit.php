<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$rol = $_POST['rol'];
$id_cargo = $_POST['id_cargo'];

$sql = "UPDATE cargo SET descripcion = :rol, id_cargo = :id_cargo WHERE id_cargo = :id_cargo";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_cargo', $id_cargo);
$sentencia->bindParam(':rol', $rol);

if ($sentencia->execute()) {
  echo "Usuario actualizado exitosamente"; // Mensaje de éxito
  header('Location:' .$URL.'admin/ti/cargos/');
} else {
  // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
        echo "Error al actualizar el usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}



