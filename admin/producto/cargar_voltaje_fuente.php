<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

$marcaFuente = $_GET['marca_fuente'];
$tipoFuente = $_GET['tipo_fuente'];
$modeloFuente = $_GET['modelo_fuente'];

$query ="SELECT * FROM referencias_fuente 
        WHERE marca_fuente = ? AND tipo_fuente = ? AND id_referencias_fuentes = ? WHERE voltaje_salida IS NOT NULL AND voltaje_salida !=''";

$stmt = $pdo->prepare($query);
$stmt->execute([$marcaFuente, $tipoFuente, $modeloFuente]);
$voltajes = array();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $voltajes[] = $row['voltaje_salida']; // Solo guarda el voltaje_salida
}

echo json_encode($voltajes);
?>
