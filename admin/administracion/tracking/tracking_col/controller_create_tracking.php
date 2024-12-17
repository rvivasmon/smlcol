<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');


$fecha_ingreso = $_POST['fechaingreso'];
$destino_mercancia = $_POST['destinomercancia'];
$tipo_producto = $_POST['tipoproducto'];
//$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];
$obscolombia = $_POST['obscolombia'];
$usuario_operador = $_POST['usuarioperador'];


$sql = "INSERT INTO tracking (date, origin, type, quantitly, usuario, observaciones_colombia) VALUES (:fecha_ingreso, :destino_mercancia, :tipo_producto, :cantidad, :usuario_operador, :obscolombia)";


$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':fecha_ingreso', $fecha_ingreso);
$sentencia->bindParam(':destino_mercancia', $destino_mercancia);
$sentencia->bindParam(':tipo_producto', $tipo_producto);
//$sentencia->bindParam(':descripcion', $descripcion);
$sentencia->bindParam(':cantidad', $cantidad);
$sentencia->bindParam(':obscolombia', $obscolombia);
$sentencia->bindParam(':usuario_operador', $usuario_operador);


if($sentencia->execute()){
//echo "¡Usuario creado exitosamente!"; // O maneja el mensaje/logica de éxito
header('Location:' .$URL. 'admin/administracion/tracking/tracking_col/index_tracking.php');
session_start();
$_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
}else{
    session_start();
$_SESSION['msj'] = "Error al introducir la información";
    //echo 'Error en las contraseñas, no son iguales';
}

