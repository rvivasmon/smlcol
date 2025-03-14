<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');


if (isset($_POST['marca_control'])) {
    $marca_control = $_POST['marca_control'];

    // Consulta para obtener las referencias filtradas
    $query = $pdo->prepare('SELECT id_referencia , referencia FROM referencias_control WHERE marca = :marca_control');
    $query->bindParam(':marca_control', $marca_control);
    $query->execute();
    $referencias = $query->fetchAll(PDO::FETCH_ASSOC);

        // Mostrar la opción por defecto
        echo '<option value=""></option>';

    foreach ($referencias as $referencia) {
        echo '<option value="' . $referencia['id_referencia'] . '">' . $referencia['referencia'] . '</option>';
    }
}
?>
