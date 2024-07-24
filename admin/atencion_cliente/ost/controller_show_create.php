<?php

$id_stc_get = $_GET['id'];

$query_ost = $pdo->prepare("SELECT ost.*, t_tipo_servicio.servicio_ost AS nombre_servicio, t_estado.estadoost AS nombre_estado FROM ost JOIN t_tipo_servicio ON ost_tipo_servicio = t_tipo_servicio.id JOIN t_estado ON ost_estado = t_estado.id  WHERE ost.id = '$id_stc_get'");

$query_ost->execute();
$datos_osts = $query_ost->fetchAll(PDO::FETCH_ASSOC);
foreach ($datos_osts as $dato_ost){
    $id = $dato_ost['id'];
    $id_ost = $dato_ost['id_ost'];
    $fecha_ingreso = $dato_ost['fecha_ost'];
    $medio_ingreso = $dato_ost['medio_ingreso'];
    $ticket_externo = $dato_ost['ticket_externo'];
    $servicio = $dato_ost['nombre_servicio'];
    $id_producto = $dato_ost['id_producto'];
    $falla = $dato_ost['falla'];
    $observacion = $dato_ost['observacion'];
    $cliente = $dato_ost['cliente'];
    $ciudad = $dato_ost['ciudad'];
    $proyecto = $dato_ost['proyecto'];
    $estado = $dato_ost['nombre_estado'];
    $persona_contacto = $dato_ost['persona_contacto'];
    $medio_contacto = $dato_ost['email_contacto'];
    $num_ost = $dato_ost['id_ost'];
}

