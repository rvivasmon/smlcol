<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

header('Content-Type: application/json');

if (isset($_GET['id_serial_reciving'])) {
    $id_serial_reciving = $_GET['id_serial_reciving']; // Asegúrate de que el nombre del parámetro coincide

    $query = $pdo->prepare('SELECT cantidad_plena FROM alma_principal WHERE producto = ? AND tipo_producto = 2');
    $query->execute([$id_serial_reciving]);
    $resultado_reciving = $query->fetch(PDO::FETCH_ASSOC);

    if ($resultado_reciving) {
        echo json_encode($resultado_reciving);
    } else {
        echo json_encode(['cantidad_plena' => 0]); // Devolver 0 si no hay resultados
    }
}
