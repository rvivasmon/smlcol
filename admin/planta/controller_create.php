<?php

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

$fcreacion = $_POST['fechaingreso'];
$op = $_POST['OP'];
$agente = $_POST['agente'];
$idprod = $_POST['idproducto'];
$anio_mes1 = $_POST['anio_mes1'];
$contador1 = $_POST['contador1'];

try {
    // Iniciar una transacción
    $pdo->beginTransaction();

    // Insertar en la tabla id_producto
    $sql = "INSERT INTO id_producto (fecha, op, agente, id_producto, anio_mes_prod, contador_prod) VALUES (:fcreacion, :op, :agente, :idprod, :anio_mes1, :contador1)";
    $sentencia = $pdo->prepare($sql);

    $sentencia->bindParam(':fcreacion', $fcreacion);
    $sentencia->bindParam(':op', $op);
    $sentencia->bindParam(':agente', $agente);
    $sentencia->bindParam(':idprod', $idprod);
    $sentencia->bindParam(':anio_mes1', $anio_mes1);
    $sentencia->bindParam(':contador1', $contador1);

    if ($sentencia->execute()) {
        // Actualizar el campo id_producto en la tabla op
        $sql_update_op = "UPDATE op SET id_producto = 2 WHERE id = :op_id";
        $sentencia_update = $pdo->prepare($sql_update_op);
        $sentencia_update->bindParam(':op_id', $op);

        if ($sentencia_update->execute()) {
            // Confirmar la transacción
            $pdo->commit();
            
            session_start();
            $_SESSION['Mensajes'] = array(
                'title' => 'Good job!',
                'text' => '¡Usuario creado exitosamente!',
                'icon' => 'success'
            );
            header('Location: '.$URL.'admin/planta/');
            exit;
        } else {
            // Si la actualización falla, se revierte la transacción
            $pdo->rollBack();
            throw new Exception("Error al actualizar la tabla op.");
        }
    } else {
        // Si la inserción falla, se revierte la transacción
        $pdo->rollBack();
        throw new Exception("Error al insertar en la tabla id_producto.");
    }
} catch (Exception $e) {
    // Manejar errores y mensajes de sesión
    session_start();
    $_SESSION['Mensajes'] = array(
        'title' => 'Error',
        'text' => 'Error al introducir la información: ' . $e->getMessage(),
        'icon' => 'error'
    );
    header('Location: '.$URL.'admin/planta/create.php');
    exit;
}