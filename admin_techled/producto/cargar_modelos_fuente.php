<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

$idCarFuen = $_GET['id_car_fuen'];
$tipoFuente = $_GET['tipo_fuente'];
$query = "SELECT id_referencias_fuentes, marca_fuente, tipo_fuente, modelo_fuente FROM referencias_fuente WHERE marca_fuente = ? AND tipo_fuente = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$idCarFuen, $tipoFuente]);
$modelos = array();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $modelos[] = $row;
}

echo json_encode($modelos);
?>
