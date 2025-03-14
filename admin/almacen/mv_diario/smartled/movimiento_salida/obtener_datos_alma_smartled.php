<?php
include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

if (isset($_POST['id_producto_categoria'], $_POST['valor_campo'], $_POST['select_id'], $_POST['sub_almacen'])) {
    $id_producto_categoria = $_POST['id_producto_categoria'];
    $valor_campo = $_POST['valor_campo'];
    $select_id = $_POST['select_id'];
    $sub_almacen = $_POST['sub_almacen'];

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

    // Consulta para obtener los datos filtrados considerando el sub_almacen
    $stmt = $pdo->prepare("SELECT
                                alp.*,
                                distri_al.posiciones as nombre_posicion,
                                alp.cantidad_plena as cantidad_plena
                            FROM
                                alma_smartled as alp
                            LEFT JOIN
                                distribucion_almacen as distri_al ON alp.posicion = distri_al.id
                            WHERE
                                alp.tipo_producto = :tipo_producto 
                            AND
                                alp.producto = :valor_campo
                            AND
                                alp.sub_almacen = :sub_almacen");

    $stmt->execute([
        ':tipo_producto' => $id_producto_categoria,
        ':valor_campo' => $valor_campo,
        ':sub_almacen' => $sub_almacen
    ]);

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo json_encode([
            'posicion' => $resultado['nombre_posicion'],
            'cantidad_plena' => $resultado['cantidad_plena']
        ]);
    } else {
        echo json_encode(['error' => 'No se encontraron datos para el Sub-Almacén seleccionado']);
    }
} else {
    echo json_encode(['error' => 'Datos incompletos']);
}
?>
