<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');


    $id_items = $_POST['id_item'];
    $descripciones = $_POST['descripcion'];
    $cantidades = $_POST['cantidad'];
    $instalaciones = $_POST['instalacion'];
    $id_oc = $_POST['id_oc'];

        $query_update_item = $pdo->prepare('UPDATE items_oc SET 
            descripcion = :descripciones, 
            cantidad = :cantidades, 
            instalacion = :instalaciones
            WHERE id_item = :id_items
        ');

        $query_update_item->bindParam(':descripciones', $descripciones);
        $query_update_item->bindParam(':cantidades', $cantidades);
        $query_update_item->bindParam(':instalaciones', $instalaciones);
        $query_update_item->bindParam(':id_items', $id_items, PDO::PARAM_INT);

        if (!$query_update_item->execute()) {
            echo "Error al actualizar el ítem con ID $id_items.";
            exit;
        }

    // Construir la URL y redirigir
    $redirect_url = $URL . "admin/administracion/oc/edit.php?id=" . $id_oc;
    header("Location: $redirect_url");
    exit; // Siempre es recomendable usar exit después de header

?>
