<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$fecha = $_POST['fecha'];
$producto = $_POST['producto2'];
$pitch = !empty($_POST['pitch2']) ? $_POST['pitch2'] : NULL;
$serie_modulo2 = !empty($_POST['serie_modulo2']) ? $_POST['serie_modulo2'] : NULL;
$referencia_modulo = !empty($_POST['referencia_modulo2']) ? $_POST['referencia_modulo2'] : NULL;
$modelo_modulo1 = !empty($_POST['modelo_modulo2']) ? $_POST['modelo_modulo2'] : NULL;
$marca_control1 = !empty($_POST['marca_control2']) ? $_POST['marca_control2'] : NULL;
$serie_control = !empty($_POST['serie_control2']) ? $_POST['serie_control2'] : NULL;
$funcion_control = !empty($_POST['funcion_control2']) ? $_POST['funcion_control2'] : NULL;
$marca_fuente = !empty($_POST['marca_fuente2']) ? $_POST['marca_fuente2'] : NULL;
$modelo_fuente = !empty($_POST['modelo_fuente2']) ? $_POST['modelo_fuente2'] : NULL;
$tipo_fuente = !empty($_POST['tipo_fuente2']) ? $_POST['tipo_fuente2'] : NULL;
$almacen_salida_md = $_POST['almacen_salida_md'];
$salida_md = $_POST['salida_md'];
$almacen_entrada_md = $_POST['almacen_entrada_md'];
$entrada_md = $_POST['entrada_md'];
$observacion = $_POST['observacion'];
$usuario = $_POST['idusuario2'];
$op_destino = $_POST['op_destino'];
$referencia_1 = !empty($_POST['pitch']) ? $_POST['pitch'] : (!empty($_POST['marca_control']) ? $_POST['marca_control'] : $_POST['marca_fuente']);
$referencia_2 = !empty($_POST['serie_modulo2']) ? $_POST['serie_modulo2'] : (!empty($_POST['serie_control2']) ? $_POST['serie_control2'] : $_POST['modelo_fuente2']);


$sql = "INSERT INTO movimiento_diario 
        (fecha, producto, pitch_modulo, serie_modulo, referencia_modulo, modelo_modulo, marca_control, serie_control, funcion_control, marca_fuente, modelo_fuente, tipo_fuente, almacen_origen1, cantidad_salida, almacen_destino1, cantidad_entrada, observaciones, id_usuario, op, referencia_1, referencia_2) 
        VALUES (:fecha, :producto, :pitch, :serie_modulo2, :referencia_modulo, :modelo_modulo1, :marca_control1, :serie_control, :funcion_control, :marca_fuente, :modelo_fuente, :tipo_fuente, :almacen_salida_md, :salida_md, :almacen_entrada_md, :entrada_md, :observacion, :usuario, :op_destino, :referencia_1, :referencia_2)";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':fecha', $fecha);
$sentencia->bindParam(':producto', $producto);
$sentencia->bindParam(':pitch', $pitch);
$sentencia->bindParam(':serie_modulo2', $serie_modulo2);
$sentencia->bindParam(':referencia_modulo', $referencia_modulo);
$sentencia->bindParam(':modelo_modulo1', $modelo_modulo1);
$sentencia->bindParam(':marca_control1', $marca_control1);
$sentencia->bindParam(':serie_control', $serie_control);
$sentencia->bindParam(':funcion_control', $funcion_control);
$sentencia->bindParam(':marca_fuente', $marca_fuente);
$sentencia->bindParam(':modelo_fuente', $modelo_fuente);
$sentencia->bindParam(':tipo_fuente', $tipo_fuente);
$sentencia->bindParam(':almacen_salida_md', $almacen_salida_md);
$sentencia->bindParam(':salida_md', $salida_md);
$sentencia->bindParam(':almacen_entrada_md', $almacen_entrada_md);
$sentencia->bindParam(':entrada_md', $entrada_md);
$sentencia->bindParam(':observacion', $observacion);
$sentencia->bindParam(':usuario', $usuario);
$sentencia->bindParam(':op_destino', $op_destino);
$sentencia->bindParam(':referencia_1', $referencia_1);
$sentencia->bindParam(':referencia_2', $referencia_2);


if($sentencia->execute()){
    header('Location:' .$URL. 'admin/almacen/mv_diario');
    session_start();
    $_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
}else{
    session_start();
    $_SESSION['msj'] = "Error al introducir la información";
}
?>
