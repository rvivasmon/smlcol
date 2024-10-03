<?php
include('../../../../app/config/config.php'); // Incluir configuración de la base de datos
include('../../../../app/config/conexion.php'); // Incluir conexión a la base de datos

// Obtener el valor de pixel_max del parámetro de consulta
$pixelMax = isset($_GET['pixel_max']) ? intval($_GET['pixel_max']) : 0;

// Crear la consulta SQL
$sql = "SELECT id_referencia, referencia, pixel_max FROM referencias_control WHERE funcion IN (6, 9, 10, 12, 16) AND pixel_max >= :pixelMax ORDER BY pixel_max ASC";

// Preparar y ejecutar la consulta
$stmt = $pdo->prepare($sql);
$stmt->execute([':pixelMax' => $pixelMax]);

// Obtener los resultados
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si no se encontraron resultados, buscar el valor más cercano por debajo de pixelMax
if (empty($results)) {
    $sql = "SELECT id_referencia, referencia, pixel_max FROM referencias_control WHERE funcion IN (6, 9, 10, 12, 16) AND pixel_max < :pixelMax ORDER BY pixel_max DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':pixelMax' => $pixelMax]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Devolver los resultados en formato JSON
header('Content-Type: application/json');
echo json_encode($results);
