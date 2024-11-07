<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

if (isset($_POST['pitch_id'])) {  // Cambiar a pitch_id
    $pitchId = $_POST['pitch_id'];  // Cambiar a pitchId

    // Consulta para obtener las series filtradas por ID
    $query = $pdo->prepare('SELECT id, serie FROM producto_modulo_creado WHERE pitch = :pitchId');
    $query->bindParam(':pitchId', $pitchId);
    $query->execute();
    $series = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($series as $serie) {
        echo '<option value="' . $serie['id'] . '">' . $serie['serie'] . '</option>';
    }
}
?>
