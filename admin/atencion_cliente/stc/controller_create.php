<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');


//$id = $_POST['id'];
$id_stc = $_POST['idstc'];
$fecha_ingreso = $_POST['fechaingreso'];
$medio_ingreso = $_POST['medio_ingreso'];
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
$anio_mes = $_POST['anio_mes'];
$contador = $_POST['contador'];

$sql = "INSERT INTO stc (id_stc, fecha_ingreso, medio_ingreso, ticket_externo, tipo_servicio, id_producto, falla, observacion, cliente, ciudad, proyecto, estado, persona_contacto, email_contacto, anio_mes, contador) VALUES (:id_stc, :fechaingreso, :medio_ingreso, :ticket_externo, :servicio, :id_producto, :falla, :observacion, :cliente, :ciudad, :proyecto, :estado, :persona_contacto, :medio_contacto, :anio_mes, :contador)";


$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':id_stc', $id_stc);
$sentencia->bindParam(':fechaingreso', $fecha_ingreso);
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
$sentencia->bindParam(':anio_mes', $anio_mes);
$sentencia->bindParam(':contador', $contador);

if($sentencia->execute()){
//echo "¡Usuario creado exitosamente!"; // O maneja el mensaje/logica de éxito
header('Location:' .$URL. 'admin/atencion_cliente/stc');
session_start();
$_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
}else{
    session_start();
$_SESSION['msj'] = "Error al introducir la información";
    //echo 'Error en las contraseñas, no son iguales';
}

