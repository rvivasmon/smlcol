<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

// Verificar si se recibió el valor de pitchSeleccionado
if (isset($_POST['pitchSeleccionado'])) {
    // Obtener el valor de pitchSeleccionado
    $pitchSeleccionado = $_POST['pitchSeleccionado'];

    // Realizar la consulta SQL para obtener las series de módulos correspondientes al pitch seleccionado
    $query = $pdo->prepare('SELECT serie_modulo FROM almacen_principal WHERE pitch = :pitch');
    $query->bindParam(':pitch', $pitchSeleccionado);
    $query->execute();
    $series = $query->fetchAll(PDO::FETCH_ASSOC);

    // Generar las opciones en formato HTML
    $options = '<option value="">Seleccione una Serie</option>';
    foreach ($series as $serie) {
        $options .= '<option value="' . $serie['serie_modulo'] . '">' . $serie['serie_modulo'] . '</option>';
    }

    // Devolver las opciones al cliente
    echo $options;
} else {
    // Si no se recibió el valor de pitchSeleccionado, devolver un mensaje de error
    echo 'Error: No se recibió el valor de pitchSeleccionado';
}
?>
