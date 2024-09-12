<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

// Obtener el valor de id_referencia desde la solicitud
$id_referencia = isset($_GET['id_referencia']) ? intval($_GET['id_referencia']) : 0;

if ($id_referencia > 0) {
    // Consulta para obtener los detalles basados en id_referencia
    $sql = "SELECT id_referencia, sim, puertos, px_x_puerto, pixel_max, pixel_x_max, pixel_y_max, descripcion 
            FROM referencias_control 
            WHERE id_referencia = ?";
    
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_referencia);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener los resultados en un array asociativo
        $detalles = $result->fetch_assoc();
        // Enviar la respuesta como JSON
        echo json_encode($detalles);
    } else {
        // Si no se encuentran registros, devolver un array vacío
        echo json_encode([]);
    }

    // Cerrar la consulta
    $stmt->close();
} else {
    // Si no se proporciona un id_referencia válido, devolver un array vacío
    echo json_encode([]);
}

// Cerrar la conexión
$conn->close();
?>

