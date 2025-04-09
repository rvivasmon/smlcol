<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener la fecha actual
    $fecha_actual = date('Y-m-d');

    $query = $pdo->prepare("UPDATE tracking SET finished = 1, date_finished = :date_finished WHERE id = :id");
    $query->bindParam(':date_finished', $fecha_actual);
    $query->bindParam(':id', $id);

    if ($query->execute()) {
        // Redirigir de vuelta a la página de solicitudes activas
        header("Location: index.php");
        exit();
    } else {
        echo "Error al terminar la producción del producto.";
    }
} else {
    echo "ID no proporcionado.";
}
?>
