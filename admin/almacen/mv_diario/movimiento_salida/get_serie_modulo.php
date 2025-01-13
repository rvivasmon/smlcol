<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');


if (isset($_POST['pitch'])) {
    $pitch = $_POST['pitch'];

    // Consulta para obtener las series filtradas
    $query = $pdo->prepare('SELECT id, serie, referencia FROM producto_modulo_creado WHERE pitch = :pitch ORDER BY serie ASC');
    $query->bindParam(':pitch', $pitch);
    $query->execute();
    $series = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($series) {
    // Generar las opciones del select
    foreach ($series as $serie) {
        // Concatenar serie y referencia con un "/"
        $value = $serie['serie'] . ' / ' . $serie['referencia']; 
        echo '<option value="' . $serie['id'] . '" data-referencia="' . $serie['referencia'] . '">' . $value . '</option>';
    }
}
}
?>
