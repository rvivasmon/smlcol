<?php 

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$usuario = $_POST['usuario'];
$id_cargo = $_POST['id_cargo'];
$id_usuario = $_POST['id_usuario'];
$id_estado = $_POST['id_estado'];


$sql = "UPDATE usuarios SET nombre = :nombre, email = :email, usuario = :usuario, id_cargo = :id_cargo, estado = :id_estado WHERE id = :id_usuario";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':nombre', $nombre);
$sentencia->bindParam(':email', $email);
$sentencia->bindParam(':usuario', $usuario);
$sentencia->bindParam(':id_cargo', $id_cargo);
$sentencia->bindParam(':id_estado', $id_estado);
$sentencia->bindParam(':id_usuario', $id_usuario);

if ($sentencia->execute()) {
  echo "Usuario actualizado exitosamente"; // Mensaje de éxito
  header('Location:' .$URL.'admin/ti_usuarios/');
} else {
  // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
        echo "Error al actualizar el usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}



