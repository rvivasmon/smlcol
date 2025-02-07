<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

// Obtener el id_uso desde la solicitud AJAX
$id_uso = isset($_GET['id_uso']) ? $_GET['id_uso'] : '';

if ($id_uso) {
    // Consultar los productos relacionados con el id_uso
    $query = $pdo->prepare("SELECT id, tipo_producto21 FROM t_tipo_producto WHERE id_producto = :id_uso");
    $query->bindParam(':id_uso', $id_uso, PDO::PARAM_INT);
    $query->execute();

    // Obtener los resultados
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Retornar los resultados como JSON
    echo json_encode($result);
}
?>
