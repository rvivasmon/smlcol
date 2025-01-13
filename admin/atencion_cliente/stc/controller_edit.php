<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$id_usuario = $_POST['id_usuario'];
$id_stc = $_POST['idstc'];
$fecha_ingreso = $_POST['fechaingreso'];
$medio_ingreso = $_POST['medioingreso'];
$ticket_externo = $_POST['ticketexterno'];
$servicio = $_POST['tiposervicio'];
$id_producto = $_POST['idproducto'];
$falla = $_POST['falla'];
$observacion = $_POST['observacion'];
$cliente = $_POST['idcliente'];
$ciudad = $_POST['idciudad'];
$proyecto = $_POST['proyecto'];
$estado = $_POST['idestado'];
$persona_contacto = $_POST['personacontacto'];
$medio_contacto = $_POST['medio_contacto'];
$evidencia = $_POST['archivo_adjunto'];

$sql = "UPDATE stc 
        SET id_stc = :id_stc, 
            fecha_ingreso = :fecha_ingreso, 
            medio_ingreso = :medio_ingreso, 
            ticket_externo = :ticket_externo, 
            tipo_servicio = :servicio, 
            id_producto = :id_producto, 
            falla = :falla, 
            observacion = :observacion, 
            cliente = :cliente, 
            ciudad = :ciudad, 
            proyecto = :proyecto, 
            estado = :estado, 
            persona_contacto = :persona_contacto, 
            email_contacto = :medio_contacto, 
            evidencias = :evidencia 
        WHERE id = :id_usuario";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_usuario', $id_usuario);
$sentencia->bindParam(':id_stc', $id_stc);
$sentencia->bindParam(':fecha_ingreso', $fecha_ingreso);
$sentencia->bindParam(':medio_ingreso', $medio_ingreso);
$sentencia->bindParam(':ticket_externo', $ticket_externo);
$sentencia->bindParam(':servicio', $servicio);
$sentencia->bindParam(':id_producto', $id_producto);
$sentencia->bindParam(':falla', $falla);
$sentencia->bindParam(':observacion', $observacion);
$sentencia->bindParam(':cliente', $cliente);
$sentencia->bindParam(':ciudad', $ciudad);
$sentencia->bindParam(':proyecto', $proyecto);
$sentencia->bindParam(':estado', $estado);
$sentencia->bindParam(':persona_contacto', $persona_contacto);
$sentencia->bindParam(':medio_contacto', $medio_contacto);
$sentencia->bindParam(':evidencia', $evidencia);

if ($sentencia->execute()) {
    // Si el estado es igual a "5", actualiza el campo "estado_ticket" a "2"
    if ($estado == "5") {
        $sql_estado_ticket = "UPDATE stc SET estado_ticket = 2 WHERE id = :id_usuario";
        $sentencia_estado_ticket = $pdo->prepare($sql_estado_ticket);
        $sentencia_estado_ticket->bindParam(':id_usuario', $id_usuario);
        
        if (!$sentencia_estado_ticket->execute()) {
            // Manejo de errores si no se puede actualizar el estado_ticket
            $errorInfo = $sentencia_estado_ticket->errorInfo();
            echo "Error al actualizar estado_ticket: " . $errorInfo[2];
            exit; // Detén la ejecución en caso de error
        }
    }

    echo "Usuario actualizado exitosamente"; // Mensaje de éxito
    header('Location:' .$URL.'admin/atencion_cliente/stc');
} else {
    // Maneja los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
    echo "Error al actualizar el usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}

?>
