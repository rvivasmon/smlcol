<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

$query = "SELECT id_car_ctrl, marca_control FROM caracteristicas_control WHERE marca_control IS NOT NULL AND marca_control !=''" ;
$result = $pdo->query($query);
$marcas = $result->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($marcas);
?>