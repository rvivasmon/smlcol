<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../..7layout/admin/datos_sesion_user.php');

$cargo = $_POST['cargo'];


$sql = "INSERT INTO cargo (id_cargo, descripcion) VALUES (:id_cargo, :descripcion)";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_cargo', $id_cargo);
$sentencia->bindParam(':descripcion', $cargo);

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


