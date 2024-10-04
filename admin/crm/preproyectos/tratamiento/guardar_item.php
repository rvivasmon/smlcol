<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $pantallas = $_POST['pantallas'];
    $estado = $_POST['estado'];
    $categoria_producto = $_POST['categoria_producto'];
    $uso = $_POST['uso'];
    $tipo_producto = $_POST['tipo_producto'];
    $x_dispo_mts = $_POST['x_dispo_mts'];
    $y_dispo_mts = $_POST['y_dispo_mts'];
    $justificacion = $_POST['justificacion'];

    // Preparar la consulta para insertar datos
    $stmt = $pdo->prepare("INSERT INTO item_preproyecto (cantidad_pantallas, estado, categoria, uso, tipo_producto, x_disponible, y_disponible, justificacion)
        VALUES (:pantallas, :estado, :categoria, :uso, :tipo_producto, :x_dispo_mts, :y_dispo_mts, :justificacion)");

    // Ejecutar la consulta por cada conjunto de datos
    foreach ($pantallas as $key => $value) {
        $stmt->execute([
            ':pantallas' => $value,
            ':estado' => $estado[$key],
            ':categoria' => $categoria_producto[$key],
            ':uso' => $uso[$key],
            ':tipo_producto' => $tipo_producto[$key],
            ':x_dispo_mts' => $x_dispo_mts[$key],
            ':y_dispo_mts' => $y_dispo_mts[$key],
            ':justificacion' => $justificacion[$key]
        ]);
    }

    echo 'Items guardados correctamente.';
} else {
    echo 'Método no permitido.';
}
?>
