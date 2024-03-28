<?php 

$query = $pdo->prepare("SELECT stc.*, tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_cliente, ciudad.ciudad AS nombre_ciudad, estado.estadostc AS nombre_estado FROM stc JOIN tipo_servicio ON stc.tipo_servicio = tipo_servicio.id JOIN clientes ON stc.cliente = clientes.id JOIN ciudad ON stc.ciudad = ciudad.id JOIN estado ON stc.estado = estado.id");

$query->execute();
$stcs = $query->fetchAll(PDO::FETCH_ASSOC);