<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');


$fecha = $_POST['fecha'];
$producto = isset($_POST['producto']) ? $_POST['producto'] : null;
$serie_modulo = !empty($_POST['pitch']) ? $_POST['pitch'] : NULL; //serie_modulo
$referencia_control = !empty($_POST['referencia_control']) ? $_POST['referencia_control'] : NULL;
$modelo_fuente = !empty($_POST['modelo_fuente']) ? $_POST['modelo_fuente'] : NULL;
$almacen_salida_md = $_POST['almacen_salida_md'];
$salida_md = -abs(floatval($_POST['salida_md'])); // Convierte a flotante y aplica abs()
$almacen_entrada_md = $_POST['almacen_entrada_md'];
$entrada_md = abs(floatval($_POST['entrada_md'])); // Convierte a flotante y aplica abs()
$observacion = $_POST['observacion'];
$usuario = $_POST['idusuario'];
$op_destino = $_POST['op_destino'];

// Lógica para asignar referencia_1
if (!empty($_POST['pitch'])) {
    $referencia_1 = $_POST['pitch'];
} elseif (!empty($_POST['marca_control'])) {
    $referencia_1 = $_POST['marca_control'];
} elseif (!empty($_POST['marca_fuente'])) {
    $referencia_1 = $_POST['marca_fuente'];
} else {
    $referencia_1 = 'default_value'; // Valor por defecto
}

// Lógica para asignar referencia_2
if (!empty($_POST['pitch'])) { //serie_modulo
    $referencia_2 = $_POST['pitch']; //serie_modulo
} elseif (!empty($_POST['referencia_control'])) {
    $referencia_2 = $_POST['referencia_control'];
} elseif (!empty($_POST['modelo_fuente'])) {
    $referencia_2 = $_POST['modelo_fuente'];
} else {
    $referencia_2 = 'default_value'; // Valor por defecto
}

$referencia_21 = !empty($_POST['pitch'/*serie_modulo*/]) ? $_POST['pitch'/*serie_modulo*/] : (!empty($_POST['referencia_control']) ? $_POST['referencia_control'] : $_POST['modelo_fuente']);

// Función para realizar las consultas de validación y actualización
function validarProductoEnAlmacen($pdo, $tabla,  $producto, $referencia_21, $salida_md, $almacen_salida_md) {
    if ($almacen_salida_md == 3) {
        // Si el almacén es el principal, comparar con id_almacen_principal
        $sql_check = "SELECT * FROM $tabla WHERE tipo_producto = :producto AND producto = :referencia_21";
    } else {
        // Comparar con tipo_producto para los demás almacenes
        $sql_check = "SELECT * FROM $tabla WHERE tipo_producto = :producto AND producto = :referencia_21";
    }
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(':producto', $producto);
    $stmt_check->bindParam(':referencia_21', $referencia_21);
    $stmt_check->execute();

    if ($stmt_check->rowCount() > 0) {
        // Producto encontrado, actualizar existencias
        if ($almacen_salida_md == 3) {
            $sql_update = "UPDATE $tabla SET cantidad_plena = cantidad_plena + :salida_md WHERE tipo_producto = :producto AND producto = :referencia_21";
        } else {
            $sql_update = "UPDATE $tabla SET existencias = existencias + :salida_md WHERE tipo_producto = :producto AND producto = :referencia_21";
        }

        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':salida_md', $salida_md);
        $stmt_update->bindParam(':producto', $producto);
        $stmt_update->bindParam(':referencia_21', $referencia_21);
        $stmt_update->execute();

        $_SESSION['msj'] = "Producto encontrado en $producto ($tabla) y actualizado correctamente.";
        return true; // Indica que se encontró y actualizó el producto
    } else {
        // Producto no encontrado, insertar nueva entrada
        if ($almacen_salida_md == 3) {
            $sql_insert = "INSERT INTO $tabla (tipo_producto, producto, cantidad_plena) VALUES (:producto, :referencia_21, :salida_md)";
        } else {
            $sql_insert = "INSERT INTO $tabla (tipo_producto, producto, existencias) VALUES (:producto, :referencia_21, :salida_md)";
        }
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':producto', $producto);
        $stmt_insert->bindParam(':referencia_21', $referencia_21);
        $stmt_insert->bindParam(':salida_md', $salida_md);
        $stmt_insert->execute();

        $_SESSION['msj'] = "Producto no encontrado en $producto ($tabla), pero se ha creado una nueva entrada y actualizado correctamente.";
        return false; // Indica que no se encontró el producto
    }
}

// Validaciones para almacen_salida_md
$almacenes = [
    3 => 'alma_principal',
    4 => 'alma_techled',
    5 => 'alma_importacion',
    6 => 'alma_tecnica',
    7 => 'alma_planta',
    8 => 'alma_pruebas',
    9 => 'alma_desechados',
    10 => 'alma_soporte_tecnico',
    11 => 'alma_aliados'
];

if (array_key_exists($almacen_salida_md, $almacenes)) {
    validarProductoEnAlmacen($pdo, $almacenes[$almacen_salida_md], $producto, $referencia_21, $salida_md, $almacen_salida_md);
}

// Validaciones para almacen_entrada_md
if (array_key_exists($almacen_entrada_md, $almacenes)) {
    validarProductoEnAlmacen($pdo, $almacenes[$almacen_entrada_md], $producto, $referencia_21, $entrada_md, $almacen_entrada_md);
}

$sql = "INSERT INTO movimiento_diario 
        (fecha, tipo_producto, serie_modulo, referencia_control, modelo_fuente, almacen_origen1, cantidad_salida, almacen_destino1, cantidad_entrada, observaciones, id_usuario, op, referencia_1, referencia_2) 
        VALUES (:fecha, :producto, :serie_modulo, :referencia_control, :modelo_fuente, :almacen_salida_md, :salida_md, :almacen_entrada_md, :entrada_md, :observacion, :usuario, :op_destino, :referencia_1, :referencia_2)";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':fecha', $fecha);
$sentencia->bindParam(':producto', $producto);
$sentencia->bindParam(':serie_modulo', $serie_modulo);
$sentencia->bindParam(':referencia_control', $referencia_control);
$sentencia->bindParam(':modelo_fuente', $modelo_fuente);
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
    // Preparar la consulta para alma_total
    $sql2 = "INSERT INTO alma_total (fecha_movimiento, tipo_producto, producto, salio, entro, ";

    // Campos para salida
    switch ($almacen_salida_md) {
        case 3:
            $sql2 .= "id_principal";
            break;
        case 4:
            $sql2 .= "id_techled";
            break;
        case 5:
            $sql2 .= "importacion";
            break;
        case 6:
            $sql2 .= "id_tecnica";
            break;
        case 7:
            $sql2 .= "id_planta";
            break;
        case 8:
            $sql2 .= "id_pruebas";
            break;
        case 9:
            $sql2 .= "id_desechados";
            break;
        case 10:
            $sql2 .= "id_soporte_tecnico";
            break;
        case 11:
            $sql2 .= "id_aliados";
            break;
        default:
            $sql2 .= "id_principal"; // Campo por defecto
            break;
    }

    // Campos para entrada
    switch ($almacen_entrada_md) {
        case 3:
            $sql2 .= ", id_principal";
            break;
        case 4:
            $sql2 .= ", id_techled";
            break;
        case 5:
            $sql2 .= ", importacion";
            break;
        case 6:
            $sql2 .= ", id_tecnica";
            break;
        case 7:
            $sql2 .= ", id_planta";
            break;
        case 8:
            $sql2 .= ", id_pruebas";
            break;
        case 9:
            $sql2 .= ", id_desechados";
            break;
        case 10:
            $sql2 .= ", id_soporte_tecnico";
            break;
        case 11:
            $sql2 .= ", id_aliados";
            break;
        default:
            $sql2 .= ", id_principal"; // Campo por defecto
            break;
    }

    $sql2 .= ") VALUES (:fecha, :producto, :referencia_21, :salida_md, :entrada_md, :salida_md, :entrada_md)";

    $sentencia_almacen = $pdo->prepare($sql2);

    $sentencia_almacen->bindParam(':fecha', $fecha);
    $sentencia_almacen->bindParam(':producto', $producto);
    $sentencia_almacen->bindParam(':referencia_21', $referencia_21);
    $sentencia_almacen->bindParam(':salida_md', $salida_md);
    $sentencia_almacen->bindParam(':entrada_md', $entrada_md);

    if($sentencia_almacen->execute()){
        // Actualizar las existencias
        $sql3 = "UPDATE alma_total SET existen_entra = existen_entra + :entrada_md - :salida_md WHERE tipo_producto = :producto AND producto = :referencia_21";
        $sentencia_existencia = $pdo->prepare($sql3);
        $sentencia_existencia->bindParam(':entrada_md', $entrada_md);
        $sentencia_existencia->bindParam(':salida_md', $salida_md);
        $sentencia_existencia->bindParam(':producto', $producto);
        $sentencia_existencia->bindParam(':referencia_21', $referencia_21);

        if ($sentencia_existencia->execute()) {
            global $URL;
            header('Location: ' . $URL . 'admin/almacen/mv_diario');
            $_SESSION['msj'] = "Se ha registrado el movimiento de manera correcta y actualizado las existencias";
            exit;
        } else {
            $_SESSION['msj'] = "Error al actualizar las existencias";
        }
    } else {
        $_SESSION['msj'] = "Error al introducir la información en alma_total";
    }
} else {
    $_SESSION['msj'] = "Error al ejecutar la consulta de movimiento_diario";
}

// Si llega aquí, algo salió mal en alguna parte
global $URL;
header('Location: ' . $URL . 'ruta_de_error'); // Ajusta 'ruta_de_error' a donde quieras redirigir en caso de error
exit;

?>
