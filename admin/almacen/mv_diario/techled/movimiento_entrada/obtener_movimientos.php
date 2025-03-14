<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');


    try {
        // Consulta para obtener los registros con habilitar_almacen_entra = 1
        $sql = 'SELECT
                    mvd.*,
                    productomovido.tipo_producto AS nombre_producto,
                    almacen_origen.nombre_almacen AS almacen_origen,
                    almacen_destino.almacenes AS almacen_destino,
                    bg.nombre_bodega AS bodega_nombre,
                    sua.sub_almacen AS nombre_sub,
                CASE
                WHEN
                    mvd.tipo_producto = 1 THEN pitch_table.pitch -- Aquí se une la tabla tabla_pitch
                WHEN
                    mvd.tipo_producto = 2 THEN carcontrol.marca_control
                WHEN
                    mvd.tipo_producto = 3 THEN carafuen.marca_fuente
                ELSE NULL
                END AS
                    nombre_referencia_1,
                CASE
                WHEN
                    mvd.tipo_producto = 1 THEN tmc.serie
                WHEN
                    mvd.tipo_producto = 2 THEN caraccontrol.referencia
                WHEN
                    mvd.tipo_producto = 3 THEN caracfuentes.modelo_fuente
                ELSE NULL
                END AS
                    nombre_referencia_2
                FROM
                    movimiento_admon AS mvd
                INNER JOIN
                    t_productos AS productomovido ON mvd.tipo_producto = productomovido.id_producto
                LEFT JOIN
                    t_asignar_todos_almacenes AS almacen_origen ON mvd.almacen_origen1 = almacen_origen.id_asignacion
                LEFT JOIN
                    almacenes_grupo AS almacen_destino ON mvd.almacen_destino1 = almacen_destino.id
                LEFT JOIN
                    tabla_pitch AS tp ON mvd.referencia_2 = tp.id AND mvd.tipo_producto = 1
                LEFT JOIN
                    referencias_control AS ref_control ON mvd.referencia_2 = ref_control.id_referencia AND mvd.tipo_producto = 2
                LEFT JOIN
                    referencias_fuente AS ref_fuente ON mvd.referencia_2 = ref_fuente.id_referencias_fuentes AND mvd.tipo_producto = 3
                LEFT JOIN
                    producto_modulo_creado AS tmc ON mvd.referencia_2 = tmc.id AND mvd.tipo_producto = 1
                LEFT JOIN
                    referencias_control AS caraccontrol ON mvd.referencia_2 = caraccontrol.id_referencia AND mvd.tipo_producto = 2
                LEFT JOIN
                    referencias_fuente AS caracfuentes ON mvd.referencia_2 = caracfuentes.id_referencias_fuentes AND mvd.tipo_producto = 3
                LEFT JOIN
                    tabla_pitch AS pitch_table ON tmc.pitch = pitch_table.id
                LEFT JOIN
                    caracteristicas_control AS carcontrol ON ref_control.marca = carcontrol.id_car_ctrl
                LEFT JOIN
                    caracteristicas_fuentes AS carafuen ON ref_fuente.marca_fuente = carafuen.id_car_fuen
                LEFT JOIN
                    t_bodegas AS bg ON mvd.bodega = bg.id
                LEFT JOIN
                    t_sub_almacen AS sua ON mvd.sub_almacen = sua.id
                WHERE
                    mvd.habilitar_almacen_entra = 1
                AND
                    mvd.almacen_destino1 = 4';
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        // Obtener los resultados como un array asociativo
        $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Enviar la respuesta en formato JSON
        echo json_encode($registros);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error en la consulta: " . $e->getMessage()]);
    };

    ?>