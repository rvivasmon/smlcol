<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

header('Content-Type: application/json');

if (isset($_GET['id_serial_control'])) {
    $id_serial_control = $_GET['id_serial_control']; // Asegúrate de que el nombre del parámetro coincide

    $query = $pdo->prepare('SELECT cantidad_plena FROM alma_principal WHERE producto = ? AND tipo_producto = 2');
    $query->execute([$id_serial_control]);
    $resultado_control = $query->fetch(PDO::FETCH_ASSOC);

    if ($resultado_control) {
        echo json_encode($resultado_control);
    } else {
        echo json_encode(['cantidad_plena' => 0]); // Devolver 0 si no hay resultados
    }
}
