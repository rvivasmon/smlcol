<?php
ob_start();
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');
include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

// Verificar la conexión a la base de datos
if (!$pdo instanceof PDO) {
    http_response_code(500);
    die("Error: No se pudo conectar a la base de datos.");
}

// Verificar que los datos están presentes y válidos
if (!isset($_POST['id_movimiento_diario'], $_POST['observacion'], $_POST['op']) || trim($_POST['observacion']) === '' || trim($_POST['op']) === '') {
    http_response_code(400);
    die("Error: Datos incompletos.");
}

// Convertir ID a entero y limpiar los datos
$id_movimiento_diario = (int) $_POST['id_movimiento_diario'];
$observacion = trim($_POST['observacion']);
$op = trim($_POST['op']);

// Verificar que ID sea válido
if ($id_movimiento_diario <= 0) {
    http_response_code(400);
    die("Error: ID inválido.");
}

// Consulta segura con PDO para actualizar observaciones y op
$sql = "UPDATE movimiento_diario 
        SET observaciones = :observacion, op = :op 
        WHERE id_movimiento_diario = :id_movimiento_diario";

try {
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':observacion', $observacion, PDO::PARAM_STR);
    $sentencia->bindParam(':op', $op, PDO::PARAM_STR);
    $sentencia->bindParam(':id_movimiento_diario', $id_movimiento_diario, PDO::PARAM_INT);

    if ($sentencia->execute()) {
        header('Location: ' . $URL . 'admin/almacen/stock/smartled');
        exit;
    } else {
        http_response_code(500);
        error_log("Error al actualizar datos: " . implode(", ", $sentencia->errorInfo()));
        echo "Error al actualizar los datos.";
    }
} catch (PDOException $e) {
    error_log("Error en la consulta: " . $e->getMessage());
    http_response_code(500);
    echo "Error al procesar la solicitud. Inténtalo más tarde.";
}

ob_end_flush();
?>
