<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$id_tipo_modulo = $_GET['id_tipo_modulo'];

$query = $pdo->prepare('SELECT id_car_mod, pitch FROM caracteristicas_modulos WHERE modelo_modulo = :id_tipo_modulo');
$query->execute(['id_tipo_modulo' => $id_tipo_modulo]);
$pitches = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($pitches);
?>
