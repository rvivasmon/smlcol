<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pop = $_POST['id1'] ?? null;
    $fecha_inicio = $_POST['fecha_inicio1'] ?? null;
    $fecha_fin = $_POST['fecha_fin1'] ?? null;

    // Verificar que los datos principales existan
    if (!$id_pop || !$fecha_inicio || !$fecha_fin) {
        die('Datos principales incompletos.');
    }

    // Actualizar la tabla "pop"
    $query_update_pop = $pdo->prepare("
        UPDATE pop 
        SET fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin
        WHERE id = :id
    ");
    $query_update_pop->bindParam(':fecha_inicio', $fecha_inicio);
    $query_update_pop->bindParam(':fecha_fin', $fecha_fin);
    $query_update_pop->bindParam(':id', $id_pop);

    if (!$query_update_pop->execute()) {
        die('Error al actualizar la tabla pop.');
    }

    // Verificar que los datos estén disponibles
    if (isset($_POST['id_item'], $_POST['descripcion'], $_POST['cantidad'])) {
        $id_item = $_POST['id_item']; // Del formulario
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];

        // Obtener los valores de `id` desde la tabla `items_pop`
        $query_items_pop = $pdo->prepare("SELECT id FROM items_pop WHERE id_pop = :id_pop");
        $query_items_pop->bindParam(':id_pop', $id_pop);
        $query_items_pop->execute();
        $items_pop_ids = $query_items_pop->fetchAll(PDO::FETCH_COLUMN);

        if (!$items_pop_ids) {
            die('No se encontraron registros en items_pop.');
        }

        // Comenzar el ciclo para insertar cada ítem
        foreach ($id_item as $index => $proyecto) {
            // Verificar que los otros campos también estén disponibles
            if (isset($descripcion[$index], $cantidad[$index], $items_pop_ids[$index])) {
                $item_pop_id = $items_pop_ids[$index]; // `id` desde `items_pop`

                // Preparar la consulta de inserción
                $query_insert = $pdo->prepare("
                    INSERT INTO items_op (id_oc, id_pop, id_item, descripcion, fecha_recibido, cantidad, contador) 
                    VALUES (:id_oc, :id_pop, :id_item, :descripcion, :fecha_recibido, :cantidad, :contador)
                ");
                
                // Asignar los valores a los parámetros
                $query_insert->bindParam(':id_oc', $id_oc);  // ID de OC
                $query_insert->bindParam(':id_pop', $id_pop);  // ID de POP
                $query_insert->bindParam(':id_item', $item_pop_id);  // ID de item (de `items_pop`)
                $query_insert->bindParam(':descripcion', $descripcion[$index]); // Descripción del ítem
                $query_insert->bindParam(':fecha_recibido', $fecha_inicio);  // Fecha recibido (usando $fecha_inicio)
                $query_insert->bindParam(':cantidad', $cantidad[$index]);  // Cantidad del ítem
                $query_insert->bindParam(':contador', $contador); // Contador (si aplica)
                // Ejecutar la consulta de inserción
                $query_insert->execute();
            }
        }
    }

    // Cambiar el valor del campo "estado_pop" a 2
    $query_update_estado = $pdo->prepare("
        UPDATE pop 
        SET estado_pop = 2 
        WHERE id = :id
    ");
    $query_update_estado->bindParam(':id', $id_pop);

    if (!$query_update_estado->execute()) {
        die('Error al actualizar el estado de la tabla pop.');
    }

    header("Location: ../../../admin/operacion/pop/");
    exit();
} else {
    die('Método de solicitud no permitido.');
}
?>
