<?php 

$email_sesion = $_SESSION['sesion_email'];
$query_usuario = $pdo->prepare('SELECT usuarios.*, cargo.descripcion AS nombre_cargo, estado.estado_general AS nombre_estado FROM usuarios JOIN cargo ON usuarios.id_cargo = cargo.id_cargo JOIN estado ON usuarios.estado = estado.id WHERE usuarios.email = :email_sesion AND usuarios.estado = "1"');

$query_usuario->bindParam(':email_sesion', $email_sesion);
$query_usuario->execute();

$query_usuarios = $query_usuario->fetchAll(PDO::FETCH_ASSOC);
foreach ($query_usuarios as $sesion_usuario){
    $sesion_id_usuario = $sesion_usuario['id'];
    $sesion_nombre = $sesion_usuario['nombre'];
    $sesion_email = $sesion_usuario['email'];
    $sesion_usuariocargo = $sesion_usuario['usuario'];
    $sesion_password = $sesion_usuario['contraseña'];
    $sesion_cargo = $sesion_usuario['nombre_cargo'];
    $sesion_estado = $sesion_usuario['nombre_estado'];

}