<?php

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

if (isset($_POST['pitch_id'])) {  // Cambiar a pitch_id
    $pitchId = $_POST['pitch_id'];  // Cambiar a pitchId

    // Consulta para obtener las series y las referencias filtradas por ID
    $query = $pdo->prepare('SELECT id, serie, referencia FROM producto_modulo_creado WHERE pitch = :pitchId');
    $query->bindParam(':pitchId', $pitchId);
    $query->execute();
    $series = $query->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar la opción por defecto
    echo '<option value=""></option>';

    // Generar las opciones del select
    foreach ($series as $serie) {
        // Concatenar serie y referencia con un "/"
        $value = $serie['serie'] . ' / ' . $serie['referencia']; 
        echo '<option value="' . $serie['id'] . '" data-referencia="' . $serie['referencia'] . '">' . $value . '</option>';
    }
}
?>
