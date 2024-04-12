<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');


$id_rol = $_POST['descripcioncargo'];
$id_get = $_GET['id'];

$sql = "UPDATE cargo SET descripcion = :id_rol WHERE id_cargo = :id_get";


$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_rol', $id_rol);
$sentencia->bindParam(':id_get', $id_get);

if ($sentencia->execute()) {
  echo "Usuario actualizado exitosamente"; // Mensaje de éxito
  header('Location:' .$URL.'admin/ti_usuarios/');
} else {
  // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
        echo "Error al actualizar el usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}
