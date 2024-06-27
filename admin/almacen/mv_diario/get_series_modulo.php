<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if (isset($_POST['pitch']) && isset($_POST['modelo'])) {
    $pitch = $_POST['pitch'];
    $modelo = $_POST['modelo'];

        // Imprimir los valores recibidos
        echo "Valores recibidos: Pitch - $pitch, Modelo - $modelo\n";

    $query = $pdo->prepare('SELECT id_almacen_principal, serie_modulo FROM almacen_principal WHERE pitch = ? AND modelo_modulo = ?');
    $query->execute([$pitch, $modelo]);
    $series = $query->fetchAll(PDO::FETCH_ASSOC);

        // Imprimir los resultados de la consulta
        echo "Resultados de la consulta:\n";
        print_r($series);

    echo json_encode($series);
}
?>
