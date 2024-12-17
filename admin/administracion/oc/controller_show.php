<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if (isset($_GET['id'])) {
    $id_get = $_GET['id'];

    // Consulta para obtener los detalles del OC
    $query_oc = $pdo->prepare("SELECT * FROM oc WHERE oc.id = :id");
    $query_oc->bindParam(':id', $id_get, PDO::PARAM_INT);
    $query_oc->execute();
    $oces = $query_oc->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para obtener los ítems asociados al OC
    $query_items = $pdo->prepare("SELECT * FROM items_oc WHERE id_oc = :id_oc");
    $query_items->bindParam(':id_oc', $id_get, PDO::PARAM_INT);
    $query_items->execute();
    $items = $query_items->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los datos en formato JSON
    echo json_encode([
        'oc' => $oces,
        'items' => $items
    ]);
}

