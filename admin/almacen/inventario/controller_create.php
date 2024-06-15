<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$fecha = $_POST['fecha'];
$producto = $_POST['producto'];
$pitch = $_POST['pitch'];
$serie_modulo = $_POST['serie_modulo'];
$referencia_modulo = $_POST['referencia_modulo'];
$modelo_modulo = $_POST['modelo_modulo'];
$medida_x = $_POST['medida_x'];
$medida_y = $_POST['medida_y'];
$marca_control = $_POST['marca_control'];
$serie_control = $_POST['serie_control'];
$funcion_control = $_POST['funcion_control'];
$marca_fuente = $_POST['marca_fuente'];
$modelo_fuente = $_POST['modelo_fuente'];
$tipo_fuente = $_POST['tipo_fuente'];
$voltaje_salida = $_POST['voltaje_salida'];
$ubicacion_almacen = $_POST['ubicacion_almacen'];


$sql = "INSERT INTO almacen_principal (fecha_ingreso, producto, pitch, serie_modulo, referencia, modelo_modulo, medida_x, medida_y, marca_control, serie_control, funcion_control, marca_fuente, modelo_fuente, tipo_fuente, voltaje_salida, ubicacion_almacen) VALUES (:fecha, :producto, :pitch, :serie_modulo, :referencia_modulo, :modelo_modulo, :medida_x, :medida_y, :marca_control, :serie_control, :funcion_control, :marca_fuente, :modelo_fuente, :tipo_fuente, :voltaje_salida, :ubicacion_almacen)";


$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':fecha', $fecha);
$sentencia->bindParam(':producto', $producto);
$sentencia->bindParam(':pitch', $pitch);
$sentencia->bindParam(':serie_modulo', $serie_modulo);
$sentencia->bindParam(':referencia_modulo', $referencia_modulo);
$sentencia->bindParam(':modelo_modulo', $modelo_modulo);
$sentencia->bindParam(':medida_x', $medida_x);
$sentencia->bindParam(':medida_y', $medida_y);
$sentencia->bindParam(':marca_control', $marca_control);
$sentencia->bindParam(':serie_control', $serie_control);
$sentencia->bindParam(':funcion_control', $funcion_control);
$sentencia->bindParam(':marca_fuente', $marca_fuente);
$sentencia->bindParam(':modelo_fuente', $modelo_fuente);
$sentencia->bindParam(':tipo_fuente', $tipo_fuente);
$sentencia->bindParam(':voltaje_salida', $voltaje_salida);
$sentencia->bindParam(':ubicacion_almacen', $ubicacion_almacen);


if($sentencia->execute()){
//echo "¡Usuario creado exitosamente!"; // O maneja el mensaje/logica de éxito
header('Location:' .$URL. 'admin/almacen/inventario');
session_start();
$_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
}else{
    session_start();
$_SESSION['msj'] = "Error al introducir la información";
    //echo 'Error en las contraseñas, no son iguales';
}

