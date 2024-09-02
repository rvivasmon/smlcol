<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');


    $id_oc = $_POST['id_oc'];  // ID del OC al que se va a asociar el ítem
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $instalacion = $_POST['instalacion'];

    // Preparar la consulta de inserción
    $query_insert_item = $pdo->prepare("INSERT INTO tabla_items_oc (id_oc, descripcion, cantidad, instalacion) VALUES (:id_oc, :descripcion, :cantidad, :instalacion)");

    // Vincular los parámetros
    $query_insert_item->bindParam(':id_oc', $id_oc, PDO::PARAM_INT);
    $query_insert_item->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
    $query_insert_item->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    $query_insert_item->bindParam(':instalacion', $instalacion, PDO::PARAM_STR);

    // Ejecutar la consulta e intentar redirigir si es exitosa
     $query_insert_item->execute();
        header("Location: " . $URL . "admin/nueva_tarea_8-7-24/index_oc.php");
        
    