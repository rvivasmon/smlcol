<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ids']) && is_array($_POST['ids'])) {
    $ids = array_map('intval', $_POST['ids']); // Convertir a enteros para seguridad

    if (!empty($ids)) {
        try {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $sql = "UPDATE movimiento_admon SET habilitar_almacen_entra = 1 WHERE id_movimiento_admon IN ($placeholders)";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute($ids)) {
                echo json_encode(["status" => "success", "message" => "Actualización exitosa"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al actualizar"]);
            }
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Error de base de datos: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No se recibieron IDs válidos."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Solicitud inválida."]);
}
?>
