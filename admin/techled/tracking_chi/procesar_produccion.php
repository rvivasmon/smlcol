<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener la fecha actual
    $fecha_actual = date('Y-m-d');

    $query = $pdo->prepare("UPDATE tracking SET en_produccion = 1, inicio_produccion = :inicio_produccion WHERE id = :id");
    $query->bindParam(':inicio_produccion', $fecha_actual);
    $query->bindParam(':id', $id);

    if ($query->execute()) {
        // Redirigir de vuelta a la página de solicitudes activas
        // header("Location: solicitudes_activas.php");
        header("Location: index.php");
        exit();
    } else {
        echo "Error al iniciar la producción del producto.";
    }

} else {
    echo "ID no proporcionado.";
}
?>
