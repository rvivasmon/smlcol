<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$usuario = $_POST['usuario'];
$id_cargo = $_POST['id_cargo'];
$id_usuario = $_POST['id_usuario'];
$id_estado = $_POST['id_estado'];
$pass = $_POST['pass'];

// Verificar si el checkbox "Reestablecer Contraseña" está marcado
$primera_vez = isset($_POST['reset_password']) ? 1 : null;

// Verificar si se ha ingresado una nueva contraseña
if (!empty($pass)) {

    // Encriptar Pass
    $passwordencriptada = password_hash($pass, PASSWORD_DEFAULT);

    // Construir la consulta SQL
    $sql = "UPDATE usuarios 
            SET nombre = :nombre, 
                email = :email, 
                usuario = :usuario, 
                id_cargo = :id_cargo, 
                estado = :id_estado, 
                contraseña = :passwordencriptada" 
                . ($primera_vez !== null ? ", primera_vez = :primera_vez" : "") . 
            " WHERE id = :id_usuario";

    // Preparar la consulta
    $sentencia = $pdo->prepare($sql);

    // Asignar los parámetros
    $sentencia->bindParam(':nombre', $nombre);
    $sentencia->bindParam(':email', $email);
    $sentencia->bindParam(':usuario', $usuario);
    $sentencia->bindParam(':id_cargo', $id_cargo);
    $sentencia->bindParam(':id_estado', $id_estado);
    $sentencia->bindParam(':passwordencriptada', $passwordencriptada);

    if ($primera_vez !== null) {
        $sentencia->bindParam(':primera_vez', $primera_vez);
    }
    $sentencia->bindParam(':id_usuario', $id_usuario);

} else {
    // La contraseña no ha sido ingresada, no la actualizas ni el estado de primera_vez
    $sql = "UPDATE usuarios 
            SET nombre = :nombre, 
                email = :email, 
                usuario = :usuario, 
                id_cargo = :id_cargo, 
                estado = :id_estado" 
                . ($primera_vez !== null ? ", primera_vez = :primera_vez" : "") . 
            " WHERE id = :id_usuario";

    // Preparar la consulta
    $sentencia = $pdo->prepare($sql);

    // Asignar los parámetros 
    $sentencia->bindParam(':nombre', $nombre);
    $sentencia->bindParam(':email', $email);
    $sentencia->bindParam(':usuario', $usuario);
    $sentencia->bindParam(':id_cargo', $id_cargo);
    $sentencia->bindParam(':id_estado', $id_estado);

    if ($primera_vez !== null) {
        $sentencia->bindParam(':primera_vez', $primera_vez);
    }
    $sentencia->bindParam(':id_usuario', $id_usuario);
}

// Ejecutar la consulta
if ($sentencia->execute()) {
    echo "Usuario actualizado exitosamente"; // Mensaje de éxito
    header('Location:' .$URL.'admin/ti/usuarios/');
    exit; // Asegurar la redirección
} else {
    // Manejar los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
    echo "Error al actualizar el usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}

?>
