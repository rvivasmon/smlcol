<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

$uso = $_POST['uso'];
$modelo = $_POST['modelo'];
$habilitar = $_POST['habilitado'];


$sql = "SELECT id FROM t_tipo_producto WHERE modelo_modulo IS NULL OR modelo_modulo = '' LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    // Actualizar la fila vacía encontrada
    $id_vacio = $row['id'];
    $sql = "UPDATE t_tipo_producto SET modelo_modulo = :modelo, habilitar_modelo_modulo = :habilitar, uso_modelo = :uso WHERE id = :id";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':modelo', $modelo);
    $sentencia->bindParam(':habilitar', $habilitar);
    $sentencia->bindParam(':uso', $uso);
    $sentencia->bindParam(':id', $id_vacio);
} else {
    // Insertar un nuevo registro si no hay filas vacías
    $sql = "INSERT INTO t_tipo_producto (modelo, habilitar_modelo_modulo, uso_modelo) VALUES (:modelo, :habilitar, :uso)";
    $sentencia = $pdo->prepare($sql);
    $sentencia->bindParam(':modelo', $modelo);
    $sentencia->bindParam(':habilitar', $habilitar);
    $sentencia->bindParam(':uso', $uso);
}

try {
    if ($sentencia->execute()) {
        session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Good job!',
            'text' => '¡Usuario creado exitosamente!',
            'icon' => 'success'
        );
        header('Location: '.$URL.'admin/ti/partes_modulos/modelos_usos/');
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
    header('Location: ' . $URL . 'admin/ti/partes_modulos/modelos_usos/create.php');
    exit;
}

