<?php

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-Type: application/json");

    $id = $_POST['id'] ?? null;
    $cantidad = $_POST['cantidad'] ?? null;
    $observaciones = $_POST['observaciones'] ?? null;

    // Verifica si los valores llegaron
if ($id === null || $cantidad === null || $observaciones === null) {
    echo json_encode(["error" => "Faltan datos en la solicitud"]);
    exit();
}

    try {
        $pdo->beginTransaction();
        
        // 1. Actualizar "habilitar_almacen_entra" en "movimiento_admon"
        $sql_update = "UPDATE movimiento_admon SET habilitar_almacen_entra = 2 WHERE id_movimiento_admon = ?";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([$id]);
        
        // 2. Obtener el máximo de "consecu_entra" en "movimiento_diario" y sumarle 1
        $sql_max = "SELECT MAX(consecu_entra) AS max_consecu FROM movimiento_diario";
        $stmt_max = $pdo->query($sql_max);
        $contador_entra = ($stmt_max->fetchColumn() ?? 0) + 1;
        
        // 3. Obtener datos de "movimiento_admon"
        $sql_select = "SELECT * FROM movimiento_admon WHERE id_movimiento_admon = ? AND almacen_destino1 = 4";
        $stmt_select = $pdo->prepare($sql_select);
        $stmt_select->execute([$id]);
        $row = $stmt_select->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) {
            echo json_encode(["error" => "No se encontró el movimiento con ese ID o almacen_destino1 no es 4."]);
            exit();
        }

        extract($row); // Extrae los valores de la consulta a variables
        
        $salida_md = -abs(floatval($cantidad_entrada));
        $entrada_md = abs(floatval($cantidad_entrada));
        
        // Almacenes y sus tablas
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

        // Función para validar y actualizar productos en almacenes
        function validarProductoEnAlmacen($pdo, $tabla, $producto, $referencia, $cantidad, $posicion) {
            $sql_check = "SELECT * FROM $tabla WHERE tipo_producto = ? AND producto = ?";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->execute([$producto, $referencia]);

            if ($stmt_check->rowCount() > 0) {
                $sql_update = "UPDATE $tabla SET cantidad_plena = cantidad_plena + ? WHERE tipo_producto = ? AND producto = ?";
                $stmt_update = $pdo->prepare($sql_update);
                $stmt_update->execute([$cantidad, $producto, $referencia]);
            } else {
                $sql_insert = "INSERT INTO $tabla (tipo_producto, producto, cantidad_plena, posicion) VALUES (?, ?, ?, ?)";
                $stmt_insert = $pdo->prepare($sql_insert);
                $stmt_insert->execute([$producto, $referencia, $cantidad, $posicion]);
            }
        }

        // Validar salida y entrada en los almacenes
        if (isset($almacenes[$almacen_origen1])) {
            validarProductoEnAlmacen($pdo, $almacenes[$almacen_origen1], $tipo_producto, $referencia_2, $salida_md, $posicion);
        }
        if (isset($almacenes[$almacen_destino1])) {
            validarProductoEnAlmacen($pdo, $almacenes[$almacen_destino1], $tipo_producto, $referencia_2, $entrada_md, $posicion);
        }

        // 4. Insertar en "movimiento_diario"
        $sql_insert_mov = "INSERT INTO movimiento_diario (fecha, consecu_entra, tipo_producto, almacen_origen1, cantidad_salida, almacen_destino1, cantidad_entrada, observaciones, id_usuario, op, referencia_2, posicion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_mov = $pdo->prepare($sql_insert_mov);
        $stmt_insert_mov->execute([$fecha, $contador_entra, $tipo_producto, $almacen_origen1, $salida_md, $almacen_destino1, $entrada_md, $observaciones, $id_usuario, $op, $referencia_2, $posicion]);

        // 5. Insertar en "alma_total"
        $sql_insert_total = "INSERT INTO alma_total (fecha_movimiento, tipo_producto, producto, salio, entro, id_principal) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert_total = $pdo->prepare($sql_insert_total);
        $stmt_insert_total->execute([$fecha, $tipo_producto, $referencia_2, $salida_md, $entrada_md, $almacen_destino1]);
        
        // 6. Actualizar existencias en "alma_total"
        $sql_update_total = "UPDATE alma_total SET existen_entra = existen_entra + ? - ? WHERE tipo_producto = ? AND producto = ?";
        $stmt_update_total = $pdo->prepare($sql_update_total);
        $stmt_update_total->execute([$entrada_md, $salida_md, $tipo_producto, $referencia_2]);
        
        $pdo->commit();
        $_SESSION['msj'] = "Movimiento registrado y existencias actualizadas correctamente.";
        header('Location: ' . $URL . 'admin/almacen/mv_diario/smartled');
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['msj'] = "Error: " . $e->getMessage();
        header('Location: ' . $URL . 'ruta_de_error');
        exit;
    }
}

?>
