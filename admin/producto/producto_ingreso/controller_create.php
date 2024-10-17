<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $modelo = $_POST['producto'];
    $serials = json_decode($_POST['seriales'], true);  // Decodificar los seriales

    try {
        // Iniciar transacción
        $pdo->beginTransaction();

        foreach ($serials as $serial) {
            // Insertar los seriales en la base de datos
            $stmt = $pdo->prepare("INSERT INTO ingreso_con_pistola (producto, serial) VALUES (?, ?)");
            $stmt->execute([$modelo, $serial]);  // Usar $serial en lugar de $serials
        }

        // Confirmar transacción
        $pdo->commit();

        // Devolver un mensaje al frontend
        echo json_encode(['status' => 'success', 'message' => 'Productos guardados correctamente']);

    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
}
?>
