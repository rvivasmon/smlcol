<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

$bodega = $_POST['bodega'];


        $sql = "INSERT INTO t_sub_almacen (sub_almacen) VALUES (:bodega)";

        $sentencia = $pdo->prepare($sql);

        $sentencia->bindParam(':bodega', $bodega);

        $sentencia->execute();
                

            header('Location: ' . $URL . 'admin/administracion/admon/almacenes/sub_almacenes');
            exit;