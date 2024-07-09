<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$fecha = $_POST['fecha'];
$producto = $_POST['producto'];
$pitch = !empty($_POST['pitch']) ? $_POST['pitch'] : NULL;
$modelo_modulo1 = !empty($_POST['modelo_modulo1']) ? $_POST['modelo_modulo1'] : NULL;
$marca_control1 = !empty($_POST['marca_control1']) ? $_POST['marca_control1'] : NULL;
$funcion_control = !empty($_POST['funcion_control']) ? $_POST['funcion_control'] : NULL;
$marca_fuente = !empty($_POST['marca_fuente']) ? $_POST['marca_fuente'] : NULL;
$usuario = $_POST['idusuario'];

$sql = "INSERT INTO alma_principal 
        (fecha_ingreso, tipo_producto, pitch, serie_modulo, referencia, modelo_modulo, medida_x, medida_y, marca_control, serie_control, funcion_control, marca_fuente, modelo_fuente, tipo_fuente, voltaje_salida, id_usuario) 
        VALUES (:fecha, :producto, :pitch, :serie_modulo, :referencia_modulo, :modelo_modulo1, :medida_x, :medida_y, :marca_control1, :serie_control, :funcion_control, :marca_fuente, :modelo_fuente, :tipo_fuente, :voltaje_salida, :usuario)";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':fecha', $fecha);
$sentencia->bindParam(':producto', $producto);
$sentencia->bindParam(':pitch', $pitch);
$sentencia->bindParam(':serie_modulo', $serie_modulo);
$sentencia->bindParam(':referencia_modulo', $referencia_modulo);
$sentencia->bindParam(':modelo_modulo1', $modelo_modulo1);
$sentencia->bindParam(':medida_x', $medida_x);
$sentencia->bindParam(':medida_y', $medida_y);
$sentencia->bindParam(':marca_control1', $marca_control1);
$sentencia->bindParam(':serie_control', $serie_control);
$sentencia->bindParam(':funcion_control', $funcion_control);
$sentencia->bindParam(':marca_fuente', $marca_fuente);
$sentencia->bindParam(':modelo_fuente', $modelo_fuente);
$sentencia->bindParam(':tipo_fuente', $tipo_fuente);
$sentencia->bindParam(':voltaje_salida', $voltaje_salida);
$sentencia->bindParam(':usuario', $usuario);

if($sentencia->execute()){
    header('Location:' .$URL. 'admin/almacen/inventario');
    session_start();
    $_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
}else{
    session_start();
    $_SESSION['msj'] = "Error al introducir la información";
}
?>