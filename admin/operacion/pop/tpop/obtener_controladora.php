<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

// Obtener el parámetro f_control desde la solicitud AJAX
$id_control = isset($_GET['id_control']) ? $_GET['id_control'] : '';

// Inicializar la respuesta
$response = array();

if ($id_control) {
    try {
        // Filtrar en la tabla referencias_control usando el campo "funcion"
        $query = $pdo->prepare("SELECT id_referencia, referencia FROM referencias_control WHERE funcion = :id_control");
        $query->bindParam(':id_control', $id_control, PDO::PARAM_INT);
        $query->execute();

        // Obtener los resultados
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados como JSON
        echo json_encode($result);

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
