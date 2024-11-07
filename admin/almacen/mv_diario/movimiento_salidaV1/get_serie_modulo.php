<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');


if (isset($_POST['pitch'])) {
    $pitch = $_POST['pitch'];

    // Consulta para obtener las series filtradas
    $query = $pdo->prepare('SELECT id, serie FROM producto_modulo_creado WHERE pitch = :pitch');
    $query->bindParam(':pitch', $pitch);
    $query->execute();
    $series = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($series as $serie) {
        echo '<option value="' . $serie['id'] . '">' . $serie['serie'] . '</option>';
    }
}
?>
