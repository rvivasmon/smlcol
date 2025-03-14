<?php

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

// Obtener datos del formulario
$fecha = $_POST['fecha'];
$contador_entra = $_POST['contador_entra'] ?? null;
$producto = $_POST['producto'] ?? null;
$serie_modulo = !empty($_POST['serie_modulo']) ? $_POST['serie_modulo'] : null;
$referencia_control = !empty($_POST['referencia_control35']) ? $_POST['referencia_control35'] : null;
$modelo_fuente = !empty($_POST['modelo_fuente35']) ? $_POST['modelo_fuente35'] : null;
$almacen_salida_md = $_POST['almacen_salida_md'];
$salida_md = -abs(floatval($_POST['salida_md'])); // Convierte a flotante y asegura valor negativo
$almacen_entrada_md = $_POST['almacen_entrada_md'];
$entrada_md = abs(floatval($_POST['entrada_md'])); // Convierte a flotante y asegura valor positivo
$observacion = $_POST['observacion'];
$usuario = $_POST['idusuario'];
$op_destino = $_POST['op_destino'];
$posicion = $_POST['posicion1'];


// Asignar referencia_21 para facilitar la validación
$referencia_21 = !empty($serie_modulo) ? $serie_modulo : (!empty($referencia_control) ? $referencia_control : $modelo_fuente);

// Función para realizar las consultas de validación y actualización
function validarProductoEnAlmacen($pdo, $tabla,  $producto, $referencia_21, $salida_md, $almacen_salida_md, $posicion) {
    if ($almacen_salida_md == 4) {
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
        if ($almacen_salida_md == 4) {
            $sql_update = "UPDATE $tabla SET cantidad_plena = cantidad_plena + :salida_md WHERE tipo_producto = :producto AND producto = :referencia_21";
        } else {
            $sql_update = "UPDATE $tabla SET existencias = existencias + :salida_md WHERE tipo_producto = :producto AND producto = :referencia_21";
        }

        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':salida_md', $salida_md);
        $stmt_update->bindParam(':producto', $producto);
        $stmt_update->bindParam(':referencia_21', $referencia_21);
        $stmt_update->execute();

        $_SESSION['msj'] = "Producto encontrado en $producto ($
        ) y actualizado correctamente.";
        return true; // Indica que se encontró y actualizó el producto
    } else {
        // Producto no encontrado, insertar nueva entrada
        if ($almacen_salida_md == 4) {
            $sql_insert = "INSERT INTO $tabla (tipo_producto, producto, cantidad_plena, posicion) VALUES (:producto, :referencia_21, :salida_md, :posicion)";
        } else {
            $sql_insert = "INSERT INTO $tabla (tipo_producto, producto, existencias, posicion) VALUES (:producto, :referencia_21, :salida_md, :posicion)";
        }
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':producto', $producto);
        $stmt_insert->bindParam(':referencia_21', $referencia_21);
        $stmt_insert->bindParam(':salida_md', $salida_md);
        $stmt_insert->bindParam(':posicion', $posicion);
        $stmt_insert->execute();

        $_SESSION['msj'] = "Producto no encontrado en $producto ($tabla), pero se ha creado una nueva entrada y actualizado correctamente.";
        return false; // Indica que no se encontró el producto
    }
}

// Almacenes con sus respectivas tablas
$almacenes = [
    3 => 'alma_smartled',
    4 => 'alma_techled',
    5 => 'alma_importacion',
    6 => 'alma_tecnica',
    7 => 'alma_planta',
    8 => 'alma_pruebas',
    9 => 'alma_desechados',
    10 => 'alma_soporte_tecnico',
    11 => 'alma_aliados'
];

// Validar almacen de salida
if (array_key_exists($almacen_salida_md, $almacenes)) {
    validarProductoEnAlmacen($pdo, $almacenes[$almacen_salida_md], $producto, $referencia_21, $salida_md, $almacen_salida_md, $posicion);
}

try {
    // Guardar la ubicación en alma_smartled si el almacén de entrada es el principal (id 3)
    if ($almacen_entrada_md == 4) {
        $sql_update_posicion = "UPDATE alma_techled SET posicion = :posicion WHERE tipo_producto = :producto AND producto = :referencia_21";
        $stmt_update_posicion = $pdo->prepare($sql_update_posicion);
        $stmt_update_posicion->bindParam(':posicion', $posicion);
        $stmt_update_posicion->bindParam(':producto', $producto);
        $stmt_update_posicion->bindParam(':referencia_21', $referencia_21);
        
        if ($stmt_update_posicion->execute()) {
            echo "Posición actualizada correctamente.";
        } else {
            echo "Error al actualizar la posición.";
        }
    }
} catch (Exception $e) {
    echo "Excepción capturada: " . $e->getMessage();
}


// Validar almacen de entrada
if (array_key_exists($almacen_entrada_md, $almacenes)) {
    validarProductoEnAlmacen($pdo, $almacenes[$almacen_entrada_md], $producto, $referencia_21, $entrada_md, $almacen_entrada_md, $posicion);
}

// Insertar movimiento diario
$sql = "INSERT INTO movimiento_techled 
        (fecha, consecu_entra, tipo_producto, almacen_origen1, cantidad_salida, almacen_destino1, cantidad_entrada, observaciones, id_usuario, op, referencia_2, posicion) 
        VALUES (:fecha, :contador_entra, :producto, :almacen_salida_md, :salida_md, :almacen_entrada_md, :entrada_md, :observacion, :usuario, :op_destino, :referencia_21, :posicion)";

$sentencia = $pdo->prepare($sql);
$sentencia->bindParam(':fecha', $fecha);
$sentencia->bindParam(':contador_entra', $contador_entra);
$sentencia->bindParam(':producto', $producto);
$sentencia->bindParam(':almacen_salida_md', $almacen_salida_md);
$sentencia->bindParam(':salida_md', $salida_md);
$sentencia->bindParam(':almacen_entrada_md', $almacen_entrada_md);
$sentencia->bindParam(':entrada_md', $entrada_md);
$sentencia->bindParam(':observacion', $observacion);
$sentencia->bindParam(':usuario', $usuario);
$sentencia->bindParam(':op_destino', $op_destino);
$sentencia->bindParam(':referencia_21', $referencia_21);
$sentencia->bindParam(':posicion', $posicion);

if ($sentencia->execute()) {
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
            header('Location: ' . $URL . 'admin/almacen/mv_diario/techled');
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
