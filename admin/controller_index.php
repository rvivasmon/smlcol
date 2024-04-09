<?php 

$query_usuarios = $pdo->prepare("SELECT usuarios.*, cargo.descripcion AS nombre_cargo, estado.estado_general as estado_general FROM usuarios JOIN cargo ON usuarios.id_cargo = cargo.id_cargo JOIN estado ON usuarios.estado = estado.id");

$query_usuarios->execute();
$usuarios_datos = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);