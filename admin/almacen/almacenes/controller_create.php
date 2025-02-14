<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$almacen_grupo = $_POST['almacen_grupo'];
$siglas_grupo = $_POST['siglas_grupo'];


$sql = "INSERT INTO almacenes_grupo (almacenes, siglas) VALUES (:almacen_grupo, :siglas_grupo)";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':almacen_grupo', $almacen_grupo);
$sentencia->bindParam(':siglas_grupo', $siglas_grupo);

if($sentencia->execute()){
    session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Good job!',
            'text' => '¡Usuario creado exitosamente!',
            'icon' => 'success'
        );
        header('Location: '.$URL.'admin/ti/cargos/index.php');
        exit;
}else{
    session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Error',
            'text' => 'Error al introducir la información',
            'icon' => 'error'
        );
        header('Location: '.$URL.'admin/ti/cargos/create.php');
    exit;
}


