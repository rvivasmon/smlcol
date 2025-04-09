<?php

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');
include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');


/*/COODIGO PARA VISUALIZAR LO QUE LLEGA AL CONTROLLER POR METODO POST

echo "<pre>";
print_r($_POST);
echo "</pre>";
exit;

*/


try {
    // Iniciar transacción
    $pdo->beginTransaction();

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
    $sub_almacen = $_POST['sub_almacen'] ?? [];
    $separar_material = !empty($_POST['articuloSeleccionado']) ? $_POST['articuloSeleccionado'] : [0];
    $tecnico_recibe = $_POST['tecnico_recibe'] ?? null;

    // Validar que los arrays sean consistentes
    if (
        empty($productos) ||
        count($productos) !== count($observaciones) ||
        count($productos) !== count($referencias_21) ||
        count($productos) !== count($salidas_md) ||
        count($productos) !== count($entradas_md)
    ) {
        throw new Exception("Error: Los datos enviados no son consistentes.");
    }

    // Función para actualizar el inventario
    function actualizarInventario($pdo, $tabla, $producto, $referencia_21, $cantidad, $sub_almacen) {
        $campo_cantidad = ($tabla === 'alma_smartled' || $tabla === 'alma_techled') ? 'cantidad_plena' : 'existencias';

        // Verificar si el producto ya existe en el inventario con los tres criterios
        $sql_verificar = "SELECT $campo_cantidad FROM $tabla 
                            WHERE tipo_producto = :producto 
                            AND producto = :referencia_21 
                            AND sub_almacen = :sub_almacen";
        $stmt = $pdo->prepare($sql_verificar);
        $stmt->execute([
            ':producto' => $producto,
            ':referencia_21' => $referencia_21,
            ':sub_almacen' => $sub_almacen
        ]);

        if ($stmt->rowCount() > 0) {
            // Si existe, actualizar la cantidad
            $sql_update = "UPDATE $tabla 
                            SET $campo_cantidad = $campo_cantidad + :cantidad 
                            WHERE tipo_producto = :producto 
                            AND producto = :referencia_21 
                            AND sub_almacen = :sub_almacen";
            $stmt_update = $pdo->prepare($sql_update);
            return $stmt_update->execute([
                ':cantidad' => $cantidad,
                ':producto' => $producto,
                ':referencia_21' => $referencia_21,
                ':sub_almacen' => $sub_almacen
            ]);
        } else {
            // Si no existe, insertar un nuevo registro
            $sql_insert = "INSERT INTO $tabla (tipo_producto, producto, $campo_cantidad, sub_almacen) 
                            VALUES (:producto, :referencia_21, :cantidad, :sub_almacen)";
            $stmt_insert = $pdo->prepare($sql_insert);
            return $stmt_insert->execute([
                ':producto' => $producto,
                ':referencia_21' => $referencia_21,
                ':cantidad' => $cantidad,
                ':sub_almacen' => $sub_almacen
            ]);
        }
    }

    // Relación de almacenes con sus tablas
    $almacenes = [
        3 => 'alma_smartled',
        4 => 'alma_techled',
        5 => 'alma_importacion',
        6 => 'alma_tecnica',
        7 => 'alma_planta',
        8 => 'alma_pruebas',
        9 => 'alma_desechados',
        10 => 'alma_soporte_tecnico',
        11 => 'alma_aliados',
        12 => 'alma_china'
    ];

    // Procesar cada producto
    for ($i = 0; $i < count($productos); $i++) {
        $producto = $productos[$i];
        $observacion = $observaciones[$i];
        $referencia_21 = $referencias_21[$i];
        $salida_md = -abs(floatval($salidas_md[$i])); // Asegura que sea negativo
        $entrada_md = abs(floatval($entradas_md[$i])); // Asegura que sea positivo
        $sub_almacen_actual = is_array($sub_almacen) && isset($sub_almacen[$i]) ? $sub_almacen[$i] : 'General'; 
        $valor_separar_material = in_array("1", $separar_material) ? "1" : 0;

        // Depuración: Verificar si `sub_almacen` se está capturando correctamente
        error_log("Sub-Almacén procesado: " . $sub_almacen_actual);

        // Insertar en movimiento_diario si el almacén de salida es Smartled (3)
        if ($almacen_salida_md == 3) {
            $sql_movimiento_diario = "INSERT INTO movimiento_diario 
                (fecha, tipo_producto, referencia_2, almacen_origen1, cantidad_salida, almacen_destino1, cantidad_entrada, observaciones, id_usuario, op, consecu_sale, separar_material, sub_almacen, tecnico_recibe) 
                VALUES (:fecha, :producto, :referencia_21, :almacen_salida_md, :salida_md, :almacen_entrada_md, :entrada_md, :observacion, :usuario, :op_destino, :contador_salida, :separar_material, :sub_almacen, :tecnico_recibe)";
            
            $stmt_diario = $pdo->prepare($sql_movimiento_diario);
            $stmt_diario->execute([
                ':fecha' => $fecha,
                ':producto' => $producto,
                ':referencia_21' => $referencia_21,
                ':almacen_salida_md' => $almacen_salida_md,
                ':salida_md' => $salida_md,
                ':almacen_entrada_md' => $almacen_entrada_md,
                ':entrada_md' => $entrada_md,
                ':observacion' => $observacion,
                ':usuario' => $usuario,
                ':op_destino' => $op_destino,
                ':contador_salida' => $contador_salida,
                ':separar_material' => $valor_separar_material,
                ':sub_almacen' => $sub_almacen_actual,
                ':tecnico_recibe' => $tecnico_recibe
            ]);
        }

        // Actualizar existencias en almacenes
        if (isset($almacenes[$almacen_salida_md])) {
            actualizarInventario($pdo, $almacenes[$almacen_salida_md], $producto, $referencia_21, $salida_md, $sub_almacen_actual);
        }

        if (isset($almacenes[$almacen_entrada_md])) {
            actualizarInventario($pdo, $almacenes[$almacen_entrada_md], $producto, $referencia_21, $entrada_md, $sub_almacen_actual);
        }
    }

    $pdo->commit();
    header("Location: create_movimiento_salida_final.php");
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Error: " . $e->getMessage(), 3, 'error.log');
    $_SESSION['msj'] = 'Ocurrió un error en el proceso.';
    header("Location: create_movimiento_salida_final.php");
    exit;
}

?>