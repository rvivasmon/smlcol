<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');


    // Obtiene los datos del formulario
    $id_ost = $_POST['id_ost'];
    $tipo_servicio = $_POST['tipo_servicio'];
    $estado = $_POST['estado'];
    $observacion = $_POST['observacion'];
    $id_usuario = $_POST['id_usuario'];    
    $tecnico_tratante = $_POST['tecnico_tratante'];


    
    // Inserta los datos en la tabla OST
    $sql = "UPDATE ost SET tipo_servicio = :tipo_servicio, estado = :estado, observacion = :observacion, tecnico_tratante = :tecnico_tratante WHERE id = :id";


    $sentencia = $pdo->prepare($sql);

    $sentencia->bindParam(':tipo_servicio', $tipo_servicio, PDO::PARAM_INT);
    $sentencia->bindParam(':estado', $estado, PDO::PARAM_INT);
    $sentencia->bindParam(':observacion', $observacion, PDO::PARAM_STR);
    $sentencia->bindParam(':tecnico_tratante', $tecnico_tratante, PDO::PARAM_INT);
    $sentencia->bindParam(':id', $id_usuario, PDO::PARAM_INT);

    // Ejecuta la consulta
if ($sentencia->execute()) {
    // Si la actualización en OST fue exitosa y el estado es 5, actualiza el estado_ticket
    if ($estado == 5) {
        $sql_update_ticket = "UPDATE ost SET estado_ticket = :estado_ticket WHERE id = :id";
        $stmt_update_ticket = $pdo->prepare($sql_update_ticket);
        $nuevo_estado_ticket = 2; // Nuevo valor para estado_ticket
        $stmt_update_ticket->bindParam(':estado_ticket', $nuevo_estado_ticket, PDO::PARAM_INT);
        //$stmt_update_ticket->bindParam(':id_stc', $id_ost, PDO::PARAM_INT); // Asumiendo que $id_ost es el ID del ticket en la tabla stc
        $stmt_update_ticket->execute();
    }

    // Redirige o maneja el mensaje de éxito
    session_start();
    $_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
    header('Location:' . $URL . 'admin/atencion_cliente/ost/index_create.php');
} else {
    // Si hubo un error en la actualización en OST, maneja el mensaje de error
    session_start();
    $_SESSION['msj'] = "Error al introducir la información";
}

    /*
    // Ejecuta la consulta
    if($sentencia->execute()) {
        // Si la inserción en OST fue exitosa, redirige o maneja el mensaje de éxito
        header('Location:' . $URL . 'admin/atencion_cliente/ost/index_create.php');
        session_start();
        $_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
    } else {
        // Si hubo un error en la inserción en OST, maneja el mensaje de error
        session_start();
        $_SESSION['msj'] = "Error al introducir la información";
    } /*
} else {
    // Si no se enviaron los datos del formulario, redirige o maneja el error
    header('Location: ' . $URL . 'ruta/donde/se/visualiza/el/formulario');
}*/


