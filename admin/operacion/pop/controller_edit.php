<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$fecha_tratada_oc = date('Y-m-d'); // Obtiene la fecha actual

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pop = $_POST['id1'] ?? null;
    $fecha_inicio = $_POST['fecha_inicio1'] ?? null;
    $fecha_fin = $_POST['fecha_fin1'] ?? null;
    $id_oc = $_POST['id_oc'] ?? null;
    $proyecto = $_POST['proyecto'] ?? null;
    $observacion = $_POST['observacion'] ?? null;
    $cantidad_item_pop = $_POST['cantidad_item_pop'] ?? null;

    // Verificar que los datos principales existan
    if (!$id_pop || !$fecha_inicio || !$fecha_fin || !$id_oc || !$proyecto || !$observacion) {
        die('Datos principales incompletos.');
    }

                // Preparar la consulta de inserción
                $query_insert = $pdo->prepare("
                    INSERT INTO op_admin (oc, pop, fecha_inicio, fecha_recibido, fecha_terminado, proyecto, observacion, num_items) 
                    VALUES (:id_oc, :id_pop, :fecha_inicio, :fecha_actual, :fecha_fin, :proyecto, :observacion, :cantidad_item_pop)
                ");
                
                // Asignar los valores a los parámetros
                $query_insert->bindParam(':id_oc', $id_oc);
                $query_insert->bindParam(':id_pop', $id_pop);
                $query_insert->bindParam(':fecha_inicio', $fecha_inicio);
                $query_insert->bindParam(':fecha_actual', $fecha_actual);
                $query_insert->bindParam(':fecha_fin', $fecha_fin);
                $query_insert->bindParam(':proyecto', $proyecto);
                $query_insert->bindParam(':observacion', $observacion);
                $query_insert->bindParam(':cantidad_item_pop', $cantidad_item_pop);
                $query_insert->execute();

        // Cambiar el valor del campo "estado_pop" a 2
        $query_update_estado = $pdo->prepare("
        UPDATE pop 
        SET procesar = 1 
        WHERE id = :id_pop
        ");
        $query_update_estado->bindParam(':id_pop', $id_pop);

        if (!$query_update_estado->execute()) {
            die('Error al actualizar el estado de la tabla pop.');
        }

            header("Location: ../../../admin/operacion/pop/");
            exit();
        } else {
            die('Método de solicitud no permitido.');
        }
?>
