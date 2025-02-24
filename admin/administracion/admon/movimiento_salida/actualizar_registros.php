<?php
include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['ids']) && is_array($data['ids'])) {
        try {
            $pdo->beginTransaction();

            foreach ($data['ids'] as $id) {
                $query = "UPDATE movimiento_diario SET separar_material = 0 WHERE id_movimiento_diario = :id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }

            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
    }
}
?>