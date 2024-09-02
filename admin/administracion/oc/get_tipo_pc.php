<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if (isset($_POST['id_proyecto_visor'])) {
    $id_proyecto_visor = $_POST['id_proyecto_visor'];

    $query = $pdo->prepare('SELECT tipo_proyecto_visor FROM oc_proyecto WHERE id_proyecto_visor = :id_proyecto_visor');
    $query->bindParam(':id_proyecto_visor', $id_proyecto_visor, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo $result['tipo_proyecto_visor'];
    } else {
        echo '';
    }
}
?>
