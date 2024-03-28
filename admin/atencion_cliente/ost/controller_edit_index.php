<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');


/*
$id_stc = $_POST['id_stc'];
$fecha_ost = $_POST['fecha_ingreso'];
$ticket_externo = $_POST['ticket_externo'];
$medio_ingreso = $_POST['medio_ingreso'];
$tipo_servicio = $_POST['tipo_servicio'];
$id_producto = $_POST['id_producto'];
$proyecto = $_POST['proyecto'];
$ciudad = $_POST['ciudad'];
$cliente = $_POST['clientes'];
$falla = $_POST['falla'];
$persona_contacto = $_POST['persona_contacto'];
$medio_contacto = $_POST['email_contacto'];
$estado = $_POST['estado'];
$observacion = $_POST['observacion'];



$sql = "INSERT INTO ost (id_stc, fecha_ost, ticket_externo, medio_ingreso, tipo_servicio, id_producto, proyecto, ciudad, cliente, falla, persona_contacto, email_contacto, estado, observacion) VALUES (:id_stc, :fecha_ost, :ticket_externo, :medio_ingreso, :tipo_servicio, :id_producto, :proyecto, :ciudad, :cliente, :falla, :persona_contacto, :medio_contacto, :estado, :observacion)";



$sentencia = $pdo->prepare($sql);

//$sentencia->bindParam(':sesion_nombre', $sesion_nombre);
//$sentencia->bindParam(':usuario_actual', $usuario_actual);
$sentencia->bindParam(':id_stc', $id_stc);
$sentencia->bindParam(':fecha_ost', $fecha_ost);
$sentencia->bindParam(':medio_ingreso', $medio_ingreso);
$sentencia->bindParam(':ticket_externo', $ticket_externo);
$sentencia->bindParam(':tipo_servicio', $tipo_servicio);
$sentencia->bindParam(':id_producto', $id_producto);
$sentencia->bindParam(':proyecto', $proyecto);
$sentencia->bindParam(':ciudad', $ciudad);
$sentencia->bindParam(':cliente', $cliente);
$sentencia->bindParam(':falla', $falla);
$sentencia->bindParam(':persona_contacto', $persona_contacto);
$sentencia->bindParam(':medio_contacto', $medio_contacto);
$sentencia->bindParam(':estado', $estado);
$sentencia->bindParam(':observacion', $observacion);


if($sentencia->execute()){
    //echo "¡Usuario creado exitosamente!"; // O maneja el mensaje/logica de éxito
    header('Location:' .$URL. 'admin/atencion_cliente/ost');
    session_start();
    $_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
    }else{
        session_start();
        $_SESSION['msj'] = "Error al introducir la información";
        //echo 'Error en las contraseñas, no son iguales';
    }  
*/


// Verifica si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el ID STC y el nuevo valor para tipo_servicio
    $id_stc = $_POST['id_stc'];
    $nuevo_tipo_servicio = 7; // Cambiar según sea necesario

    // Actualiza el tipo de servicio en la tabla STC
    $query_update_stc = $pdo->prepare('UPDATE stc SET tipo_servicio = :nuevo_tipo_servicio WHERE id = :id_stc');
    $query_update_stc->bindParam(':nuevo_tipo_servicio', $nuevo_tipo_servicio);
    $query_update_stc->bindParam(':id_stc', $id_stc);
    $query_update_stc->execute();

    // Obtiene los datos del formulario
    $id_stc = $_POST['id_stc'];
    $fecha_ost = $_POST['fecha_ingreso'];
    $ticket_externo = $_POST['ticket_externo'];
    $medio_ingreso = $_POST['medio_ingreso'];
    $tipo_servicio = $_POST['tipo_servicio'];
    $id_producto = $_POST['id_producto'];
    $proyecto = $_POST['proyecto'];
    $ciudad = $_POST['ciudad'];
    $cliente = $_POST['clientes'];
    $falla = $_POST['falla'];
    $persona_contacto = $_POST['persona_contacto'];
    $medio_contacto = $_POST['email_contacto'];
    $estado = $_POST['estado'];
    $observacion = $_POST['observacion'];

    
    // Inserta los datos en la tabla OST
    $sql = "INSERT INTO ost (id_stc, fecha_ost, ticket_externo, medio_ingreso, tipo_servicio, id_producto, proyecto, ciudad, cliente, falla, persona_contacto, email_contacto, estado, observacion) VALUES (:id_stc, :fecha_ost, :ticket_externo, :medio_ingreso, :tipo_servicio, :id_producto, :proyecto, :ciudad, :cliente, :falla, :persona_contacto, :medio_contacto, :estado, :observacion)";


    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':id_stc', $id_stc);
    $sentencia->bindParam(':fecha_ost', $fecha_ost);
    $sentencia->bindParam(':medio_ingreso', $medio_ingreso);
    $sentencia->bindParam(':ticket_externo', $ticket_externo);
    $sentencia->bindParam(':tipo_servicio', $tipo_servicio);
    $sentencia->bindParam(':id_producto', $id_producto);
    $sentencia->bindParam(':proyecto', $proyecto);
    $sentencia->bindParam(':ciudad', $ciudad);
    $sentencia->bindParam(':cliente', $cliente);
    $sentencia->bindParam(':falla', $falla);
    $sentencia->bindParam(':persona_contacto', $persona_contacto);
    $sentencia->bindParam(':medio_contacto', $medio_contacto);
    $sentencia->bindParam(':estado', $estado);
    $sentencia->bindParam(':observacion', $observacion);



    // Ejecuta la consulta
    if($sentencia->execute()) {
        // Si la inserción en OST fue exitosa, redirige o maneja el mensaje de éxito
        header('Location:' . $URL . 'admin/atencion_cliente/ost');
        session_start();
        $_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
    } else {
        // Si hubo un error en la inserción en OST, maneja el mensaje de error
        session_start();
        $_SESSION['msj'] = "Error al introducir la información";
    }
} else {
    // Si no se enviaron los datos del formulario, redirige o maneja el error
    header('Location: ' . $URL . 'ruta/donde/se/visualiza/el/formulario');
}


