<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$bodega = $_POST['bodega'];
$ubicacion = $_POST['ubicacion'];
$descripcion = $_POST['descripcion'];
$ciudad = $_POST['ciudad'];
$pais = $_POST['pais'];

        $sql = "INSERT INTO t_bodegas (nombre_bodega, ubicacion, descripcion, ciudad, pais) VALUES (:bodega, :ubicacion, :descripcion, :pais, :ciudad)";

        $sentencia = $pdo->prepare($sql);

        $sentencia->bindParam(':bodega', $bodega);
        $sentencia->bindParam(':ubicacion', $ubicacion);
        $sentencia->bindParam(':descripcion', $descripcion);
        $sentencia->bindParam(':ciudad', $ciudad);
        $sentencia->bindParam(':pais', $pais);

        $sentencia->execute();
                

            header('Location: ' . $URL . 'admin/administracion/admon/bodegas/');
            exit;
        

