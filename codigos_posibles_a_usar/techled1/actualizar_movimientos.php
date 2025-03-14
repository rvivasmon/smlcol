<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ids'])) {
    $ids = $_POST['ids'];
    
    if (!empty($ids)) {
        try {
            // Construimos la consulta con parámetros de PDO
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $sql = "UPDATE movimiento_admon SET habilitar_almacen_entra = 1 WHERE id_movimiento_admon IN ($placeholders)";
            $stmt = $pdo->prepare($sql);

            // Ejecutamos la consulta con los valores seguros
            if ($stmt->execute($ids)) {
                echo "Actualización exitosa";
            } else {
                echo "Error al actualizar";
            }
        } catch (PDOException $e) {
            echo "Error de base de datos: " . $e->getMessage();
        }
    } else {
        echo "No se recibieron IDs válidos.";
    }
}
?>
