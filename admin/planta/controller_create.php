<?php

include('../../app/config/config.php');
include('../../app/config/conexion.php');
include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

$fcreacion = $_POST['fechaingreso'];
$op = $_POST['OP'];
$agente = $_POST['agente'];
$idprod = $_POST['idproducto'];
$anio_mes1 = $_POST['anio_mes1'];
$contador1 = $_POST['contador1'];
$url = $_POST['url'];
$qr_base64 = $_POST['qr_code']; // El QR como base64

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
    $sql = "INSERT INTO id_producto (fecha, op, agente, id_producto, anio_mes_prod, contador_prod, url, qr_image_path)
            VALUES (:fcreacion, :op, :agente, :idprod, :anio_mes1, :contador1, :url, :qr_image_path)";
    $sentencia = $pdo->prepare($sql);

    $sentencia->bindParam(':fcreacion', $fcreacion);
    $sentencia->bindParam(':op', $op);
    $sentencia->bindParam(':agente', $agente);
    $sentencia->bindParam(':idprod', $idprod);
    $sentencia->bindParam(':anio_mes1', $anio_mes1);
    $sentencia->bindParam(':contador1', $contador1);
    $sentencia->bindParam(':url', $url);
    $sentencia->bindParam(':qr_image_path', $qr_image_path);

    if ($sentencia->execute()) {
        // Actualizar la tabla op
        $sql_update_op = "UPDATE op SET id_producto = 2 WHERE id = :op_id";
        $sentencia_update = $pdo->prepare($sql_update_op);
        $sentencia_update->bindParam(':op_id', $op);

        if ($sentencia_update->execute()) {
            $pdo->commit();

            // Mensaje de éxito
            session_start();
            $_SESSION['Mensajes'] = array(
                'title' => 'Good job!',
                'text' => '¡Registro creado exitosamente!',
                'icon' => 'success'
            );
            header('Location: ' . $URL . 'admin/planta/');
            exit;
        } else {
            $pdo->rollBack();
            throw new Exception("Error al actualizar la tabla op.");
        }
    } else {
        $pdo->rollBack();
        throw new Exception("Error al insertar en la tabla id_producto.");
    }
} catch (Exception $e) {
    // En caso de error, mostrar mensaje y redirigir
    $pdo->rollBack();

    session_start();
    $_SESSION['Mensajes'] = array(
        'title' => 'Error',
        'text' => 'Error al guardar los datos: ' . $e->getMessage(),
        'icon' => 'error'
    );
    header('Location: ' . $URL . 'admin/planta/create.php');
    exit;
}
?>
