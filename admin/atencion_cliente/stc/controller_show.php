<?php

$id_stc_get = $_GET['id'];

$query_stc = $pdo->prepare("SELECT stc.*, tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_cliente, ciudad.ciudad AS nombre_ciudad, estado.estadostc AS nombre_estado FROM stc JOIN tipo_servicio ON stc.tipo_servicio = tipo_servicio.id JOIN clientes ON stc.cliente = clientes.id JOIN ciudad ON stc.ciudad = ciudad.id JOIN estado ON stc.estado = estado.id  WHERE stc.id = '$id_stc_get'");

$query_stc->execute();
$datos_stcs = $query_stc->fetchAll(PDO::FETCH_ASSOC);
foreach ($datos_stcs as $dato_stc){
    $id = $dato_stc['id'];
    $id_stc = $dato_stc['id_stc'];
    $fecha_ingreso = $dato_stc['fecha_ingreso'];
    $medio_ingreso = $dato_stc['medio_ingreso'];
    $ticket_externo = $dato_stc['ticket_externo'];
    $servicio = $dato_stc['nombre_servicio'];
    $id_producto = $dato_stc['id_producto'];
    $falla = $dato_stc['falla'];
    $observacion = $dato_stc['observacion'];
    $cliente = $dato_stc['nombre_cliente'];
    $ciudad = $dato_stc['nombre_ciudad'];
    $proyecto = $dato_stc['proyecto'];
    $estado = $dato_stc['nombre_estado'];
    $persona_contacto = $dato_stc['persona_contacto'];
    $medio_contacto = $dato_stc['email_contacto'];
}

