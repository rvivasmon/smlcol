<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener datos de pre_proyecto
    $query = $pdo->prepare('SELECT * FROM pre_proyecto WHERE id_preproyec = :id');
    $query->execute([':id' => $id]);
    $pre_proyecto = $query->fetch(PDO::FETCH_ASSOC);

    // Obtener datos de item_preproyecto
    $query_items = $pdo->prepare('SELECT * FROM item_preproyecto WHERE id_preproyec = :id');
    $query_items->execute([':id' => $id]);
    $items = $query_items->fetchAll(PDO::FETCH_ASSOC);

    // Combinar los datos y enviarlos como respuesta JSON
    $response = [
        'pre_proyecto' => $pre_proyecto,
        'items' => $items
    ];

    echo json_encode($response);
}
?>
