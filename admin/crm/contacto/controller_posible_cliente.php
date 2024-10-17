<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

// Obtener los datos del formulario
$tipo_contacto = $_POST['tipo_contacto'];
$tipo_cliente = $_POST['tipo_cliente'];
$empresa = $_POST['empresa'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$contacto_id = $_POST['contacto_id'];
$user = $_POST['user'];


try {
    // Insertar el posible cliente vinculado al contacto
    $stmt = $pdo->prepare('INSERT INTO posible_cliente (nombre, direccion, ciudad, telefono, tipo_cliente, contacto, usuario) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$empresa, $direccion, $ciudad, $telefono, $tipo_cliente, $contacto_id, $user]);

    // Redirigir de vuelta a la lista de posibles clientes o una página de éxito
    header('Location: index.php');
    exit;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
