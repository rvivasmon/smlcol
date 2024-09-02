<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$fecha_tratada_oc =  date('Y-m-d'); //Obtiene la fecha actual
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


//$id = $_POST['id'];
$oc_cliente = $_POST['oc_cliente'];
$estado_admon = $_POST['estado_admon'];
$vendedor = $_POST['vendedor']; 
$estado_factura = $_POST['estado_factura'];
$acuerdo_pago = $_POST['acuerdo_pago'];
$fecha_tratada_oc = $_POST['fecha_tratada_oc'];
$nom_contacto_admin = $_POST['nom_contacto_admin'];
$telefono_contacto = $_POST['telefono_contacto'];
$nom_cliente = $_POST['nom_cliente'];
$nom_contacto_cliente = $_POST['nom_contacto_cliente'];
$num_telefono = $_POST['num_telefono'];
$ciudad = $_POST['ciudad'];
$lugar_instalacion = $_POST['lugar_instalacion'];
$estado_logistico = $_POST['estado_logistico'];
$dias_pactados = $_POST['dias_pactados'];
$observacion = $_POST['observacion'];


    $query_update = $pdo->prepare('UPDATE oc SET 
            oc_cliente = :oc_cliente, 
            estado_admon = :estado_admon, 
            vendedor = :vendedor
            estado_factura = :estado_factura, 
            acuerdo_pago = :acuerdo_pago,
            fecha_tratada_oc = :fecha_tratada_oc, 
            nom_contacto_admin = :nom_contacto_admin
            telefono_contacto = :telefono_contacto, 
            nom_cliente = :nom_cliente, 
            nom_contacto_cliente = :nom_contacto_cliente
            num_telefono = :num_telefono, 
            ciudad = :ciudad, 
            lugar_instalacion = :lugar_instalacion
            estado_logistico = :estado_logistico, 
            dias_pactados = :dias_pactados, 
            observacion = :observacion
        WHERE id = :id
        ');

    $query_update->bindParam(':oc_cliente', $oc_cliente);
    $query_update->bindParam(':estado_admon', $estado_admon);
    $query_update->bindParam(':vendedor', $vendedor);
    $query_update->bindParam(':estado_factura', $estado_factura);
    $query_update->bindParam(':acuerdo_pago', $acuerdo_pago);
    $query_update->bindParam(':fecha_tratada_oc', $fecha_tratada_oc);
    $query_update->bindParam(':nom_contacto_admin', $nom_contacto_admin);
    $query_update->bindParam(':telefono_contacto', $telefono_contacto);
    $query_update->bindParam(':nom_cliente', $nom_cliente);
    $query_update->bindParam(':nom_contacto_cliente', $nom_contacto_cliente);
    $query_update->bindParam(':num_telefono', $num_telefono);
    $query_update->bindParam(':ciudad', $ciudad);
    $query_update->bindParam(':lugar_instalacion', $lugar_instalacion);
    $query_update->bindParam(':estado_logistico', $estado_logistico);
    $query_update->bindParam(':dias_pactados', $dias_pactados);
    $query_update->bindParam(':dias_pactados', $dias_pactados);
    $query_update->bindParam(':id', $id, PDO::PARAM_INT);

    $query_update_item->execute();


    // Recolectar datos del formulario
    $usuario_crea_pop = $_POST['usuario_crea_pop'];
    $oc = $_POST['oc'];
    $fecha_creacion = $_POST['fecha_creacion'];
    $estado_admon = $_POST['estado_admon'];
    $nom_cliente = $_POST['nom_cliente'];
    $nom_contacto_cliente = $_POST['nom_contacto_cliente'];
    $num_telefono = $_POST['num_telefono'];
    $proyecto = $_POST['proyecto'];
    $ciudad = $_POST['ciudad'];
    $lugar_instalacion = $_POST['lugar_instalacion'];
    $estado_logistico = $_POST['estado_logistico'];
    $observacion = $_POST['observacion'];

    // Inicia una transacción
    $pdo->beginTransaction();

        // Inserta los datos principales de la tabla POP
        $query = "INSERT INTO pop (usuario_crea_pop, oc, fecha_creacion, estado_admon, nom_cliente, nom_contacto_cliente, num_telefono, proyecto, ciudad, lugar_instalacion, estado_logistico, observacion) VALUES (:usuario_crea_pop, :oc, :fecha_creacion, :estado_admon, :nom_cliente, :nom_contacto_cliente, :num_telefono, :proyecto, :ciudad, :lugar_instalacion, :estado_logistico, :observacion)";

        $stmt = $pdo->prepare($query);

        
        $stmt->bindParam(':usuario_crea_pop', $usuario_crea_pop);
        $stmt->bindParam(':oc', $oc);
        $stmt->bindParam(':fecha_creacion', $fecha_creacion);
        $stmt->bindParam(':estado_admon', $estado_admon);
        $stmt->bindParam(':nom_cliente', $nom_cliente);
        $stmt->bindParam(':nom_contacto_cliente', $nom_contacto_cliente);
        $stmt->bindParam(':num_telefono', $num_telefono);
        $stmt->bindParam(':proyecto', $proyecto);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':lugar_instalacion', $lugar_instalacion);
        $stmt->bindParam(':estado_logistico', $estado_logistico);
        $stmt->bindParam(':observacion', $observacion);

        $stmt->execute();

        // Obtener el ID del OC recién insertado
        $id_oc = $pdo->lastInsertId();
try {
        // Insertar los ítems en la tabla 'tabla_items_oc' solo si existen
        if (isset($_POST['descripcion']) && isset($_POST['cantidad']) && isset($_POST['instalacion'])) {
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
        }

        // Eliminar ítem específico
        if (isset($_GET['id_item'])) {
            $id_item = $_GET['id_item'];
            $id_oc = $_GET['id'];

            // Eliminar el ítem
            $query_delete_item = $pdo->prepare("DELETE FROM tabla_items_oc WHERE id_item = :id_item");
            $query_delete_item->bindParam(':id_item', $id_item, PDO::PARAM_INT);
            $query_delete_item->execute();

            // Confirmar la transacción
            $pdo->commit();
            header("Location: delete_oc.php?id=$id_oc");
            exit();
        }

            // Insertar los ítems en la tabla 'POP' solo si existen
    if (isset($_POST['descripcion']) && isset($_POST['cantidad']) && isset($_POST['instalacion'])) {
        $descripciones = $_POST['descripcion'];
        $cantidades = $_POST['cantidad'];
        $instalaciones = $_POST['instalacion'];

        for ($i = 0; $i < count($descripciones); $i++) {
            $descripcion = $descripciones[$i];
            $cantidad = $cantidades[$i];
            $instalacion = $instalaciones[$i];

            $query_insert_item = $pdo->prepare('INSERT INTO pop (descripcion, cantidad, instalacion, id_oc) VALUES (:descripcion, :cantidad, :instalacion, :id_oc)');
            $query_insert_item->bindParam(':descripcion', $descripcion);
            $query_insert_item->bindParam(':cantidad', $cantidad);
            $query_insert_item->bindParam(':instalacion', $instalacion);
            $query_insert_item->bindParam(':id_oc', $id_oc);
            $query_insert_item->execute();
        }
    }

        // Confirma la transacción
        $pdo->commit();
        header("Location: " . $URL . "admin/nueva_tarea_8-7-24/index_oc.php");
        echo "Registro guardado exitosamente";

    } catch (Exception $e) {
        // Deshace la transacción en caso de error
        $pdo->rollBack();
        echo "Error al guardar el registro: " . $e->getMessage();
    }
}