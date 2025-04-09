<?php
include('../../../../../app/config/conexion.php');

$tecnico = $_POST['tecnico_recibe'];
$ids = $_POST['ids_articulos']; // array de IDs

if (!empty($tecnico) && !empty($ids)) {
    foreach ($ids as $id) {
        $sql = "UPDATE movimiento_diario SET tecnico_recibe = :tecnico WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':tecnico' => $tecnico, ':id' => $id]);
    }

    echo json_encode(['exito' => true, 'id_lote' => 123]); // Aquí deberías devolver el id real
} else {
    echo json_encode(['exito' => false]);
}
?>