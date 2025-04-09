<?php

$id_usuario_get = $_GET['id'];

$query_tracking = $pdo->prepare("SELECT * FROM tracking WHERE id = '$id_usuario_get' ");

$query_tracking->execute();
$tracking_datos = $query_tracking->fetchAll(PDO::FETCH_ASSOC);

foreach($tracking_datos as $tracking_dato){
    $id = $tracking_dato['id'];
    $date_finished = $tracking_dato['date_finished'];
    $num_envoys = $tracking_dato['num_envoys'];
    $ship = $tracking_dato['ship'];
    $guia = $tracking_dato['guia'];
    $fecha_guia = $tracking_dato['fecha_guia'];
    $obschina = $tracking_dato['observaciones_china'];

}

