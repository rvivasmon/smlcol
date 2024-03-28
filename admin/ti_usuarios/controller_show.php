<?php

$id_usuario_get = $_GET['id'];

$query_usuarios = $pdo->prepare("SELECT usuarios.*, cargo.descripcion AS nombre_cargo, estado.estado_general as estado_general FROM usuarios JOIN cargo ON usuarios.id_cargo = cargo.id_cargo JOIN estado ON usuarios.estado = estado.id WHERE usuarios.id = '$id_usuario_get' ");

$query_usuarios->execute();
$usuarios_datos = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);

foreach($usuarios_datos as $usuario_dato){
    $nombre = $usuario_dato['nombre'];
    $email = $usuario_dato['email'];
    $user = $usuario_dato['usuario'];
    $cargo = $usuario_dato['nombre_cargo'];
    $estado = $usuario_dato['estado_general'];
}

