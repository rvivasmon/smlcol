<?php

include('../../app/config/config.php');
include('../../app/config/conexion.php');
include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

$id_qr = $_POST['producto_id'];
$idprod = $_POST['idproducto'];
$url = $_POST['url'];
$qr_base64 = $_POST['qr_code']; // El QR como base64
$contador = $_POST['contador_prod'];

try {
    // Verificar que el directorio para las imágenes QR exista, si no, crearlo
    $qr_image_dir = '../../img_uploads/qr_images/';
    if (!is_dir($qr_image_dir)) {
        mkdir($qr_image_dir, 0777, true);
    }

    // Iniciar transacción
    $pdo->beginTransaction();

    // Validar el QR base64
    if (empty($qr_base64) || !preg_match('#^data:image/\w+;base64,#i', $qr_base64)) {
        throw new Exception('El QR no es válido.');
    }

    // Limpiar la cadena base64 para eliminar la cabecera 'data:image/...;base64,'
    $qr_base64_clean = preg_replace('#^data:image/\w+;base64,#i', '', $qr_base64);
    
    // Decodificar la cadena base64 y guardarla como imagen
    $qr_image = base64_decode($qr_base64_clean);
    
    // Verificar si la decodificación fue exitosa
    if ($qr_image === false) {
        throw new Exception('Error al decodificar la imagen QR.');
    }

    // Guardar el archivo del QR
    $qr_image_name = 'qr_' . $idprod . '.png'; // Nombre del archivo
    $qr_image_path = $qr_image_dir . $qr_image_name; // Ruta completa

    // Guardar la imagen del QR en el directorio
    if (!file_put_contents($qr_image_path, $qr_image)) {
        throw new Exception('Error al guardar la imagen del QR.');
    }

    // Guardar los datos en la tabla id_producto
    $sql = "UPDATE id_producto 
            SET id_producto = :idprod, url = :url, qr_image_path = :qr_image_path, contador_prod = :contador
            WHERE id = :id_qr";

    $sentencia = $pdo->prepare($sql);

    $sentencia->bindParam(':id_qr', $id_qr);
    $sentencia->bindParam(':idprod', $idprod);
    $sentencia->bindParam(':url', $url);
    $sentencia->bindParam(':qr_image_path', $qr_image_path);
    $sentencia->bindParam(':contador', $contador);

    $sentencia->execute();

    // Confirmar la transacción
    $pdo->commit();

    // Enviar mensaje de éxito y redirigir
    session_start();
    $_SESSION['Mensajes'] = array(
        'title' => 'Éxito',
        'text' => 'Datos guardados correctamente.',
        'icon' => 'success'
    );
    header('Location: ' . $URL . 'admin/planta/');
    exit;
} catch (Exception $e) {
    // En caso de error, revertir la transacción
    $pdo->rollBack();

    // Mostrar mensaje de error y redirigir
    session_start();
    $_SESSION['Mensajes'] = array(
        'title' => 'Error',
        'text' => 'Error al guardar los datos: ' . $e->getMessage(),
        'icon' => 'error'
    );
    header('Location: ' . $URL . 'admin/planta/');
    exit;
}
?>
