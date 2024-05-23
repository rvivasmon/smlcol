<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$ciudad = $_POST['ciudad'];
$departamento = $_POST['departamento'];
$pais = $_POST['pais'];


$sql = "INSERT INTO ciudad (ciudad, dep_prov, pais) VALUES (:ciudad, :departamento, :pais)";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':ciudad', $ciudad);
$sentencia->bindParam(':departamento', $departamento);
$sentencia->bindParam(':pais', $pais);

if($sentencia->execute()){
    session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Good job!',
            'text' => '¡Usuario creado exitosamente!',
            'icon' => 'success'
        );
        header('Location: '.$URL.'admin/ti/ciudades/');
        exit;
}else{
    session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Error',
            'text' => 'Error al introducir la información',
            'icon' => 'error'
        );
        header('Location: '.$URL.'admin/ti/ciudades/create_ciudades.php');
    exit;
}

