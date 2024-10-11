<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$nits = $_POST['nits'];
$habilitar = $_POST['habilitado'];


$sql = "SELECT id FROM tabla_nits_refresh WHERE nits IS NULL OR nits = '' LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    // Actualizar la fila vacía encontrada
    $id_vacio = $row['id'];
    $sql = "UPDATE tabla_nits_refresh SET nits = :nits, habilitar_nits = :habilitar WHERE id = :id";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':nits', $nits);
    $sentencia->bindParam(':habilitar', $habilitar);
    $sentencia->bindParam(':id', $id_vacio);
} else {
    // Insertar un nuevo registro si no hay filas vacías
    $sql = "INSERT INTO tabla_nits_refresh (nits, habilitar_nits) VALUES (:nits, :habilitar)";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':nits', $nits);
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
        header('Location: '.$URL.'admin/ti/partes_modulos/nits/');
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
    header('Location: ' . $URL . 'admin/ti/partes_modulos/nits/create.php');
    exit;
}

