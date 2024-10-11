<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

// Recibir el valor del campo 'tamano' enviado por POST
$codigo_compuesto = $_POST['tamano'];
$habilitar = $_POST['habilitado'];

// Descomponer el valor recibido en sus partes (primeros 3 números, la letra, últimos 3 números)
if (preg_match('/^(\d{3})([A-Z])(\d{3})$/i', $codigo_compuesto, $matches)) {
    // Guardar los primeros 3 números en la variable w
    $w = $matches[1];
    
    // Guardar los últimos 3 números en la variable q
    $q = $matches[3];
    
    // Guardar el valor completo en la variable ñ (sin modificar)
    $r = $codigo_compuesto;

    // Buscar una fila vacía en la tabla 'tabla_tamanos_modulos'
    $sql = "SELECT id FROM tabla_tamanos_modulos WHERE tamanos_modulos IS NULL OR tamanos_modulos = '' LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Actualizar la fila vacía encontrada con los datos descompuestos
        $id_vacio = $row['id'];
        $sql = "UPDATE tabla_tamanos_modulos 
                SET tamanos_modulos = :r, 
                    habilitar_tamano = :habilitar, 
                    tamano_x = :w, 
                    tamano_y = :q, 
                WHERE id = :id";
        $sentencia = $pdo->prepare($sql);
        $sentencia->bindParam(':r', $r);
        $sentencia->bindParam(':habilitar', $habilitar);
        $sentencia->bindParam(':w', $w);
        $sentencia->bindParam(':q', $q);
        $sentencia->bindParam(':id', $id_vacio);
    } else {
        // Insertar un nuevo registro si no hay filas vacías
        $sql = "INSERT INTO tabla_tamanos_modulos (tamanos_modulos, habilitar_tamano, tamano_x, tamano_y) 
                VALUES (:r, :habilitar, :w, :q)";
        $sentencia = $pdo->prepare($sql);
        $sentencia->bindParam(':r', $r);
        $sentencia->bindParam(':habilitar', $habilitar);
        $sentencia->bindParam(':w', $w);
        $sentencia->bindParam(':q', $q);
    }

    try {
        if ($sentencia->execute()) {
            session_start();
            $_SESSION['Mensajes'] = array(
                'title' => 'Good job!',
                'text' => '¡Datos guardados exitosamente!',
                'icon' => 'success'
            );
            header('Location: '.$URL.'admin/ti/partes_modulos/tamanos/');
            exit;
        } else {
            throw new Exception("Error al guardar los datos");
        }
    } catch (Exception $e) {
        session_start();
        $_SESSION['Mensajes'] = array(
            'title' => 'Error',
            'text' => 'Error al introducir la información: ' . $e->getMessage(),
            'icon' => 'error'
        );
        header('Location: ' . $URL . 'admin/ti/partes_modulos/tamanos/create.php');
        exit;
    }
} else {
    // Si el formato del código no es válido, manejar el error
    session_start();
    $_SESSION['Mensajes'] = array(
        'title' => 'Error',
        'text' => 'El valor no tiene el formato esperado. Debe tener el formato 123A456.',
        'icon' => 'error'
    );
    header('Location: ' . $URL . 'admin/ti/partes_modulos/tamanos/create.php');
    exit;
}
