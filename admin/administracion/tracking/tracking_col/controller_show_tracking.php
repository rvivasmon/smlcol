<?php

$id_usuario_get = $_GET['id'];

$query_tracking = $pdo->prepare("SELECT * FROM tracking WHERE id = '$id_usuario_get' ");

$query_tracking->execute();
$tracking_datos = $query_tracking->fetchAll(PDO::FETCH_ASSOC);

foreach($tracking_datos as $tracking_dato){
    $id = $tracking_dato['id'];
    $fecha = $tracking_dato['date'];
    $op = $tracking_dato['origin'];
    $tipo = $tracking_dato['type'];
    $descripcion = $tracking_dato['category'];
    $cantidad = $tracking_dato['quantitly'];
    $procesada = $tracking_dato['status'];
    $enproduccion = $tracking_dato['en_produccion'];
    $obscolombia = $tracking_dato['observaciones_colombia'];

}

