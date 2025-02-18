<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

header('Content-Type: application/json');

if (isset($_GET['id_serial_fuente'])) {
    $id_serial_fuente = $_GET['id_serial_fuente']; // Asegúrate de que el nombre del parámetro coincide

    $query = $pdo->prepare('SELECT cantidad_plena FROM alma_principal WHERE producto = ? AND tipo_producto = 3');
    $query->execute([$id_serial_fuente]);
    $resultado_fuentes = $query->fetch(PDO::FETCH_ASSOC);

    if ($resultado_fuentes) {
        echo json_encode($resultado_fuentes);
    } else {
        echo json_encode(['cantidad_plena' => 0]); // Devolver 0 si no hay resultados
    }
}
