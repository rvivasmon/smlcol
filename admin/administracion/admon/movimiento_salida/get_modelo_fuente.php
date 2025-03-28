<?php

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

if (isset($_POST['marca_fuente'])) {
    $marca_fuente = $_POST['marca_fuente'];

    // Consulta para obtener los modelos filtrados
    $query = $pdo->prepare('SELECT id_referencias_fuentes , modelo_fuente FROM referencias_fuente WHERE marca_fuente = :marca_fuente ORDER BY modelo_fuente ASC');
    $query->bindParam(':marca_fuente', $marca_fuente);
    $query->execute();
    $modelos = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($modelos) {
        foreach ($modelos as $modelo) {
            echo '<option value="' . htmlspecialchars($modelo['id_referencias_fuentes']) . '">' . htmlspecialchars($modelo['modelo_fuente']) . '</option>';
        }
    } else {
        echo '<option value="">No hay referencias para este fuente</option>';
    }
}
?>
