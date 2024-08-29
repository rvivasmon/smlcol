<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$fecha = $_POST['fecha'];
$producto = isset($_POST['producto']) ? $_POST['producto'] : null;
$pitch = !empty($_POST['pitch']) ? $_POST['pitch'] : NULL;
$serie_modulo = !empty($_POST['pitch']) ? $_POST['pitch'] : NULL; // serie_modulo
$referencia_modulo = !empty($_POST['pitch']) ? $_POST['pitch'] : NULL; // referencia_modulo
$modelo_modulo = !empty($_POST['modelo_modulo1']) ? $_POST['modelo_modulo1'] : NULL; 
$marca_control = !empty($_POST['marca_control']) ? $_POST['marca_control'] : NULL;
$referencia_control = !empty($_POST['referencia_control']) ? $_POST['referencia_control'] : NULL;
$funcion_control = !empty($_POST['funcion_control']) ? $_POST['funcion_control'] : NULL;
$marca_fuente = !empty($_POST['marca_fuente']) ? $_POST['marca_fuente'] : NULL;
$modelo_fuente = !empty($_POST['modelo_fuente']) ? $_POST['modelo_fuente'] : NULL;
$tipo_fuente = !empty($_POST['tipo_fuente']) ? $_POST['tipo_fuente'] : NULL;
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
if (!empty($_POST['pitch'])) { // serie_modulo
    $referencia_2 = $_POST['pitch']; // serie_modulo
} elseif (!empty($_POST['referencia_control'])) {
    $referencia_2 = $_POST['referencia_control'];
} elseif (!empty($_POST['modelo_fuente'])) {
    $referencia_2 = $_POST['modelo_fuente'];
} else {
    $referencia_2 = 'default_value'; // Valor por defecto
}

$referencia_21 = !empty($_POST['pitch']) ? $_POST['pitch'] : (!empty($_POST['referencia_control']) ? $_POST['referencia_control'] : $_POST['modelo_fuente']);

// Validaciones para tabla alma_principal
$sql_check_alma_principal = "SELECT * FROM alma_principal WHERE tipo_producto = :producto AND producto = :referencia_21";
$stmt_check_alma_principal = $pdo->prepare($sql_check_alma_principal);
$stmt_check_alma_principal->bindParam(':producto', $producto);
$stmt_check_alma_principal->bindParam(':referencia_21', $referencia_21);
$stmt_check_alma_principal->execute();

if ($stmt_check_alma_principal->rowCount() > 0) {
    // Producto encontrado, actualizar cantidad
    $row = $stmt_check_alma_principal->fetch(PDO::FETCH_ASSOC);
    $nueva_cantidad_plena = $row['cantidad_plena'] - $entrada_md;

    if ($nueva_cantidad_plena < 0) {
        $_SESSION['msj'] = "Cantidad en alma_principal insuficiente.";
    } else {
        // Actualizar cantidad en alma_principal
        $sql_update_alma_principal = "UPDATE alma_principal SET cantidad_plena = :nueva_cantidad_plena WHERE tipo_producto = :producto AND producto = :referencia_21";
        $stmt_update_alma_principal = $pdo->prepare($sql_update_alma_principal);
        $stmt_update_alma_principal->bindParam(':nueva_cantidad_plena', $nueva_cantidad_plena);
        $stmt_update_alma_principal->bindParam(':producto', $producto);
        $stmt_update_alma_principal->bindParam(':referencia_21', $referencia_21);
        $stmt_update_alma_principal->execute();

        $_SESSION['msj'] = "Cantidad actualizada correctamente en alma_principal.";
    }
} else {
    $_SESSION['msj'] = "Producto no encontrado en alma_principal.";
}

// Validaciones para almacen_entrada_md
$almacenes = [
    3 => 'alma_principal',
    4 => 'alma_secundario',
    5 => 'alma_importacion',
    6 => 'alma_tecnica',
    7 => 'alma_planta',
    8 => 'alma_pruebas',
    9 => 'alma_desechados',
    10 => 'alma_soporte_tecnico',
    11 => 'alma_aliados'
];

if (array_key_exists($almacen_entrada_md, $almacenes)) {
    $tabla_destino = $almacenes[$almacen_entrada_md];

    // Validar si el producto está en la tabla de destino
    $sql_check_destino = "SELECT * FROM $tabla_destino WHERE tipo_producto = :producto AND producto = :referencia_21";
    $stmt_check_destino = $pdo->prepare($sql_check_destino);
    $stmt_check_destino->bindParam(':producto', $producto);
    $stmt_check_destino->bindParam(':referencia_21', $referencia_21);
    $stmt_check_destino->execute();

    if ($stmt_check_destino->rowCount() > 0) {
        // Producto encontrado, actualizar existencias
        $sql_update_destino = "UPDATE $tabla_destino SET existencias = existencias + :cantidad WHERE tipo_producto = :producto AND producto = :referencia_21";
        $stmt_update_destino = $pdo->prepare($sql_update_destino);
        $stmt_update_destino->bindParam(':cantidad', $entrada_md);
        $stmt_update_destino->bindParam(':producto', $producto);
        $stmt_update_destino->bindParam(':referencia_21', $referencia_21);
        $stmt_update_destino->execute();

        $_SESSION['msj'] = "Existencias actualizadas correctamente en $tabla_destino.";
    } else {
        // Producto no encontrado, insertar nueva entrada
        $sql_insert_destino = "INSERT INTO $tabla_destino (tipo_producto, producto, existencias) VALUES (:producto, :referencia_21, :cantidad)";
        $stmt_insert_destino = $pdo->prepare($sql_insert_destino);
        $stmt_insert_destino->bindParam(':producto', $producto);
        $stmt_insert_destino->bindParam(':referencia_21', $referencia_21);
        $stmt_insert_destino->bindParam(':cantidad', $entrada_md);
        $stmt_insert_destino->execute();

        $_SESSION['msj'] = "Producto no encontrado en $tabla_destino, se ha creado una nueva entrada.";
    }
}

// Insertar en movimiento_diario
$sql = "INSERT INTO movimiento_diario 
        (fecha, tipo_producto, pitch_modulo, serie_modulo, referencia_modulo, modelo_modulo, marca_control, referencia_control, funcion_control, marc_fuente1, modelo_fuente, tipo_fuente, almacen_origen1, cantidad_salida, almacen_destino1, cantidad_entrada, observaciones, id_usuario, op, referencia_1, referencia_2) 
        VALUES (:fecha, :producto, :pitch, :serie_modulo, :referencia_modulo, :modelo_modulo, :marca_control, :referencia_control, :funcion_control, :marca_fuente, :modelo_fuente, :tipo_fuente, :almacen_salida_md, :salida_md, :almacen_entrada_md, :entrada_md, :observacion, :usuario, :op_destino, :referencia_1, :referencia_2)";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':fecha', $fecha);
$sentencia->bindParam(':producto', $producto);
$sentencia->bindParam(':pitch', $pitch);
$sentencia->bindParam(':serie_modulo', $serie_modulo);
$sentencia->bindParam(':referencia_modulo', $referencia_modulo);
$sentencia->bindParam(':modelo_modulo', $modelo_modulo);
$sentencia->bindParam(':marca_control', $marca_control);
$sentencia->bindParam(':referencia_control', $referencia_control);
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

if ($sentencia->execute()) {
    $_SESSION['msj'] .= " Movimiento registrado correctamente.";
} else {
    $_SESSION['msj'] .= " Error al registrar el movimiento.";
}

header('Location: index.php');
?>
