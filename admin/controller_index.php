<?php 

$query_usuarios = $pdo->prepare("SELECT usuarios.*, cargo.descripcion AS nombre_cargo, t_estado.estado_general as estado_general FROM usuarios JOIN cargo ON usuarios.id_cargo = cargo.id_cargo JOIN t_estado ON usuarios.estado = t_estado.id");
$query_usuarios->execute();
$usuarios_datos = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);

$query_solicitudes = $pdo->prepare("SELECT codigo_generado FROM tracking WHERE status = 2 AND en_produccion IS NULL");
$query_solicitudes->execute();
$solicitudes_datos = $query_solicitudes->fetchAll(PDO::FETCH_ASSOC);

$query_terminar_solicitudes = $pdo->prepare("SELECT codigo_generado FROM tracking WHERE en_produccion = 1 AND finished = 0");
$query_terminar_solicitudes->execute();
$terminar_solicitudes_datos = $query_terminar_solicitudes->fetchAll(PDO::FETCH_ASSOC);

$query_enviars_solicitudes = $pdo->prepare("SELECT codigo_generado FROM tracking WHERE finished = 1 AND enviar = 0");
$query_enviars_solicitudes->execute();
$enviars_datos = $query_enviars_solicitudes->fetchAll(PDO::FETCH_ASSOC);

