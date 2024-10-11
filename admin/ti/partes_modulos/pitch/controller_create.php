<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$pitch = $_POST['pitch'];
$habilitar = $_POST['habilitado'];

$sql = "SELECT id FROM tabla_pitch WHERE pitch IS NULL OR pitch = '' LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    // Actualizar la fila vacía encontrada
    $id_vacio = $row['id'];
    $sql = "UPDATE tabla_pitch SET pitch = :pitch, habilitar_pitch = :habilitar WHERE id = :id";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':pitch', $pitch);
    $sentencia->bindParam(':habilitar', $habilitar);
    $sentencia->bindParam(':id', $id_vacio);
} else {
    // Insertar un nuevo registro si no hay filas vacías
    $sql = "INSERT INTO tabla_pitch (pitch, habilitar_pitch) VALUES (:pitch, :habilitar)";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':pitch', $pitch);
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
        header('Location: '.$URL.'admin/ti/partes_modulos/pitch/');
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
    header('Location: ' . $URL . 'admin/ti/partes_modulos/pitch/create.php');
    exit;
}

