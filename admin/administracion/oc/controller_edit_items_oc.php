<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if (isset($_POST['id_item']) && isset($_POST['descripcion']) && isset($_POST['cantidad']) && isset($_POST['instalacion'])) {
    $id_items = $_POST['id_item'];
    $descripciones = $_POST['descripcion'];
    $cantidades = $_POST['cantidad'];
    $instalaciones = $_POST['instalacion'];

    for ($i = 0; $i < count($id_items); $i++) {
        $id_item = $id_items[$i];
        $descripcion = $descripciones[$i];
        $cantidad = $cantidades[$i];
        $instalacion = $instalaciones[$i];

        $query_update_item = $pdo->prepare('UPDATE tabla_items_oc SET 
            descripcion = :descripcion, 
            cantidad = :cantidad, 
            instalacion = :instalacion
            WHERE id_item = :id_item
        ');

        $query_update_item->bindParam(':descripcion', $descripcion);
        $query_update_item->bindParam(':cantidad', $cantidad);
        $query_update_item->bindParam(':instalacion', $instalacion);
        $query_update_item->bindParam(':id_item', $id_item, PDO::PARAM_INT);

        if (!$query_update_item->execute()) {
            echo "Error al actualizar el ítem con ID $id_item.";
            exit;
        }
    }

    header('Location: index_oc.php');
} else {
    echo "Datos incompletos.";
}
?>
