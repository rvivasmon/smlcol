<?php

$id_cargo_get = $_GET['id'];

$query_cargos = $pdo->prepare("SELECT * FROM cargo WHERE id_cargo = '$id_cargo_get'");

$query_cargos->execute();
$usuarios_roles = $query_cargos->fetchAll(PDO::FETCH_ASSOC);

foreach($usuarios_roles as $usuario_rol){
    $cargo = $usuario_rol['descripcion'];
}

