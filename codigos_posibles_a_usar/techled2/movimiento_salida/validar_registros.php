<?php
include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php'); // Este archivo debería crear una instancia PDO en $conexion

header('Content-Type: application/json');

// Asegurarnos de que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos de la solicitud en formato JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificar que la acción sea 'validar_material'
    if (isset($data['action']) && $data['action'] === 'validar_material') {
        try {
            // Consulta SQL usando PDO
            $query = "SELECT
                        mvd.*,
                        productomovido.tipo_producto AS nombre_producto,
                        almacen_origen.nombre_almacen AS almacen_origen,
                        almacen_destino.nombre_almacen AS almacen_destino,
                    CASE
                        WHEN mvd.tipo_producto = 1 THEN pitch_table.pitch -- Aquí se une la tabla tabla_pitch
                        WHEN mvd.tipo_producto = 2 THEN caraccon.marca_control
                        WHEN mvd.tipo_producto = 3 THEN caracfuen.marca_fuente
                        ELSE NULL
                    END AS nombre_referencia_1,
                    CASE
                        WHEN mvd.tipo_producto = 1 THEN tmc.serie
                        WHEN mvd.tipo_producto = 2 THEN caraccontrol.referencia
                        WHEN mvd.tipo_producto = 3 THEN caracfuentes.modelo_fuente
                        ELSE NULL
                    END AS nombre_referencia_2
                    FROM
                        movimiento_diario AS mvd
                    INNER JOIN
                        t_productos AS productomovido ON mvd.tipo_producto = productomovido.id_producto
                    LEFT JOIN
                            t_asignar_todos_almacenes AS almacen_origen ON mvd.almacen_origen1 = almacen_origen.id_asignacion
                    LEFT JOIN
                        t_asignar_todos_almacenes AS almacen_destino ON mvd.almacen_destino1 = almacen_destino.id_asignacion
                    LEFT JOIN
                        tabla_pitch AS tp ON mvd.referencia_2 = tp.id AND mvd.tipo_producto = 1
                    LEFT JOIN
                        caracteristicas_control AS caraccon ON mvd.referencia_2 = caraccon.id_car_ctrl AND mvd.tipo_producto = 2
                    LEFT JOIN
                        caracteristicas_fuentes AS caracfuen ON mvd.referencia_2 = caracfuen.id_car_fuen AND mvd.tipo_producto = 3
                    LEFT JOIN
                        producto_modulo_creado AS tmc ON mvd.referencia_2 = tmc.id AND mvd.tipo_producto = 1
                    LEFT JOIN
                        referencias_control AS caraccontrol ON mvd.referencia_2 = caraccontrol.id_referencia AND mvd.tipo_producto = 2
                    LEFT JOIN
                        referencias_fuente AS caracfuentes ON mvd.referencia_2 = caracfuentes.id_referencias_fuentes AND mvd.tipo_producto = 3
                    LEFT JOIN
                        tabla_pitch AS pitch_table ON tmc.pitch = pitch_table.id
                    WHERE
                        mvd.separar_material 
                    IN
                        (1)
                    ORDER BY
                        mvd.id_movimiento_diario ASC
                    ";
            $stmt = $pdo->prepare($query); // Usa $pdo
            $stmt->execute();

            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($registros) > 0) {
                // Enviar la respuesta en formato JSON
                echo json_encode(['success' => true, 'registros' => $registros]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se encontraron registros.']);
            }
        } catch (PDOException $e) {
            // Manejo de errores
            echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta: ' . $e->getMessage()]);
        }
        exit;
    }
}
?>
