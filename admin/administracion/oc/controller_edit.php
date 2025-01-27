<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

// Obtiene la fecha actual
$fecha_tratada_oc = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los datos enviados desde el formulario
    $id = $_POST['id'];
    $oc_cliente = $_POST['oc_cliente'];
    $estado_admon = $_POST['id_admon'];
    $vendedor = $_POST['id_vendedor'];
    $estado_factura = $_POST['estado_factura'];
    $acuerdo_pago = $_POST['id_acuerdo1'];
    $fecha_tratada_oc = $_POST['fecha_tratada'] ?? $fecha_tratada_oc;
    $nom_contacto_admin = $_POST['nom_contacto_admin'];
    $telefono_contacto = $_POST['telefono_contacto'];
    $nom_cliente = $_POST['id_nom_cliente'];
    $nom_contacto_cliente = $_POST['nom_contacto_cliente'];
    $num_telefono = $_POST['num_telefono'];
    $ciudad = $_POST['id_ciudad'];
    $lugar_instalacion = $_POST['lugar_instalacion'];
    $estado_logistico = $_POST['estado_logistico'];
    $dias_pactados = $_POST['dias_pactados'];
    $observacion = $_POST['observacion'];
    $proyecto = $_POST['proyecto'];
    $fecha_creacion = $_POST['fecha_creacion'] ?? $fecha_tratada_oc;
    $items_oc = $_POST['num_items'];
    $fecha_factura = $_POST['factura_fecha'];
    $fecha_aprobacion = $_POST['fecha_aprobacion'];    

    try {
        // Inicia la transacción
        $pdo->beginTransaction();

        // Inicializa el valor de "procesar"
    $procesar = 0;

    // Si el estado_admon es igual a 1, procesar será 1
    if ($estado_admon == 1) {
        $procesar = 1;
    }

        // Actualizar tabla 'oc'
        $query_update = $pdo->prepare('
            UPDATE oc SET 
                oc_cliente = :oc_cliente,
                estado_admon = :estado_admon,
                vendedor = :vendedor,
                estado_factura = :estado_factura,
                acuerdo_pago = :acuerdo_pago,
                fecha_tratada_oc = :fecha_tratada_oc,
                nom_contacto_admin = :nom_contacto_admin,
                telefono_contacto = :telefono_contacto,
                nom_cliente = :nom_cliente,
                nom_contacto_cliente = :nom_contacto_cliente,
                num_telefono = :num_telefono,
                ciudad = :ciudad,
                lugar_instalacion = :lugar_instalacion,
                estado_logistico = :estado_logistico,
                dias_pactados = :dias_pactados,
                observacion = :observacion,
                procesar = :procesar,
                fecha_aprobacion = :fecha_aprobacion,
                factura_fecha = :fecha_factura
            WHERE id = :id
        ');

        $query_update->execute([
            ':id' => $id,
            ':oc_cliente' => $oc_cliente,
            ':estado_admon' => $estado_admon,
            ':vendedor' => $vendedor,
            ':estado_factura' => $estado_factura,
            ':acuerdo_pago' => $acuerdo_pago,
            ':fecha_tratada_oc' => $fecha_tratada_oc,
            ':nom_contacto_admin' => $nom_contacto_admin,
            ':telefono_contacto' => $telefono_contacto,
            ':nom_cliente' => $nom_cliente,
            ':nom_contacto_cliente' => $nom_contacto_cliente,
            ':num_telefono' => $num_telefono,
            ':ciudad' => $ciudad,
            ':lugar_instalacion' => $lugar_instalacion,
            ':estado_logistico' => $estado_logistico,
            ':dias_pactados' => $dias_pactados,
            ':observacion' => $observacion,
            ':procesar' => $procesar,
            ':fecha_aprobacion' => $fecha_aprobacion,
            ':fecha_factura' => $fecha_factura,
        ]);

       // Si estado_admon es 1, inserta en la tabla 'pop'
        if ($estado_admon == 1) {
            try {
                // Obtener el último valor del contador
                $query_last_counter = $pdo->prepare('SELECT MAX(contador) AS last_counter FROM pop');
                $query_last_counter->execute();
                $result = $query_last_counter->fetch(PDO::FETCH_ASSOC);
                
                // Incrementar el contador
                $new_counter = $result['last_counter'] ? $result['last_counter'] + 1 : 1;

                // Insertar el nuevo registro en la tabla 'pop'
                $query_insert_pop = $pdo->prepare('
                    INSERT INTO pop (
                        id_oc, oc, fecha_recibido, estado_admon, cliente, contacto, telefono,
                        nombre_proyecto, ciudad, lugar_instalacion, observaciones, items_oc, contador
                    ) VALUES (
                        :id_oc, :oc, :fecha_creacion, :estado_admon, :cliente, :contacto,
                        :telefono, :proyecto, :ciudad, :lugar_instalacion, :observacion, :items_oc, :contador
                    )
                ');

                $query_insert_pop->execute([
                    ':id_oc' => $id,
                    ':oc' => $oc_cliente,
                    ':fecha_creacion' => $fecha_creacion,
                    ':estado_admon' => $estado_admon,
                    ':cliente' => $nom_cliente,
                    ':contacto' => $nom_contacto_cliente,
                    ':telefono' => $num_telefono,
                    ':proyecto' => $proyecto,
                    ':ciudad' => $ciudad,
                    ':lugar_instalacion' => $lugar_instalacion,
                    ':observacion' => $observacion,
                    ':items_oc' => $items_oc,
                    ':contador' => $new_counter, // Aquí se usa el nuevo valor del contador
                ]);

                // Mensaje opcional para depuración
                // echo "Nuevo registro creado con el contador: " . $new_counter;

            } catch (Exception $e) {
                // Manejo de errores
                $pdo->rollBack();
                echo "Error al insertar en la tabla 'pop': " . $e->getMessage();
                exit;
            }
        }

        // Consultar ítems asociados
        $query_items = $pdo->prepare("SELECT * FROM items_oc WHERE id_oc = :id_oc");
        $query_items->bindParam(':id_oc', $id_oc, PDO::PARAM_INT);
        $query_items->execute();
        $items = $query_items->fetchAll(PDO::FETCH_ASSOC);

        // Insertar los ítems en la tabla 'items_pop'
        foreach ($items as $item) {
            $query_insert = $pdo->prepare("
                INSERT INTO items_pop (id_oc, id_pop, instalacion, descripcion, cantidad, contador) 
                VALUES (:id_oc, :id_pop, :instalacion, :descripcion_item, :cantidad, :contador)
            ");
            $query_insert->bindParam(':id_oc', $item['id_oc'], PDO::PARAM_INT);
            $query_insert->bindParam(':id_pop', $id_pop, PDO::PARAM_INT);
            $query_insert->bindParam(':instalacion', $item['instalacion'], PDO::PARAM_STR);
            $query_insert->bindParam(':descripcion_item', $item['descripcion'], PDO::PARAM_STR);
            $query_insert->bindParam(':cantidad', $item['cantidad'], PDO::PARAM_INT);
            $query_insert->bindParam(':contador', $contador, PDO::PARAM_STR);
            $query_insert->execute();
        }


        // Confirma la transacción
        $pdo->commit();
        header("Location: ../../../admin/administracion/oc");
        exit;
    } catch (Exception $e) {
        // Deshace la transacción en caso de error
        $pdo->rollBack();
        echo "Error al guardar el registro: " . $e->getMessage();
    }
}
