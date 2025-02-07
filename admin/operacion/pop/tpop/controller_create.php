<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recibir datos del formulario con validación
    $id_pop = $_POST['id_pop'] ?? null;
    $id_item_pop = $_POST['id_gral_pop'] ?? null;
    $id_oc = $_POST['id_item_oc'] ?? null;
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
    $proyecto_checkbox = $_POST['proyecto_checkbox'] ?? null;
    $ddi_checkbox = $_POST['ddi_checkbox'] ?? null;
    $pop_id = $_POST['pop_id'] ?? null;
    $ppal_pop_value = $_POST['ppal_pop_value'] ?? null;

    // Actualizar la tabla 'item_pop' en el campo 'tpop' a 1
    $query_update_item_pop = $pdo->prepare("
        UPDATE items_pop 
        SET tpop = 1,
            ddi = :ddi_checkbox, 
            proyecto = :proyecto_checkbox
        WHERE id = :id_item_pop AND item_oc = :id_oc
    ");

    // Vincular los parámetros
    $query_update_item_pop->bindParam(':id_item_pop', $id_item_pop);
    $query_update_item_pop->bindParam(':id_oc', $id_oc);
    $query_update_item_pop->bindParam(':ddi_checkbox', $ddi_checkbox);
    $query_update_item_pop->bindParam(':proyecto_checkbox', $proyecto_checkbox);

    // Ejecutar la actualización
    if (!$query_update_item_pop->execute()) {
        echo "Error al actualizar el campo tpop.";
    }

    // Preparar la consulta de inserción
    $query_insert_item = $pdo->prepare("
        INSERT INTO tpop (
            tpop_item, pop_item, uso, pitch, tipo_pan, x, y, medida_modulo, 
            total_modulos, receiving, cantidad_receiving, fuente, cantidad_fuente, pixel_x, 
            pixel_y, total_pixel, tipo_modulo, serial_modulo, funcion_control, control, 
            cantidad_control, tipo_estructura, modulo_adic, fuente_adic, control_adic, 
            estado_tpop, m2, voltaje, watts, amperios, cantidad_circuito, consumo, 
            conexion, configuracion, usuario
        ) VALUES (
            :id_pop, :id_item_pop, :uso_pan, :pitch_tpop, :tipo_pan, :medida_x, 
            :medida_y, :medidas_modulo, :total_modulos, :control_reciving, :num_tarjetas, 
            :t_fuente, :num_fuentes, :pixel_x, :pixel_y, :pixel_total, :t_modulo, 
            :s_modulo, :f_control, :controladora, :num_control, :tipo_estructura, :modulo_complemento, 
            :fuente_complemento, :reciving_complemento, :estado_tpop, :m_cuadrado, 
            :voltaje, :watts, :amperios, :num_circuitos, :consumo, :conexion, :configuracion, :usuario
        )
    ");

    // Vincular los parámetros correctamente
    $query_insert_item->bindParam(':id_pop', $id_pop);
    $query_insert_item->bindParam(':id_item_pop', $id_item_pop);
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

    // Ejecutar la inserción
    if ($query_insert_item->execute()) {
        $redirect_url = $URL . "admin/operacion/pop/edit.php?id=" . $ppal_pop_value;
        header("Location: $redirect_url");
        exit;
    } else {
        echo "Error al insertar los datos.";
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>
