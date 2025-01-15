<?php

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

if (isset($_POST['id_producto_categoria'], $_POST['valor_campo'], $_POST['select_id'])) {
    $id_producto_categoria = $_POST['id_producto_categoria'];
    $valor_campo = $_POST['valor_campo'];
    $select_id = $_POST['select_id'];

    // Determinar la columna en base al select utilizado
    $campo_producto = '';
    switch ($select_id) {
        case 'serie_modulo':
            $campo_producto = 'id_serie_modulo';
            break;
        case 'referencia_control35':
            $campo_producto = 'id_referencia_control';
            break;
        case 'modelo_fuente35':
            $campo_producto = 'id_modelo_fuente';
            break;
        default:
            echo json_encode(['error' => 'Selección no válida']);
            exit;
    }

    // Consulta para obtener los datos filtrados
    $stmt = $pdo->prepare("SELECT
                                    alp.*,
                                    distri_al.posiciones as nombre_posicion,
                                    alp.cantidad_plena as cantidad_plena
                                FROM
                                    alma_principal as alp
                                LEFT JOIN
                                    distribucion_almacen as distri_al ON alp.posicion = distri_al.id
                                WHERE
                                    alp.tipo_producto = :tipo_producto 
                                AND
                                    alp.producto = :valor_campo
                                ");
    $stmt->execute([
        ':tipo_producto' => $id_producto_categoria,
        ':valor_campo' => $valor_campo
    ]);

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        // Devolver los datos en formato JSON
        echo json_encode([
            'posicion' => $resultado['nombre_posicion'],
            'cantidad_plena' => $resultado['cantidad_plena']
        ]);
    } else {
        echo json_encode(['error' => 'No se encontraron datos']);
    }
} else {
    echo json_encode(['error' => 'Datos incompletos']);
}
?>
