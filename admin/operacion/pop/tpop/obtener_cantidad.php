<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

header('Content-Type: application/json');

if (isset($_GET['id_serial'])) {
    $id_serial = $_GET['id_serial']; // Asegúrate de que el nombre del parámetro coincide

    $query = $pdo->prepare('SELECT cantidad_plena FROM alma_smartled WHERE producto = ? AND tipo_producto = 1');
    $query->execute([$id_serial]);
    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo json_encode($resultado);
    } else {
        echo json_encode(['cantidad_plena' => 0]); // Devolver 0 si no hay resultados
    }
}
