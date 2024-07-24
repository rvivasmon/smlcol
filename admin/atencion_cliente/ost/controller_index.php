<?php 

$query = $pdo->prepare("SELECT stc.*, t_tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_clientes, t_ciudad.ciudad AS nombre_ciudad, t_estado.estadostc AS nombre_estado FROM stc JOIN t_tipo_servicio ON stc.tipo_servicio = t_tipo_servicio.id JOIN t_estado ON stc.estado = t_estado.id JOIN clientes ON stc.cliente = clientes.id JOIN t_ciudad ON stc.ciudad = t_ciudad.id WHERE stc.id = :id_get");

$query->execute( [":id_get" => $id_get]);
$stcs = $query->fetchAll(PDO::FETCH_ASSOC);