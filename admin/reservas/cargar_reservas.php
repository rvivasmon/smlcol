<?php

include('../../app/config/config.php');
include('../../app/config/conexion.php');

$sql = "SELECT title, start_date AS start, end_date AS end, hora_evento, color, recordatorio FROM eventos ";

$query = $pdo->prepare($sql);
$query->execute();

$resultado = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($resultado);