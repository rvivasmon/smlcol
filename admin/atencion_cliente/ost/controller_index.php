<?php 

$query = $pdo->prepare("SELECT stc.*, tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_clientes, ciudad.ciudad AS nombre_ciudad, estado.estadostc AS nombre_estado FROM stc JOIN tipo_servicio ON stc.tipo_servicio = tipo_servicio.id JOIN estado ON stc.estado = estado.id JOIN clientes ON stc.cliente = clientes.id JOIN ciudad ON stc.ciudad = ciudad.id WHERE stc.id = :id_get");

$query->execute( [":id_get" => $id_get]);
$stcs = $query->fetchAll(PDO::FETCH_ASSOC);