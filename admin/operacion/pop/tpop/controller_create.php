<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener la fecha actual si es necesario
    $fecha_actual = date('Y-m-d H:i:s');

    // Recibir datos del formulario con validación
    $id_pop = $_POST['id_pop'] ?? null;
    $id_item_pop = $_POST['id_gral_pop'] ?? null;
    $id_oc = $_POST['id_oc'] ?? null;
    $id_items_oc = $_POST['id_item_oc'] ?? null;
    $uso_pan = $_POST['uso_pan'] ?? null;
    $pitch_tpop = $_POST['pitch_tpop'] ?? null;
    $tipo_pan = $_POST['tipo_pan'] ?? null;
    $medida_x = $_POST['medida_x'] ?? null;
    $medida_y = $_POST['medida_y'] ?? null;
    $medidas_modulo = $_POST['medidas_modulo'] ?? null;
    $total_modulos = $_POST['total_modulos'] ?? null;
    $control_reciving = $_POST['control_reciving'] ?? null;
    $num_tarjetas = $_POST['num_tarjetas'] ?? null;
    $t_fuente = $_POST['t_fuente'] ?? null;
    $num_fuentes = $_POST['num_fuentes'] ?? null;
    $pixel_x = $_POST['pixel_x'] ?? null;
    $pixel_y = $_POST['pixel_y'] ?? null;
    $pixel_total = $_POST['pixel_total'] ?? null;
    $t_modulo = $_POST['t_modulo'] ?? null;
    $s_modulo = $_POST['s_modulo'] ?? null;
    $f_control = $_POST['f_control'] ?? null;
    $controladora = $_POST['controladora'] ?? null;
    $num_control = $_POST['num_control'] ?? null;
    $modulo_complemento = $_POST['modulo_complemento'] ?? null;
    $fuente_complemento = $_POST['fuente_complemento'] ?? null;
    $reciving_complemento = $_POST['reciving_complemento'] ?? null;
    $tipo_estructura = $_POST['tipo_estructura'] ?? null;
    $conexion = $_POST['conexion'] ?? null;
    $configuracion = $_POST['configuracion'] ?? null;
    $estado_tpop = $_POST['estado_tpop'] ?? null;
    $m_cuadrado = $_POST['m_cuadrado'] ?? null;
    $voltaje = $_POST['voltaje'] ?? null;
    $watts = $_POST['watts'] ?? null;
    $amperios = $_POST['amperios'] ?? null;
    $num_circuitos = $_POST['num_circuitos'] ?? null;
    $consumo = $_POST['consumo'] ?? null;
    $usuario = $_POST['usuario'] ?? null;
    $proyecto_checkbox = isset($_POST['proyecto_checkbox']) ? 1 : 0;
    $ddi_checkbox = isset($_POST['ddi_checkbox']) ? 1 : 0;
    $rop_checkbox = isset($_POST['rop_checkbox']) ? 1 : 0;
    $pop_id = $_POST['pop_id'] ?? null;
    $ppal_pop_value = $_POST['ppal_pop_value'] ?? null;
    $fecha_recibe = $_POST['fecha_recibe'] ?? null;
    $cantidad = $_POST['cantidad'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $observacion = $_POST['observacion'] ?? null;

    // Actualizar la tabla 'item_pop' en el campo 'tpop' a 1
    $query_update_item_pop = $pdo->prepare("
        UPDATE items_pop 
        SET tpop = :estado_tpop,
            ddi = :ddi_checkbox, 
            proyecto = :proyecto_checkbox,
            rop = :rop_checkbox,
            fecha_procesado = :fecha_actual
        WHERE id = :id_item_pop AND item_oc = :id_items_oc
    ");

    // Vincular los parámetros
    $query_update_item_pop->bindParam(':estado_tpop', $estado_tpop);
    $query_update_item_pop->bindParam(':id_item_pop', $id_item_pop);
    $query_update_item_pop->bindParam(':id_items_oc', $id_items_oc);
    $query_update_item_pop->bindParam(':ddi_checkbox', $ddi_checkbox);
    $query_update_item_pop->bindParam(':proyecto_checkbox', $proyecto_checkbox);
    $query_update_item_pop->bindParam(':rop_checkbox', $rop_checkbox);
    $query_update_item_pop->bindParam(':fecha_actual', $fecha_actual);
    $query_update_item_pop->execute();



    // Verificar si el registro ya existe
    $query_check = $pdo->prepare("
        SELECT COUNT(*) FROM tpop 
        WHERE tpop_item = :id_pop AND pop_item = :id_item_pop
    ");
    $query_check->bindParam(':id_pop', $id_pop);
    $query_check->bindParam(':id_item_pop', $id_item_pop);
    $query_check->execute();
    $exists = $query_check->fetchColumn();

    if ($exists) {
        // Si el registro existe, actualiza los datos
        $query_update = $pdo->prepare("
            UPDATE tpop SET
                descripcion = :descripcion,
                observacion = :observacion,
                uso = :uso_pan, 
                pitch = :pitch_tpop, 
                tipo_pan = :tipo_pan, 
                x = :medida_x, 
                y = :medida_y, 
                medida_modulo = :medidas_modulo, 
                total_modulos = :total_modulos, 
                receiving = :control_reciving, 
                cantidad_receiving = :num_tarjetas, 
                fuente = :t_fuente, 
                cantidad_fuente = :num_fuentes, 
                pixel_x = :pixel_x, 
                pixel_y = :pixel_y, 
                total_pixel = :pixel_total, 
                tipo_modulo = :t_modulo, 
                serial_modulo = :s_modulo, 
                funcion_control = :f_control, 
                control = :controladora, 
                cantidad_control = :num_control, 
                tipo_estructura = :tipo_estructura, 
                modulo_adic = :modulo_complemento, 
                fuente_adic = :fuente_complemento, 
                control_adic = :reciving_complemento, 
                ddi = :ddi_checkbox, 
                proyecto = :proyecto_checkbox,
                rop = :rop_checkbox, 
                estado_tpop = :estado_tpop, 
                m2 = :m_cuadrado, 
                voltaje = :voltaje, 
                watts = :watts, 
                amperios = :amperios, 
                cantidad_circuito = :num_circuitos, 
                consumo = :consumo, 
                conexion = :conexion, 
                configuracion = :configuracion, 
                usuario = :usuario,
                fecha_procesado = :fecha_actual
            WHERE tpop_item = :id_pop AND pop_item = :id_item_pop
        ");

        // Vincular los parámetros
        $query_update->bindParam(':descripcion', $_POST['descripcion']);
        $query_update->bindParam(':observacion', $_POST['observacion']);
        $query_update->bindParam(':uso_pan', $_POST['uso_pan']);
        $query_update->bindParam(':pitch_tpop', $_POST['pitch_tpop']);
        $query_update->bindParam(':tipo_pan', $_POST['tipo_pan']);
        $query_update->bindParam(':medida_x', $_POST['medida_x']);
        $query_update->bindParam(':medida_y', $_POST['medida_y']);
        $query_update->bindParam(':medidas_modulo', $_POST['medidas_modulo']);
        $query_update->bindParam(':total_modulos', $_POST['total_modulos']);
        $query_update->bindParam(':control_reciving', $_POST['control_reciving']);
        $query_update->bindParam(':num_tarjetas', $_POST['num_tarjetas']);
        $query_update->bindParam(':t_fuente', $_POST['t_fuente']);
        $query_update->bindParam(':num_fuentes', $_POST['num_fuentes']);
        $query_update->bindParam(':pixel_x', $_POST['pixel_x']);
        $query_update->bindParam(':pixel_y', $_POST['pixel_y']);
        $query_update->bindParam(':pixel_total', $_POST['pixel_total']);
        $query_update->bindParam(':t_modulo', $_POST['t_modulo']);
        $query_update->bindParam(':s_modulo', $_POST['s_modulo']);
        $query_update->bindParam(':f_control', $_POST['f_control']);
        $query_update->bindParam(':controladora', $_POST['controladora']);
        $query_update->bindParam(':num_control', $_POST['num_control']);
        $query_update->bindParam(':tipo_estructura', $_POST['tipo_estructura']);
        $query_update->bindParam(':modulo_complemento', $_POST['modulo_complemento']);
        $query_update->bindParam(':fuente_complemento', $_POST['fuente_complemento']);
        $query_update->bindParam(':reciving_complemento', $_POST['reciving_complemento']);
        $query_update->bindParam(':ddi_checkbox', $ddi_checkbox);
        $query_update->bindParam(':proyecto_checkbox', $proyecto_checkbox);
        $query_update->bindParam(':rop_checkbox', $rop_checkbox);
        $query_update->bindParam(':estado_tpop', $estado_tpop);
        $query_update->bindParam(':m_cuadrado', $_POST['m_cuadrado']);
        $query_update->bindParam(':voltaje', $_POST['voltaje']);
        $query_update->bindParam(':watts', $_POST['watts']);
        $query_update->bindParam(':amperios', $_POST['amperios']);
        $query_update->bindParam(':num_circuitos', $_POST['num_circuitos']);
        $query_update->bindParam(':consumo', $_POST['consumo']);
        $query_update->bindParam(':conexion', $_POST['conexion']);
        $query_update->bindParam(':configuracion', $_POST['configuracion']);
        $query_update->bindParam(':usuario', $usuario);
        $query_update->bindParam(':id_pop', $id_pop);
        $query_update->bindParam(':id_item_pop', $id_item_pop);
        $query_update->bindParam(':fecha_actual', $fecha_actual);

        // Ejecutar la actualización
        $query_update->execute();
    } else {
        // Preparar la consulta de inserción
    $query_insert_item = $pdo->prepare("
    INSERT INTO tpop (
        tpop_item, pop_item, observacion, descripcion, uso, pitch, tipo_pan, x, y, medida_modulo, 
        total_modulos, receiving, cantidad_receiving, fuente, cantidad_fuente, pixel_x, 
        pixel_y, total_pixel, tipo_modulo, serial_modulo, funcion_control, control, 
        cantidad_control, tipo_estructura, modulo_adic, fuente_adic, control_adic, ddi, proyecto, rop, 
        estado_tpop, m2, voltaje, watts, amperios, cantidad_circuito, consumo, 
        conexion, configuracion, usuario, fecha_recepcion, fecha_procesado
    ) VALUES (
        :id_pop, :id_item_pop, :observacion, :descripcion, :uso_pan, :pitch_tpop, :tipo_pan, :medida_x, 
        :medida_y, :medidas_modulo, :total_modulos, :control_reciving, :num_tarjetas, 
        :t_fuente, :num_fuentes, :pixel_x, :pixel_y, :pixel_total, :t_modulo, 
        :s_modulo, :f_control, :controladora, :num_control, :tipo_estructura, :modulo_complemento, 
        :fuente_complemento, :reciving_complemento, :ddi_checkbox, :proyecto_checkbox, :rop_checkbox, :estado_tpop, :m_cuadrado, 
        :voltaje, :watts, :amperios, :num_circuitos, :consumo, :conexion, :configuracion, :usuario, :fecha_recibe, :fecha_actual
    )
");

    // Vincular los parámetros correctamente
    $query_insert_item->bindParam(':id_pop', $id_pop);
    $query_insert_item->bindParam(':id_item_pop', $id_item_pop);
    $query_insert_item->bindParam(':observacion', $observacion);
    $query_insert_item->bindParam(':descripcion', $descripcion);
    $query_insert_item->bindParam(':uso_pan', $uso_pan);
    $query_insert_item->bindParam(':pitch_tpop', $pitch_tpop);
    $query_insert_item->bindParam(':tipo_pan', $tipo_pan);
    $query_insert_item->bindParam(':medida_x', $medida_x);
    $query_insert_item->bindParam(':medida_y', $medida_y);
    $query_insert_item->bindParam(':medidas_modulo', $medidas_modulo);
    $query_insert_item->bindParam(':total_modulos', $total_modulos);
    $query_insert_item->bindParam(':control_reciving', $control_reciving);
    $query_insert_item->bindParam(':num_tarjetas', $num_tarjetas);
    $query_insert_item->bindParam(':t_fuente', $t_fuente);
    $query_insert_item->bindParam(':num_fuentes', $num_fuentes);
    $query_insert_item->bindParam(':pixel_x', $pixel_x);
    $query_insert_item->bindParam(':pixel_y', $pixel_y);
    $query_insert_item->bindParam(':pixel_total', $pixel_total);
    $query_insert_item->bindParam(':t_modulo', $t_modulo);
    $query_insert_item->bindParam(':s_modulo', $s_modulo);
    $query_insert_item->bindParam(':f_control', $f_control);
    $query_insert_item->bindParam(':controladora', $controladora);
    $query_insert_item->bindParam(':num_control', $num_control);
    $query_insert_item->bindParam(':tipo_estructura', $tipo_estructura);
    $query_insert_item->bindParam(':modulo_complemento', $modulo_complemento);
    $query_insert_item->bindParam(':fuente_complemento', $fuente_complemento);
    $query_insert_item->bindParam(':reciving_complemento', $reciving_complemento);
    $query_insert_item->bindParam(':ddi_checkbox', $ddi_checkbox);
    $query_insert_item->bindParam(':proyecto_checkbox', $proyecto_checkbox);
    $query_insert_item->bindParam(':rop_checkbox', $rop_checkbox);
    $query_insert_item->bindParam(':estado_tpop', $estado_tpop);
    $query_insert_item->bindParam(':m_cuadrado', $m_cuadrado);
    $query_insert_item->bindParam(':voltaje', $voltaje);
    $query_insert_item->bindParam(':watts', $watts);
    $query_insert_item->bindParam(':amperios', $amperios);
    $query_insert_item->bindParam(':num_circuitos', $num_circuitos);
    $query_insert_item->bindParam(':consumo', $consumo);
    $query_insert_item->bindParam(':conexion', $conexion);
    $query_insert_item->bindParam(':configuracion', $configuracion);
    $query_insert_item->bindParam(':usuario', $usuario);
    $query_insert_item->bindParam(':fecha_recibe', $fecha_recibe);
    $query_insert_item->bindParam(':fecha_actual', $fecha_actual);
    $query_insert_item->execute();
    }

// **Nueva condición: si estado_tpop == 3, insertamos en rop e items_op**
if ($estado_tpop == 3) {

    // Obtener el valor máximo de 'contador' en 'items_op'
    $query_max_contador = $pdo->prepare("SELECT MAX(contador) AS max_contador FROM items_op");
    $query_max_contador->execute();
    $result = $query_max_contador->fetch(PDO::FETCH_ASSOC);

    // Si no hay registros o es NULL, asignamos 1, sino incrementamos en 1
    $nuevo_contador = ($result['max_contador'] !== null) ? $result['max_contador'] + 1 : 1;

    $op_id = 'OP' . ($nuevo_contador + $i); // Incrementar ID por iteración

    // Verificar que $cantidad sea un número entero válido y mayor a 0
    $cantidad = intval($cantidad);
    if ($cantidad <= 0) {
        die("Error: La cantidad debe ser un número mayor que 0.");
    }

    // Insertar registros tantas veces como indique la cantidad
    for ($i = 1; $i <= $cantidad; $i++) { // Empezamos desde 1 para el contador personalizado

        $contador_item_op = $i; // Formato 1/cantidad, 2/cantidad, ...

        $query_insert_items_op = $pdo->prepare("
            INSERT INTO items_op (id_oc, id_items_oc, id_op, id_pop, id_item_pop, fecha_recibido, tipo_estructura, proyecto, cantidad, observaciones, conexion, configuracion, usuario, contador, contador_item_op) 
            VALUES (:id_oc, :id_items_oc, :op_id, :id_pop, :id_item_pop, :fecha_actual, :tipo_estructura, :id_oc, :cantidad, :ppal_pop_value, :conexion, :configuracion, :usuario, :contador, :contador_item_op)
        ");

        $query_insert_items_op->bindParam(':id_oc', $id_oc);
        $query_insert_items_op->bindParam(':id_items_oc', $id_items_oc);
        $query_insert_items_op->bindParam(':op_id', $op_id);
        $query_insert_items_op->bindParam(':id_pop', $id_pop);
        $query_insert_items_op->bindParam(':id_item_pop', $id_item_pop);
        $query_insert_items_op->bindParam(':fecha_actual', $fecha_actual);
        $query_insert_items_op->bindParam(':tipo_estructura', $tipo_estructura);
        $query_insert_items_op->bindParam(':id_oc', $id_oc);
        $query_insert_items_op->bindParam(':cantidad', $cantidad);
        $query_insert_items_op->bindParam(':ppal_pop_value', $ppal_pop_value);
        $query_insert_items_op->bindParam(':conexion', $conexion);
        $query_insert_items_op->bindParam(':configuracion', $configuracion);
        $query_insert_items_op->bindParam(':usuario', $usuario);
        $query_insert_items_op->bindParam(':contador', $nuevo_contador);
        $query_insert_items_op->bindParam(':contador_item_op', $contador_item_op);
        $query_insert_items_op->execute();
    }
}



if ($estado_tpop == 3 && $rop_checkbox == 1) {
    
    $modulo_value_rop = $pitch_tpop . ' - ' . $t_modulo . ' - ' . $medidas_modulo;

    // Consultar el campo 'id' en items_op con los filtros dados
    $query_select_items_op = $pdo->prepare("
        SELECT id FROM items_op 
        WHERE id_item_pop = :id_item_pop AND id_items_oc = :id_items_oc
    ");
    $query_select_items_op->bindParam(':id_item_pop', $id_item_pop);
    $query_select_items_op->bindParam(':id_items_oc', $id_items_oc);
    $query_select_items_op->execute();
    $result = $query_select_items_op->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró un resultado
    if ($result) {
        $id_items_op = $result['id']; // Obtener el ID de items_op

        // Insertar en la tabla rop
        $query_insert_rop = $pdo->prepare("
            INSERT INTO rop (
                fecha, item_pop, oc, modulo, cantidad_modulo, 
                fuente, cantidad_fuente, receiving, cantidad_receiving, 
                controladora, cantidad_control, modulo_adic, cantidad_adic_modulo, 
                fuente_adic, cantidad_adic_fuente, receiving_adic, cantidad_adic_receiving, op
            ) VALUES (
                :fecha_actual, :id_item_pop, :id_items_oc, :modulo_value_rop, :total_modulos, 
                :t_fuente, :num_fuentes, :control_reciving, :num_tarjetas, 
                :controladora, :num_control, :modulo_complemento, :modulo_complemento, 
                :fuente_complemento, :fuente_complemento, :reciving_complemento, :reciving_complemento, :id_items_op
            )
        ");

        // Enlazar parámetros
        $query_insert_rop->bindParam(':fecha_actual', $fecha_actual);
        $query_insert_rop->bindParam(':id_item_pop', $id_item_pop);
        $query_insert_rop->bindParam(':id_items_oc', $id_items_oc);
        $query_insert_rop->bindParam(':modulo_value_rop', $modulo_value_rop);
        $query_insert_rop->bindParam(':total_modulos', $total_modulos);
        $query_insert_rop->bindParam(':t_fuente', $t_fuente);
        $query_insert_rop->bindParam(':num_fuentes', $num_fuentes);
        $query_insert_rop->bindParam(':control_reciving', $control_reciving);
        $query_insert_rop->bindParam(':num_tarjetas', $num_tarjetas);
        $query_insert_rop->bindParam(':controladora', $controladora);
        $query_insert_rop->bindParam(':num_control', $num_control);
        $query_insert_rop->bindParam(':modulo_complemento', $modulo_complemento);
        $query_insert_rop->bindParam(':fuente_complemento', $fuente_complemento);
        $query_insert_rop->bindParam(':reciving_complemento', $reciving_complemento);
        $query_insert_rop->bindParam(':id_items_op', $id_items_op); // Insertar el ID de items_op en el campo op

        // Ejecutar consulta y verificar éxito
        if ($query_insert_rop->execute()) {
            echo "Registro insertado correctamente en 'rop'.";
        } else {
            echo "Error al insertar en 'rop'.";
        }

    } else {
        echo "No se encontró un registro en 'items_op' con los valores dados.";
    }
}


    // Redirigir después de completar la acción
    header("Location: " . $URL . "admin/operacion/pop/edit.php?id=" . $ppal_pop_value);
    exit;
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>