<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if (isset($_POST['id_proyecto_visor'])) {
    $id_proyecto_visor = $_POST['id_proyecto_visor'];

    $query = $pdo->prepare('SELECT tipo_proyecto_visor, proyecto_visor FROM oc_proyecto WHERE id_proyecto_visor = :id_proyecto_visor');
    $query->bindParam(':id_proyecto_visor', $id_proyecto_visor, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Devuelve los valores en formato JSON
        echo json_encode($result);
    } else {
        // Devuelve valores vacíos en formato JSON
        echo json_encode(['tipo_proyecto_visor' => '', 'proyecto_visor' => '']);
    }
}
?>
