<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$nombre = $_POST['nombre'];
$docu = $_POST['doc_ident'];
$usuario = $_POST['usuario'];
$ciudad = $_POST['ciudad'];
$estado = $_POST['estado_general'];



$sql = "INSERT INTO tecnicos (nombre, docident, usuario, ciudad, estado_general) VALUES (:nombre, :docu, :usuario, :ciudad, :estado)";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':nombre', $nombre);
$sentencia->bindParam(':docu', $docu);
$sentencia->bindParam(':usuario', $usuario);
$sentencia->bindParam(':ciudad', $ciudad);
$sentencia->bindParam(':estado', $estado);

if($sentencia->execute()){
    session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Good job!',
            'text' => '¡Usuario creado exitosamente!',
            'icon' => 'success'
        );
        header('Location: '.$URL.'admin/Administracion/tecnicos/index_tecnicos.php');
        exit;
}else{
    session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Error',
            'text' => 'Error al introducir la información',
            'icon' => 'error'
        );
        header('Location: '.$URL.'admin/Administracion/tecnicos/create_tecnicos.php');
    exit;
}



