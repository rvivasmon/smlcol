<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$nombre_url = $_POST['nombre_url'];
$url = $_POST['url'];
$estado_permisos = '1';

$sql = "INSERT INTO t_permisos (nombre_url, url, estado) VALUES (:nombre_url, :url, :estado)";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':nombre_url', $nombre_url);
$sentencia->bindParam(':url', $url);
$sentencia->bindParam(':estado', $estado_permisos);

if($sentencia->execute()){
    session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Good job!',
            'text' => '¡Permiso creado exitosamente!',
            'icon' => 'success'
        );
        header('Location: '.$URL.'admin/ti/permisos/create.php');
        exit;
}else{
    session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Error',
            'text' => 'Error al introducir la información',
            'icon' => 'error'
        );
        header('Location: '.$URL.'admin/ti/permisos/create.php');
    exit;
}



