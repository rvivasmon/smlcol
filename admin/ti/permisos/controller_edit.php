<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$id_permisos = $_POST['id_permisos'];
$nombre_url = $_POST['nombre_url'];
$url = $_POST['url'];


$sql = "UPDATE permisos SET nombre_url = :nombre_url, url = :url, id_permisos = :id_permisos WHERE id_permisos = :id_permisos";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_permisos', $id_permisos);
$sentencia->bindParam(':nombre_url', $nombre_url);
$sentencia->bindParam(':url', $url);

if ($sentencia->execute()) {
  echo "Usuario actualizado exitosamente"; // Mensaje de éxito
  header('Location:' .$URL.'admin/ti/permisos/');
} else {
  // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
        echo "Error al actualizar el usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}



