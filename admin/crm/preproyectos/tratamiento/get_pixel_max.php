<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

if (isset($_GET['controladora_id'])) {
    $controladoraId = $_GET['controladora_id'];

    $stmt = $pdo->prepare("SELECT pixel_max FROM referencias_control WHERE id_referencia = :controladora_id");
    $stmt->bindParam(':controladora_id', $controladoraId);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode($result);
}
?>
