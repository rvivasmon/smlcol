<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$refresh = $_POST['refresh'];
$habilitar = $_POST['habilitado'];

$sql = "SELECT id FROM tabla_nits_refresh WHERE refresh IS NULL OR refresh = '' LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    // Actualizar la fila vacía encontrada
    $id_vacio = $row['id'];
    $sql = "UPDATE tabla_nits_refresh SET refresh = :refresh, habilitar_refresh = :habilitar WHERE id = :id";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':refresh', $refresh);
    $sentencia->bindParam(':habilitar', $habilitar);
    $sentencia->bindParam(':id', $id_vacio);
} else {
    // Insertar un nuevo registro si no hay filas vacías
    $sql = "INSERT INTO tabla_nits_refresh (refresh, habilitar_refresh) VALUES (:refresh, :habilitar)";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':refresh', $refresh);
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
        header('Location: '.$URL.'admin/ti/partes_modulos/refresh/');
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
    header('Location: ' . $URL . 'admin/ti/partes_modulos/refresh/create.php');
    exit;
}

