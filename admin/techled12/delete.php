<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

// Verifica si el parámetro 'id' fue enviado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("El parámetro 'id' es obligatorio.");
}

$id = $_GET['id'];

// Consulta para obtener la información del registro (incluyendo el archivo)
$sql_select = "SELECT archivo FROM techled WHERE id = :id";
$stmt_select = $pdo->prepare($sql_select);
$stmt_select->bindParam(':id', $id, PDO::PARAM_INT);
$stmt_select->execute();

$registro = $stmt_select->fetch(PDO::FETCH_ASSOC);

if (!$registro) {
    die("El registro no existe.");
}

// Elimina el archivo del servidor, si existe
if (!empty($registro['archivo']) && file_exists($registro['archivo'])) {
    unlink($registro['archivo']);
}

// Consulta para eliminar el registro
$sql_delete = "DELETE FROM techled WHERE id = :id";
$stmt_delete = $pdo->prepare($sql_delete);
$stmt_delete->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt_delete->execute()) {
    // Redirige a la página principal o muestra un mensaje de éxito
    header('Location: index.php?message=Registro eliminado correctamente');
    exit;
} else {
    die("Error al eliminar el registro.");
}
?>
