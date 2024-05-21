<?php

$id_usuario_get = $_GET['id'];

$query_tracking = $pdo->prepare("SELECT * FROM tracking WHERE id = '$id_usuario_get' ");

$query_tracking->execute();
$tracking_datos = $query_tracking->fetchAll(PDO::FETCH_ASSOC);

foreach($tracking_datos as $tracking_dato){
    $id = $tracking_dato['id'];
    $fecha = $tracking_dato['fecha'];
    $op = $tracking_dato['op'];
    $tipo = $tracking_dato['tipo'];
    $descripcion = $tracking_dato['descripcion'];
    $cantidad = $tracking_dato['cantidad'];
    $procesada = $tracking_dato['procesada'];
    $enproduccion = $tracking_dato['en_produccion'];
    $numpl = $tracking_dato['num_pl'];
    $ship = $tracking_dato['ship'];
    $entransito = $tracking_dato['en_transito'];
    $guia = $tracking_dato['guia'];
    $fechaguia = $tracking_dato['fecha_guia'];
    $tipoenvio = $tracking_dato['tipo_envio'];
    $fechallegada = $tracking_dato['fecha_llegada'];
    $fecharecibido = $tracking_dato['fecha_recibido'];
    $obscolombia = $tracking_dato['observaciones_colombia'];
    $obschina = $tracking_dato['observaciones_china'];
}

