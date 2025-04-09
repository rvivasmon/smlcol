<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids = explode(',', $_POST['tracking_ids']); // Convertir string en array
    $status = $_POST['status'];
    $date_status = date('Y-m-d H:i:s'); // Fecha y hora actual

    foreach ($ids as $id) {
        $query = $pdo->prepare("UPDATE tracking SET status = :status, date_status = :date_status WHERE id = :id");
        $query->execute([
            'status' => $status,
            'date_status' => $date_status,
            'id' => $id
        ]);
    }

    echo "Estado actualizado con éxito.";
}


?>