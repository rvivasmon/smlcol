<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$modelo_id = $_GET['modelo_id'];

// Obtener pitch_dispo de la base de datos
$query = $pdo->prepare("SELECT DISTINCT pitch, medida_x, medida_y FROM caracteristicas_modulos WHERE modelo_modulo = :modelo_id ORDER BY pitch ASC");
$query->execute(['modelo_id' => $modelo_id]);
$pitches = $query->fetchAll(PDO::FETCH_ASSOC);

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($pitches);
?>
