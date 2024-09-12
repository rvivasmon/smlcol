<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

$marca = $_GET['marca'];
$funcion = $_GET['funcion'];

$query = "SELECT id_referencia, referencia FROM referencias_control WHERE marca = :marca AND funcion = :funcion AND referencia IS NOT NULL AND referencia !=''";
$stmt = $pdo->prepare($query);
$stmt->execute(['marca' => $marca, 'funcion' => $funcion]);
$referencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($referencias);
?>
