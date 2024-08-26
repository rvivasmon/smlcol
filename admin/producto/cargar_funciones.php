<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');


$query = "SELECT * FROM caracteristicas_control WHERE funcion_control IS NOT NULL AND funcion_control !=''";
$stmt = $pdo->prepare($query);
$stmt->execute();
$funciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($funciones);
?>
