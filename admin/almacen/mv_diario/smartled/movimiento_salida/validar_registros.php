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
            $query = "SELECT id_movimiento_diario, tipo_producto, referencia_2, almacen_destino1, cantidad_entrada, observaciones, op, consecu_sale 
                      FROM movimiento_diario 
                      WHERE separar_material IN (1)";
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
