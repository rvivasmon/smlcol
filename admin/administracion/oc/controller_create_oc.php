<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recolectar datos del formulario

    $fecha_creacion = $_POST['fecha'];
    $pc = $_POST['pc'];
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
    $num_factura_fecha = $_POST['num_factura_fecha'];
    $acuerdo_pago = $_POST['acuerdo_pago'];
    $ciudad = $_POST['ciudad'];
    $lugar_instalacion = $_POST['lugar_instalacion'];
    $estado_logistico = $_POST['estado_logistico'];
    $dias_pactados = $_POST['dias_pactados'];
    $proyecto = $_POST['proyecto'];
    $observacion = $_POST['observacion'];
    $num_factura = $_POST['num_factura'];
    $num_items = $_POST['num_items'];
        


        // Inserta los datos principales de la OC
        $query_insert = "INSERT INTO oc (fecha_creacion, oc, pc, tipo_oc, tipo_pc, oc_cliente,fecha_aprobacion, estado_admon, vendedor, estado_factura, num_factura_fecha, acuerdo_pago, nom_contacto_admin, telefono_contacto, nom_cliente, nom_contacto_cliente, num_telefono, proyecto, ciudad, lugar_instalacion, estado_logistico, dias_pactados, observacion, num_factura, num_items, contador) 
        VALUES (:oc, :pc, :tipo_oc, :tipo_pc, :oc_cliente, :fecha_creacion, :fecha_aprobacion, :estado_admon, :vendedor, :estado_factura, :num_factura_fecha, :acuerdo_pago, :nom_contacto_admin, :telefono_contacto, :nom_cliente, :nom_contacto_cliente, :num_telefono, :proyecto, :ciudad, :lugar_instalacion, :estado_logistico, :dias_pactados, :observacion, :num_factura, :num_items, :conta1, :conta2, :conta3, :conta4, :conta5, :conta6)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':oc', $oc_resultante);
        $stmt->bindParam(':pc', $pc); // Ajusta el valor del pc si es necesario
        $stmt->bindParam(':tipo_oc', $tipo_oc);
        $stmt->bindParam(':tipo_pc', $tipo_pc);
        $stmt->bindParam(':oc_cliente', $oc_cliente);
        $stmt->bindParam(':fecha_creacion', $fecha_creacion);
        $stmt->bindParam(':fecha_aprovacion', $fecha_aprovacion);
        $stmt->bindParam(':estado_admon', $estado_admon);
        $stmt->bindParam(':vendedor', $vendedor);
        $stmt->bindParam(':estado_factura', $estado_factura);
        $stmt->bindParam(':num_factura_fecha', $num_factura_fecha);
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
        $stmt->bindParam(':num_factura', $num_factura);
        $stmt->bindParam(':num_items', $num_items);
        $stmt->bindParam(':conta1', $conta1);
        $stmt->bindParam(':conta2', $conta2);
        $stmt->bindParam(':conta3', $conta3);
        $stmt->bindParam(':conta4', $conta4);
        $stmt->bindParam(':conta5', $conta5);
        $stmt->bindParam(':conta6', $conta6);

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
            echo '<script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Debes agregar al menos un ítem para poder guardar el registro."
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigir al usuario a la sección de agregar items (opcional)
                    window.location.href = "url_de_la_seccion_de_agregar_items";
                }
            });
        </script>';
        exit;
    }
        


        // Redirigir al usuario después de guardar
        header('Location: ../../admin/nueva_tarea_8-7-24/index_oc.php');

}
