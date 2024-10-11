<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

$id_uso = $_GET['id_uso'];

$stmt = $pdo->prepare("SELECT id_uso, consumo_wats, consumo_promedio FROM t_uso_productos WHERE id_uso = ?");
$stmt->execute([$id_uso]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($data);
?>
