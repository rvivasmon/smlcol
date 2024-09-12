<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

$query = "SELECT id_car_fuen, marca_fuente FROM caracteristicas_fuentes WHERE marca_fuente IS NOT NULL AND marca_fuente !=''";
$stmt = $pdo->prepare($query);
$stmt->execute();
$marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($marcas);
?>
