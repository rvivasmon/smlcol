<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        // Iniciar la transacción
        $pdo->beginTransaction();

        // Recolectar datos del formulario
        $fecha_creacion = $_POST['fecha'];
        $id_pc = $_POST['pc'];
        $pc = $_POST['pc21'];
        $tipo_pc = $_POST['tipo_pc'];
        $oc= $_POST['oci_oc'];
        $tipo_oc = $_POST['sml_psi_tl'];
        $oc_resultante = $_POST['oc_resultante'];
        $oc_cliente = $_POST['oc_cliente'];
        $nom_cliente = $_POST['nom_cliente'];
        $nom_contacto_admin = $_POST['nom_contacto_admin'];
        $telefono_contacto = $_POST['telefono_contacto'];
        $nom_contacto_cliente = $_POST['nom_contacto_cliente'];
        $num_telefono = $_POST['num_telefono'];    
        $fecha_aprobacion = $_POST['fecha_aprobacion'];
        $estado_admon = $_POST['estado_admon'];
        $vendedor = $_POST['vendedor'];
        $estado_factura = $_POST['estado_factura'];
        $factura_fecha = $_POST['factura_fecha'];
        $acuerdo_pago = $_POST['acuerdo_pago'];
        $ciudad = $_POST['ciudad'];
        $lugar_instalacion = $_POST['lugar_instalacion'];
        $estado_logistico = $_POST['estado_logistico'];
        $dias_pactados = $_POST['dias_pactados'];
        $proyecto = $_POST['proyecto'];
        $observacion = $_POST['observacion'];
        $num_factura = $_POST['num_factura'];
        $num_items = $_POST['num_items'];

        // Lógica para obtener el valor de $contador
        $query_get_contador = "SELECT MAX(contador) + 1 AS next_contador FROM oc WHERE oc = :oc AND tipo_oc = :tipo_oc";
        $stmt_contador = $pdo->prepare($query_get_contador);
        $stmt_contador->bindParam(':oc', $oc);
        $stmt_contador->bindParam(':tipo_oc', $tipo_oc);
        $stmt_contador->execute();
        $result = $stmt_contador->fetch(PDO::FETCH_ASSOC);
        $contador = $result['next_contador'] ?? 1; // Si es null, inicia en 1

        // Inserta los datos principales de la OC
        $query_insert = "INSERT INTO oc (fecha_creacion, id_pc, pc, tipo_pc, oc, tipo_oc, oc_cliente, estado_admon, vendedor, estado_factura, factura_fecha, acuerdo_pago, nom_contacto_admin, telefono_contacto, nom_cliente, nom_contacto_cliente, num_telefono, proyecto, ciudad, lugar_instalacion, estado_logistico, dias_pactados, observacion, fecha_aprobacion, num_factura, num_items, contador, oc_resultante, usuario_crea_oc) 
        VALUES (:fecha_creacion, :id_pc, :pc, :tipo_pc, :oc, :tipo_oc, :oc_cliente, :estado_admon, :vendedor, :estado_factura, :factura_fecha, :acuerdo_pago, :nom_contacto_admin, :telefono_contacto, :nom_cliente, :nom_contacto_cliente, :num_telefono, :proyecto, :ciudad, :lugar_instalacion, :estado_logistico, :dias_pactados, :observacion, :fecha_aprobacion, :num_factura, :num_items, :contador, :oc_resultante, :usuario)";

        $stmt = $pdo->prepare($query_insert);
        $stmt->bindParam(':fecha_creacion', $fecha_creacion);
        $stmt->bindParam(':id_pc', $id_pc);
        $stmt->bindParam(':pc', $pc);
        $stmt->bindParam(':tipo_pc', $tipo_pc);
        $stmt->bindParam(':oc', $oc);
        $stmt->bindParam(':tipo_oc', $tipo_oc);
        $stmt->bindParam(':oc_cliente', $oc_cliente);
        $stmt->bindParam(':estado_admon', $estado_admon);
        $stmt->bindParam(':vendedor', $vendedor);
        $stmt->bindParam(':estado_factura', $estado_factura);
        $stmt->bindParam(':factura_fecha', $factura_fecha);
        $stmt->bindParam(':acuerdo_pago', $acuerdo_pago);
        $stmt->bindParam(':nom_contacto_admin', $nom_contacto_admin);
        $stmt->bindParam(':telefono_contacto', $telefono_contacto);
        $stmt->bindParam(':nom_cliente', $nom_cliente);
        $stmt->bindParam(':nom_contacto_cliente', $nom_contacto_cliente);
        $stmt->bindParam(':num_telefono', $num_telefono);
        $stmt->bindParam(':proyecto', $proyecto);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':lugar_instalacion', $lugar_instalacion);
        $stmt->bindParam(':estado_logistico', $estado_logistico);
        $stmt->bindParam(':dias_pactados', $dias_pactados);
        $stmt->bindParam(':observacion', $observacion);
        $stmt->bindParam(':fecha_aprobacion', $fecha_aprobacion);
        $stmt->bindParam(':num_factura', $num_factura);
        $stmt->bindParam(':num_items', $num_items);
        $stmt->bindParam(':contador', $contador);
        $stmt->bindParam(':oc_resultante', $oc_resultante);
        $stmt->bindParam(':usuario', $usuario);

        $stmt->execute();

        // Obtener el ID del OC recién insertado
        $id_oc = $pdo->lastInsertId();

        // Insertar los ítems en la tabla 'tabla_items_oc' solo si existen
        if (count($_POST['descripcion']) > 0 && count($_POST['cantidad']) > 0 && count($_POST['instalacion']) > 0) {
            $descripciones = $_POST['descripcion'];
            $cantidades = $_POST['cantidad'];
            $instalaciones = $_POST['instalacion'];

            for ($i = 0; $i < count($descripciones); $i++) {
                $descripcion = $descripciones[$i];
                $cantidad = $cantidades[$i];
                $instalacion = $instalaciones[$i];

                $query_insert_item = $pdo->prepare('INSERT INTO tabla_items_oc (descripcion, cantidad, instalacion, id_oc) VALUES (:descripcion, :cantidad, :instalacion, :id_oc)');
                $query_insert_item->bindParam(':descripcion', $descripcion);
                $query_insert_item->bindParam(':cantidad', $cantidad);
                $query_insert_item->bindParam(':instalacion', $instalacion);
                $query_insert_item->bindParam(':id_oc', $id_oc);
                $query_insert_item->execute();
            }

            // Confirmar la transacción
            $pdo->commit();

        } else {
            // Si no hay ítems, lanzar un error para hacer rollback
            throw new Exception("Debes agregar al menos un ítem para poder guardar el registro.");
        }

        // Redirigir al usuario después de guardar
        header('Location: ../../administracion/oc/');
        exit;

    } catch (Exception $e) {
        // En caso de error, hacer rollback de la transacción
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "' . $e->getMessage() . '"
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirigir al usuario a la sección de agregar items (opcional)
                window.location.href = "url_de_la_seccion_de_agregar_items";
            }
        });
        </script>';
        exit;
    }
}
?>
