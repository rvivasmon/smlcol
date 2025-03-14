<?php
include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-Type: application/json");

    $id = $_POST['id'] ?? null;
    $cantidad = $_POST['cantidad'] ?? null;
    $observaciones = $_POST['observaciones'] ?? null;

    if ($id === null || $cantidad === null || $observaciones === null) {
        echo json_encode(["error" => "Faltan datos en la solicitud"]);
        exit();
    }

    try {
        $pdo->beginTransaction();

        $sql_check = "SELECT * FROM movimiento_admon WHERE id_movimiento_admon = ?";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->execute([$id]);
        $row_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (!$row_check) {
            echo json_encode(["error" => "El ID del movimiento no existe."]);
            exit();
        }

        $sql_update = "UPDATE movimiento_admon SET habilitar_almacen_entra = 2";
        $params = [];

        if (!empty($cantidad)) {
            $sql_update .= ", cantidad_entrada = ?";
            $params[] = $cantidad;
        }
        if (!empty($observaciones)) {
            $sql_update .= ", observaciones = ?";
            $params[] = $observaciones;
        }

        $sql_update .= " WHERE id_movimiento_admon = ?";
        $params[] = $id;

        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute($params);

        if ($stmt_update->rowCount() === 0) {
            echo json_encode(["error" => "No se realizó ninguna modificación en la base de datos."]);
            exit();
        }

        $sql_max = "SELECT MAX(consecu_entra) AS max_consecu FROM movimiento_diario";
        $stmt_max = $pdo->query($sql_max);
        $contador_entra = ($stmt_max->fetchColumn() ?? 0) + 1;

        $sql_select = "SELECT * FROM movimiento_admon WHERE id_movimiento_admon = ?";
        $stmt_select = $pdo->prepare($sql_select);
        $stmt_select->execute([$id]);
        $row = $stmt_select->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo json_encode(["error" => "No se encontró el movimiento."]);
            exit();
        }

        $fecha = $row['fecha'] ?? null;
        $tipo_producto = $row['tipo_producto'] ?? null;
        $almacen_origen1 = $row['almacen_origen1'] ?? null;
        $almacen_destino1 = $row['almacen_destino1'] ?? null;
        $referencia_2 = $row['referencia_2'] ?? null;
        $cantidad_entrada = floatval($row['cantidad_entrada'] ?? 0);
        $posicion = $row['posicion'] ?? null;
        $id_usuario = $row['id_usuario'] ?? null;
        $sub_almacen = $row['sub_almacen'] ?? null;

        $salida_md = -abs($cantidad_entrada);
        $entrada_md = abs($cantidad_entrada);

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

        if (!isset($almacenes[$almacen_origen1]) || !isset($almacenes[$almacen_destino1])) {
            echo json_encode(["error" => "El almacén de origen o destino no es válido."]);
            exit();
        }

        $sql_insert_mov = "INSERT INTO movimiento_diario 
            (fecha, consecu_entra, tipo_producto, almacen_origen1, cantidad_salida, almacen_destino1, cantidad_entrada, observaciones, id_usuario, sub_almacen, referencia_2, posicion) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_mov = $pdo->prepare($sql_insert_mov);
        $stmt_insert_mov->execute([$fecha, $contador_entra, $tipo_producto, $almacen_origen1, $salida_md, $almacen_destino1, $entrada_md, $observaciones, $id_usuario, $sub_almacen, $referencia_2, $posicion]);

        function validarProductoEnAlmacen($pdo, $tabla, $producto, $referencia, $cantidad, $sub_almacen) {
            $sql_check = "SELECT * FROM $tabla WHERE tipo_producto = ? AND producto = ? AND sub_almacen = ?";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->execute([$producto, $referencia, $sub_almacen]);

            if ($stmt_check->rowCount() > 0) {
                $sql_update = "UPDATE $tabla SET cantidad_plena = cantidad_plena + ? WHERE tipo_producto = ? AND producto = ?";
                $stmt_update = $pdo->prepare($sql_update);
                $stmt_update->execute([$cantidad, $producto, $referencia]);
            } else {
                $sql_insert = "INSERT INTO $tabla (tipo_producto, producto, cantidad_plena, sub_almacen) VALUES (?, ?, ?, ?)";
                $stmt_insert = $pdo->prepare($sql_insert);
                $stmt_insert->execute([$producto, $referencia, $cantidad, $sub_almacen]);
            }
        }

        if (isset($almacenes[$almacen_origen1])) {
            validarProductoEnAlmacen($pdo, $almacenes[$almacen_origen1], $tipo_producto, $referencia_2, $salida_md, $sub_almacen);
        }
        if (isset($almacenes[$almacen_destino1])) {
            validarProductoEnAlmacen($pdo, $almacenes[$almacen_destino1], $tipo_producto, $referencia_2, $entrada_md, $sub_almacen);
        }

        $sql_insert_total = "INSERT INTO alma_total (fecha_movimiento, tipo_producto, producto, salio, entro, id_principal) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert_total = $pdo->prepare($sql_insert_total);
        $stmt_insert_total->execute([$fecha, $tipo_producto, $referencia_2, $salida_md, $entrada_md, $almacen_destino1]);

        $sql_update_total = "UPDATE alma_total SET existen_entra = existen_entra + ? - ? WHERE tipo_producto = ? AND producto = ?";
        $stmt_update_total = $pdo->prepare($sql_update_total);
        $stmt_update_total->execute([$entrada_md, $salida_md, $tipo_producto, $referencia_2]);

        $pdo->commit();
        echo json_encode(["mensaje" => "Movimiento registrado correctamente."]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(["error" => "Error en la transacción: " . $e->getMessage()]);
    }
}
?>