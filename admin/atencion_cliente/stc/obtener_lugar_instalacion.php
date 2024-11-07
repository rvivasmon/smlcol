<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

header('Content-Type: application/json');

if (isset($_GET['cliente_id']) && isset($_GET['ciudad_id'])) {
    $cliente_id = $_GET['cliente_id'];
    $ciudad_id = $_GET['ciudad_id'];

    // Consulta para obtener los proyectos que coinciden con el cliente y la ciudad
    $query = $pdo->prepare('SELECT id, lugar_instalacion FROM oc_admin WHERE cliente = :cliente_id AND ciudad = :ciudad_id');
    $query->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $query->bindParam(':ciudad_id', $ciudad_id, PDO::PARAM_INT);
    $query->execute();

    $proyectos = $query->fetchAll(PDO::FETCH_ASSOC);

    if (empty($proyectos)) {
        echo json_encode(['mensaje' => 'No hay lugares disponibles']);
    } else {
        echo json_encode($proyectos);
    }
}
?>
