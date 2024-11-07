<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

// Obtener el ID del caso desde la URL
if (isset($_GET['id'])) {
    $id_caso = $_GET['id'];

    // Consulta para obtener los detalles del caso
    $casoQuery = $pdo->prepare('SELECT * FROM ost WHERE id = :id');
    $casoQuery->bindParam(':id', $id_caso, PDO::PARAM_INT);
    $casoQuery->execute();
    $caso = $casoQuery->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Casos</title>
    <link rel="stylesheet" href="path/to/your/css/bootstrap.min.css"> <!-- Asegúrate de incluir Bootstrap -->
</head>
<body>
    <div class="container">
        <h1>Detalles del Caso</h1>
        <?php if ($caso): ?>
            <p>FECHA: <?php echo $caso['fecha_ost']; ?></p>
            <p>ID: <?php echo $caso['id_ost']; ?></p>
            <p>CLIENTE: <?php echo $caso['cliente']; ?></p>
            <p>PROYECTO: <?php echo $caso['proyecto']; ?></p>
            <p>CIUDAD: <?php echo $caso['ciudad']; ?></p>
            <p>FALLA: <?php echo $caso['falla']; ?></p>
            <p>OBSERVACIÓN: <?php echo $caso['observacion']; ?></p>
            <!-- Muestra aquí otros campos relevantes -->
        <?php else: ?>
            <p>No se encontraron detalles para este caso.</p>
        <?php endif; ?>
        <a href="javascript:window.close();" class="btn btn-secondary">Cerrar</a> <!-- Botón para cerrar la ventana -->
    </div>
</body>
</html>
