<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$tipo = $_POST['tipo'];
$habilitar = $_POST['habilitado'];

$sql = "SELECT id FROM tabla_tipo_modulo WHERE tipo IS NULL OR tipo = '' LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    // Actualizar la fila vacía encontrada
    $id_vacio = $row['id'];
    $sql = "UPDATE tabla_tipo_modulo SET tipo = :tipo, habilitar_tipo = :habilitar WHERE id = :id";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':habilitar', $habilitar);
    $sentencia->bindParam(':id', $id_vacio);
} else {
    // Insertar un nuevo registro si no hay filas vacías
    $sql = "INSERT INTO tabla_tipo_modulo (tipo, habilitar_tipo) VALUES (:tipo, :habilitar)";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':tipo', $tipo);
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
        header('Location: '.$URL.'admin/ti/partes_modulos/tipos/');
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
    header('Location: ' . $URL . 'admin/ti/partes_modulos/tipos/create.php');
    exit;
}

