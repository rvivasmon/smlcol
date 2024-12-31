<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');


// Obtener datos del formulario
$fecha = $_POST['fecha'] ?? null;
$contador_salida = $_POST['contador_sale'] ?? null;
$almacen_entrada_md = $_POST['almacen_entrada_md'] ?? null;
$op_destino = $_POST['op_destino'] ?? null;
$usuario = $_POST['idusuario'] ?? null;
$productos = $_POST['producto_id12'] ?? []; 
$observaciones = $_POST['observacion2'] ?? [];
$referencias_21 = $_POST['referencia_id12'] ?? [];
$almacen_salida_md = $_POST['almacen_salida_md'] ?? null;
$salidas_md = $_POST['cantidad1'] ?? [];
$entradas_md = $_POST['cantidad1'] ?? [];

// Validar que los arrays no estén vacíos y tengan la misma cantidad de elementos
if (empty($productos) || count($productos) !== count($observaciones) || count($productos) !== count($referencias_21) || count($productos) !== count($salidas_md) || count($productos) !== count($entradas_md)) {
    $_SESSION['msj'] = 'Error: Los datos enviados no son consistentes.';
    header("Location: create_movimiento_salida_final.php");
    exit;
}

// Función para validar y actualizar/insertar producto en almacenes
function validarProductoEnAlmacen($pdo, $tabla, $producto, $referencia_21, $cantidad, $almacen_salida_md) {
    $campo_cantidad = ($almacen_salida_md == 3) ? 'cantidad_plena' : 'existencias';
    $sql_check = "SELECT * FROM $tabla WHERE tipo_producto = :producto AND producto = :referencia_21";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(':producto', $producto);
    $stmt_check->bindParam(':referencia_21', $referencia_21);
    $stmt_check->execute();

    if ($stmt_check->rowCount() > 0) {
        // Producto encontrado, actualizar existencias
        $sql_update = "UPDATE $tabla SET $campo_cantidad = $campo_cantidad + :cantidad WHERE tipo_producto = :producto AND producto = :referencia_21";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':cantidad', $cantidad);
        $stmt_update->bindParam(':producto', $producto);
        $stmt_update->bindParam(':referencia_21', $referencia_21);
        $stmt_update->execute();

        $_SESSION['msj'] = "Producto encontrado en $producto ($tabla) y actualizado correctamente.";
        return true;
    } else {
        // Producto no encontrado, insertar nuevo registro
        $sql_insert = "INSERT INTO $tabla (tipo_producto, producto, $campo_cantidad) VALUES (:producto, :referencia_21, :cantidad)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':producto', $producto);
        $stmt_insert->bindParam(':referencia_21', $referencia_21);
        $stmt_insert->bindParam(':cantidad', $cantidad);
        $stmt_insert->execute();

        $_SESSION['msj'] = "Producto no encontrado en $producto ($tabla), se ha creado una nueva entrada.";
        return false;
    }
}

// Almacenes con sus respectivas tablas
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

// Bucle para procesar los productos
for ($i = 0; $i < count($productos); $i++) {
    $producto = $productos[$i];
    $observacion = $observaciones[$i];
    $referencia_21 = $referencias_21[$i];
    $salida_md = -abs(floatval($salidas_md[$i]));  // Asegúrate de que el valor sea negativo para salida
    $entrada_md = abs(floatval($entradas_md[$i])); // Asegúrate de que el valor sea positivo para entrada

    // Validar producto en el almacén de salida
    if (array_key_exists($almacen_salida_md, $almacenes)) {
        validarProductoEnAlmacen($pdo, $almacenes[$almacen_salida_md], $producto, $referencia_21, $salida_md, $almacen_salida_md);
    }

    // Validar producto en el almacén de entrada
    if (array_key_exists($almacen_entrada_md, $almacenes)) {
        validarProductoEnAlmacen($pdo, $almacenes[$almacen_entrada_md], $producto, $referencia_21, $entrada_md, $almacen_entrada_md);
    }

    // Insertar movimiento diario
    $sql = "INSERT INTO movimiento_diario 
            (fecha, consecu_sale, tipo_producto, almacen_origen1, cantidad_salida, almacen_destino1, cantidad_entrada, observaciones, id_usuario, op, referencia_2) 
            VALUES (:fecha, :contador_salida, :producto, :almacen_salida_md, :salida_md, :almacen_entrada_md, :entrada_md, :observacion, :usuario, :op_destino, :referencia_21)";
    
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':contador_salida', $contador_salida);
    $sentencia->bindParam(':producto', $producto);
    $sentencia->bindParam(':almacen_salida_md', $almacen_salida_md);
    $sentencia->bindParam(':salida_md', $salida_md);
    $sentencia->bindParam(':almacen_entrada_md', $almacen_entrada_md);
    $sentencia->bindParam(':entrada_md', $entrada_md);
    $sentencia->bindParam(':observacion', $observacion);
    $sentencia->bindParam(':usuario', $usuario);
    $sentencia->bindParam(':op_destino', $op_destino);
    $sentencia->bindParam(':referencia_21', $referencia_21);

    try {
        $sentencia->execute();
    } catch (PDOException $e) {
        error_log("Error al guardar registro (Producto: $producto): " . $e->getMessage(), 3, 'error.log');
        $_SESSION['msj'] = 'Error al guardar los registros. Por favor, intente nuevamente.';
        header("Location: create_movimiento_salida_final.php");
        exit;
    }
}

// Mensaje de éxito
$_SESSION['msj'] = 'Movimientos registrados con éxito.';
header("Location: create_movimiento_salida_final.php");
exit;

?>