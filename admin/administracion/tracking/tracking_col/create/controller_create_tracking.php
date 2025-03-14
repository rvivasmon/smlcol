<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');


$fecha_ingreso = $_POST['fecha'];
$solicitante = $_POST['solicitante'];
$codigo_generado = $_POST['codigo_generado'];
$contador_colombia = $_POST['contador'];
$origen = $_POST['origen'];
$tipo_producto = $_POST['producto1'];
$uso = $_POST['uso'];
$usuario_operador = $_POST['idusuario'];
$pitch = $_POST['pitch'];
$serie_modulo = $_POST['serie_modulo'];
$referencia_modulo = $_POST['referencia_modulo'];
$marca_control = $_POST['marca_control'];
$referencia_control35 = $_POST['referencia_control35'];
$marca_fuente = $_POST['marca_fuente'];
$modelo_fuente35 = $_POST['modelo_fuente35'];
$cantidad = $_POST['cantidad'];
$obscolombia = $_POST['observacion'];
$ano_mes = $_POST['ano_mes'];



$sql = "INSERT INTO tracking (date, solicitante, codigo_generado, ano_mes, contador_colombia, origen_solicitud, type, category, pich, serie_modulo, ref_modulo, marc_control, ref_control, marca_fuente, modelo_fuente, quantitly, usuario, observaciones_colombia) VALUES (:fecha_ingreso, :solicitante, :codigo_generado, :ano_mes, :contador_colombia, :origen, :tipo_producto, :uso, :pich, :serie_modulo, :ref_modulo, :marc_control, :referencia_control35, :marca_fuente, :modelo_fuente35, :cantidad, :usuario_operador, :obscolombia)";


$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':fecha_ingreso', $fecha_ingreso);
$sentencia->bindParam(':solicitante', $solicitante);
$sentencia->bindParam(':codigo_generad', $codigo_generad);
$sentencia->bindParam(':contador_colombia', $contador_colombia);
$sentencia->bindParam(':origen', $origen);
$sentencia->bindParam(':tipo_producto', $tipo_producto);
$sentencia->bindParam(':uso', $uso);
$sentencia->bindParam(':pich', $pich);
$sentencia->bindParam(':serie_modulo', $serie_modulo);
$sentencia->bindParam(':ref_modulo', $ref_modulo);
$sentencia->bindParam(':marc_control', $marc_control);
$sentencia->bindParam(':referencia_control35', $referencia_control35);
$sentencia->bindParam(':marca_fuente', $marca_fuente);
$sentencia->bindParam(':modelo_fuente35', $modelo_fuente35);
$sentencia->bindParam(':cantidad', $cantidad);
$sentencia->bindParam(':usuario_operador', $usuario_operador);
$sentencia->bindParam(':obscolombia', $obscolombia);
$sentencia->bindParam(':ano_mes', $ano_mes);


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

