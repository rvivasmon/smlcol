<?php 
include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

// Capturar el ID desde el formulario, la observación y la ubicación
$id = $_POST['id_control21'] ?? null;
$observacion = $_POST['observacion21'] ?? '';
$ubicacion = $_POST['ubicacion'] ?? ''; // Capturar la ubicación

if (!$id) {
    echo "ID no proporcionado.";
    exit;
}

// Verificar si los datos están siendo capturados
var_dump($id, $observacion, $ubicacion);

// Consulta SQL para actualizar la observación y la posición (ubicación)
$sql = "UPDATE alma_smartled 
        SET observacion = :observacion, 
            posicion = :ubicacion 
        WHERE id_almacen_principal = :id";

// Preparar la consulta
$sentencia = $pdo->prepare($sql);

// Asignar los parámetros necesarios
$sentencia->bindParam(':observacion', $observacion);
$sentencia->bindParam(':ubicacion', $ubicacion);
$sentencia->bindParam(':id', $id);

// Ejecutar la consulta
if ($sentencia->execute()) {
    echo "Usuario actualizado exitosamente"; // Mensaje de éxito
    header('Location: ' . $URL . 'admin/almacen/inventario/principal/control/');
    exit; // Asegurar la redirección
} else {
    // Manejar los posibles errores durante la ejecución
    $errorInfo = $sentencia->errorInfo();
    echo "Error al actualizar el usuario: " . $errorInfo[2]; // Mensaje de error con detalles
}
?>
