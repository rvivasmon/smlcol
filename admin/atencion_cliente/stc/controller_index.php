<?php 

$query = $pdo->prepare("SELECT stc.*, t_tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_cliente, ciudad.ciudad AS nombre_ciudad, t_estado.estadostc AS nombre_estado FROM stc JOIN t_tipo_servicio ON stc.tipo_servicio = t_tipo_servicio.id JOIN clientes ON stc.cliente = clientes.id JOIN ciudad ON stc.ciudad = ciudad.id JOIN t_estado ON stc.estado = t_estado.id");

$query->execute();
$stcs = $query->fetchAll(PDO::FETCH_ASSOC);