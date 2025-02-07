<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

// Obtener los parámetros de la solicitud AJAX
$id_modulo = isset($_GET['id_modulo']) ? $_GET['id_modulo'] : '';
$id_pitch = isset($_GET['id_pitch']) ? $_GET['id_pitch'] : '';

// Inicializar la respuesta
$response = array();

if ($id_modulo && $id_pitch) {
    try {
        // Filtrar en la tabla producto_modulo_creado usando "modelo" y "pitch"
        $query = $pdo->prepare("SELECT id, referencia FROM producto_modulo_creado WHERE modelo = :id_modulo AND pitch = :id_pitch");
        $query->bindParam(':id_modulo', $id_modulo, PDO::PARAM_INT);
        $query->bindParam(':id_pitch', $id_pitch, PDO::PARAM_INT);
        $query->execute();

        // Obtener los resultados
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // Verifica si se obtuvieron resultados
        if ($result) {
            $response = $result;
        } else {
            $response = ['message' => 'No se encontraron resultados'];
        }

    } catch (Exception $e) {
        $response = ['status' => 'error', 'message' => $e->getMessage()];
    }
}

// Devolver los resultados como JSON
echo json_encode($response);
?>
