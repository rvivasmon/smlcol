<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

/*
// Verifica si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el ID STC y el nuevo valor para tipo_servicio
    $id_stc = $_POST['id_1'];
    $nuevo_tipo_servicio = 4; // Cambiar según sea necesario

    // Actualiza el tipo de servicio en la tabla STC
    $query_update_stc = $pdo->prepare('UPDATE stc SET tipo_servicio = :nuevo_tipo_servicio WHERE id = :id_stc');
    $query_update_stc->bindParam(':nuevo_tipo_servicio', $nuevo_tipo_servicio);
    $query_update_stc->bindParam(':id_stc', $id_stc);
    $query_update_stc->execute();

    */

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


