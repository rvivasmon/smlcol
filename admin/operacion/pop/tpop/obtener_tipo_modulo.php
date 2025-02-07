<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

// Obtener el parámetro desde la solicitud AJAX
$id_uso = isset($_GET['id_uso']) ? $_GET['id_uso'] : '';

if ($id_uso) {
    // Consultar los módulos de acuerdo con el uso_pan (que se compara con uso_modelo)
    $query = $pdo->prepare("SELECT id, modelo_modulo FROM t_tipo_producto WHERE uso_modelo = :id_uso");
    $query->bindParam(':id_uso', $id_uso, PDO::PARAM_INT);
    $query->execute();

    // Obtener los resultados
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Retornar los resultados como JSON
    echo json_encode($result);
}
?>
