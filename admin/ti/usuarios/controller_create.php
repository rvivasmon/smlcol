<?php 

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$usuario = $_POST['usuario'];
$id_cargo = $_POST['id_cargo'];
$password = $_POST['password'];
$verificar_password = $_POST['verificar_password'];

$passwordencriptada = password_hash($password, PASSWORD_DEFAULT);

if($password == $verificar_password) {
    //echo "Contraseñas Correctas";

$sql = "INSERT INTO usuarios (nombre, email, usuario, contraseña, id_cargo) VALUES (:nombre, :email, :usuario, :password, :id_cargo)";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':nombre', $nombre);
$sentencia->bindParam(':email', $email);
$sentencia->bindParam(':usuario', $usuario);
$sentencia->bindParam(':password', $passwordencriptada);
$sentencia->bindParam(':id_cargo', $id_cargo);

if($sentencia->execute()){
    session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Good job!',
            'text' => '¡Usuario creado exitosamente!',
            'icon' => 'success'
        );
        header('Location: '.$URL.'admin/ti_usuarios/');
        exit;
}else{
    session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Error',
            'text' => 'Error al introducir la información',
            'icon' => 'error'
        );
        header('Location: '.$URL.'admin/ti_usuarios/create.php');
    exit;
}
}else{

    session_start();
    $_SESSION['Mensajes'] = array(
        'title' => 'Error',
        'text' => 'Las contraseñas no coinciden',
        'icon' => 'error'
    );
    header('Location: '.$URL.'admin/ti_usuarios/create.php'); // Redirigir de vuelta a la página anterior
    exit;
}


