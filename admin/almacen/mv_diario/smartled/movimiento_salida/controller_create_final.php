<?php

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');
include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

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
    error_log("Error: Los datos enviados no son consistentes. Productos: " . json_encode($productos), 3, 'error.log');
    $_SESSION['msj'] = 'Error: Los datos enviados no son consistentes.';
    header("Location: create_movimiento_salida_final.php");
    exit;
}

// Función para validar y actualizar/insertar producto en almacenes
function validarProductoEnAlmacen($pdo, $tabla, $producto, $referencia_21, $cantidad, $almacen_salida_md) {
    $campo_cantidad = ($tabla === 'alma_principal' || $tabla === 'alma_techled') ? 'cantidad_plena' : 'existencias';
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

    // Si el almacén de salida es 3 o "alma_principal", insertamos en movimiento_diario
    if ($almacen_salida_md == 3 || $almacen_salida_md == 'alma_principal') {
        // Preparar datos de movimiento para la inserción
        $datos_movimiento = [
            ':fecha' => $fecha,
            ':producto' => $producto,
            ':almacen_salida_md' => $almacen_salida_md,
            ':salida_md' => $salida_md,
            ':almacen_entrada_md' => $almacen_entrada_md,
            ':entrada_md' => $entrada_md,
            ':observacion' => $observacion,
            ':usuario' => $usuario,
            ':op_destino' => $op_destino,
            ':referencia_21' => $referencia_21,
            ':contador_salida' => $contador_salida, // Agregar contador_salida
        ];

        // Insertar en movimiento_diario
        $sql_movimiento_diario = "INSERT INTO movimiento_diario 
            (fecha, tipo_producto, referencia_2, almacen_origen1, cantidad_salida, almacen_destino1, cantidad_entrada, observaciones, id_usuario, op, consecu_sale) 
            VALUES (:fecha, :producto, :referencia_21, :almacen_salida_md, :salida_md, :almacen_entrada_md, :entrada_md, :observacion, :usuario, :op_destino, :contador_salida)";
        
        $stmt_diario = $pdo->prepare($sql_movimiento_diario);
        if (!$stmt_diario->execute($datos_movimiento)) {
            error_log("Error al insertar en movimiento_diario: " . implode(", ", $stmt_diario->errorInfo()), 3, 'error.log');
            $_SESSION['msj'] = 'Error al insertar en movimiento_diario.';
            header("Location: create_movimiento_salida_final.php");
            exit;
        }
    }

    // Solo insertar en movimiento_techled si el almacén de entrada es 4 o "alma_techled"
    if ($almacen_entrada_md == 4 || $almacen_entrada_md == 'alma_techled') {
        // Obtener el último valor de 'consecu_entra' de la tabla 'movimiento_techled' y aumentarlo en 1
        $sql_last_consecu = "SELECT MAX(consecu_entra) AS last_consecu FROM movimiento_techled";
        $stmt_consecu = $pdo->prepare($sql_last_consecu);
        $stmt_consecu->execute();
        $result = $stmt_consecu->fetch(PDO::FETCH_ASSOC);
        $last_consecu = $result['last_consecu'];
        $consecu_entra = $last_consecu + 1;

        // Preparar datos de movimiento para la inserción en movimiento_techled
        $datos_techled = [
            ':fecha' => $fecha,
            ':producto' => $producto,
            ':almacen_salida_md' => $almacen_salida_md,
            ':salida_md' => $salida_md,
            ':almacen_entrada_md' => $almacen_entrada_md,
            ':entrada_md' => $entrada_md,
            ':observacion' => $observacion,
            ':usuario' => $usuario,
            ':op_destino' => $op_destino,
            ':referencia_21' => $referencia_21,
            ':consecu_entra' => $consecu_entra, // Usamos el valor incrementado
        ];

        // Insertar en movimiento_techled
        $sql_movimiento_techled = "INSERT INTO movimiento_techled 
            (fecha, tipo_producto, referencia_2, almacen_origen1, cantidad_salida, almacen_destino1, cantidad_entrada, observaciones, id_usuario, op, consecu_entra) 
            VALUES (:fecha, :producto, :referencia_21, :almacen_salida_md, :salida_md, :almacen_entrada_md, :entrada_md, :observacion, :usuario, :op_destino, :consecu_entra)";
        
        $stmt_techled = $pdo->prepare($sql_movimiento_techled);
        if (!$stmt_techled->execute($datos_techled)) {
            error_log("Error al insertar en movimiento_techled: " . implode(", ", $stmt_techled->errorInfo()), 3, 'error.log');
            $_SESSION['msj'] = 'Error al insertar en movimiento_techled.';
            header("Location: create_movimiento_salida_final.php");
            exit;
        }
    }

    // Validar producto en el almacén de salida (función usada en ambos casos)
    if (array_key_exists($almacen_salida_md, $almacenes)) {
        validarProductoEnAlmacen($pdo, $almacenes[$almacen_salida_md], $producto, $referencia_21, $salida_md, $almacen_salida_md);
    }

    // Validar producto en el almacén de entrada (función usada en ambos casos)
    if (array_key_exists($almacen_entrada_md, $almacenes)) {
        validarProductoEnAlmacen($pdo, $almacenes[$almacen_entrada_md], $producto, $referencia_21, $entrada_md, $almacen_entrada_md);
    }
}

// Redirigir después de la operación
header("Location: create_movimiento_salida_final.php");
exit;
?>
