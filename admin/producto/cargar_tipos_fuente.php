<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

$query = "SELECT DISTINCT id_car_fuen, tipo_fuente FROM caracteristicas_fuentes WHERE tipo_fuente IS NOT NULL AND tipo_fuente !=''";
$stmt = $pdo->prepare($query);
$stmt->execute();
$tipos = array();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $tipos[] = $row;
}

echo json_encode($tipos);
?>
