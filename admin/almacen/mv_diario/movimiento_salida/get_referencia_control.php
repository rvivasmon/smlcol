<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');


if (isset($_POST['marca_control'])) {
    $marca_control = $_POST['marca_control'];

    // Consulta para obtener las referencias filtradas
    $query = $pdo->prepare('SELECT id_referencia , referencia FROM referencias_control WHERE marca = :marca_control ORDER BY referencia ASC');
    $query->bindParam(':marca_control', $marca_control);
    $query->execute();
    $referencias = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($referencias) {
        foreach ($referencias as $referencia) {
            echo '<option value="' . htmlspecialchars($referencia['id_referencia']) . '">' . htmlspecialchars($referencia['referencia']) . '</option>';
        }
    } else {
        echo '<option value="">No hay series referencias disponibles para esta controladora</option>';
    }
}
?>
