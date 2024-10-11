<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$producto = $_POST['producto'];
$habilitar = $_POST['habilitado'];

$sql = "SELECT id FROM t_tipo_producto WHERE tipo_producto21 IS NULL OR tipo_producto21 = '' LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    // Actualizar la fila vacía encontrada
    $id_vacio = $row['id'];
    $sql = "UPDATE t_tipo_producto SET tipo_producto21 = :producto, habilitar_producto = :habilitar WHERE id = :id";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':producto', $producto);
    $sentencia->bindParam(':habilitar', $habilitar);
    $sentencia->bindParam(':id', $id_vacio);
} else {
    // Insertar un nuevo registro si no hay filas vacías
    $sql = "INSERT INTO t_tipo_producto (tipo_producto21, habilitar_producto) VALUES (:producto, :habilitar)";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':producto', $producto);
    $sentencia->bindParam(':habilitar', $habilitar);
}

try {
    if ($sentencia->execute()) {
        session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Good job!',
            'text' => '¡Usuario creado exitosamente!',
            'icon' => 'success'
        );
        header('Location: '.$URL.'admin/ti/partes_modulos/productos/');
        exit;
    } else {
        throw new Exception("Error al insertar el usuario");
    }
} catch (Exception $e) {
    session_start();
    $_SESSION['Mensajes'] = array(
        'title' => 'Error',
        'text' => 'Error al introducir la información: ' . $e->getMessage(),
        'icon' => 'error'
    );
    header('Location: ' . $URL . 'admin/ti/partes_modulos/productos/create.php');
    exit;
}

