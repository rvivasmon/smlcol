<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

// Obtener datos del formulario
$fecha = $_POST['fecha'];
$contador_entra = $_POST['contador_entra'] ?? null;
$producto = $_POST['producto'] ?? null;
$serie_modulo = !empty($_POST['serie_modulo']) ? $_POST['serie_modulo'] : null;
$referencia_control = !empty($_POST['referencia_control35']) ? $_POST['referencia_control35'] : null;
$modelo_fuente = !empty($_POST['modelo_fuente35']) ? $_POST['modelo_fuente35'] : null;
$almacen_salida_md = $_POST['almacen_salida_md'];
$almacen_entrada_md = $_POST['almacen_entra'];
$entrada_md = abs(floatval($_POST['entrada_md'])); // Convierte a flotante y asegura valor positivo
$observacion = $_POST['observacion'];
$usuario = $_POST['idusuario'];
$op_destino = $_POST['op_destino'];
$bodega = $_POST['bodega'];
$sub_almacen = $_POST['sub_almacen'];

// Asignar referencia_21 para facilitar la validación
$referencia_21 = !empty($serie_modulo) ? $serie_modulo : (!empty($referencia_control) ? $referencia_control : $modelo_fuente);

// Insertar movimiento diario
$sql = "INSERT INTO movimiento_admon 
        (fecha, consecu_entra, tipo_producto, almacen_origen1, almacen_destino1, cantidad_entrada, observaciones, id_usuario, op, referencia_2, bodega, sub_almacen) 
        VALUES (:fecha, :contador_entra, :producto, :almacen_salida_md, :almacen_entrada_md, :entrada_md, :observacion, :usuario, :op_destino, :referencia_21, :bodega, :sub_almacen)";

$sentencia = $pdo->prepare($sql);
$sentencia->bindParam(':fecha', $fecha);
$sentencia->bindParam(':contador_entra', $contador_entra);
$sentencia->bindParam(':producto', $producto);
$sentencia->bindParam(':almacen_salida_md', $almacen_salida_md);
$sentencia->bindParam(':almacen_entrada_md', $almacen_entrada_md);
$sentencia->bindParam(':entrada_md', $entrada_md);
$sentencia->bindParam(':observacion', $observacion);
$sentencia->bindParam(':usuario', $usuario);
$sentencia->bindParam(':op_destino', $op_destino);
$sentencia->bindParam(':referencia_21', $referencia_21);
$sentencia->bindParam(':bodega', $bodega);
$sentencia->bindParam(':sub_almacen', $sub_almacen);

        if ($sentencia->execute()) {
            global $URL;
            header('Location: ' . $URL . 'admin/administracion/admon/ingreso_mercancia');
            $_SESSION['msj'] = "Se ha registrado el movimiento de manera correcta y actualizado las existencias";
            exit;
        } else {
            $_SESSION['msj'] = "Error al actualizar las existencias";
        }

// Si llega aquí, algo salió mal en alguna parte
global $URL;
header('Location: ' . $URL . 'ruta_de_error'); // Ajusta 'ruta_de_error' a donde quieras redirigir en caso de error
exit;
?>
