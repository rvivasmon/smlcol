<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_tracking'];
    $fecha_actual = date('Y-m-d');

    $query = $pdo->prepare("UPDATE tracking SET recibido = 2, fecha_recibido = :fecha WHERE id = :id");
    $query->bindParam(':fecha', $fecha_actual);
    $query->bindParam(':id', $id);

    if ($query->execute()) {
        echo "ok";
    } else {
        http_response_code(500);
        echo "Error al actualizar";
    }
}
?>
