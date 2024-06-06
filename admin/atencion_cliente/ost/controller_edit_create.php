<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

// Obtiene los datos del formulario
$id_ost = $_POST['id_ost'];
$tipo_servicio = $_POST['tipo_servicio'];
$estado = $_POST['estado'];
$observacion = $_POST['observacion'];
$id_usuario = $_POST['id_usuario'];    
$tecnico_tratante = $_POST['tecnico_tratante'];

// Manejo de archivos
$archivos = $_FILES['archivo_adjunto'];
$nombres_archivos = [];

$upload_dir = '../../../img_uploads/';

for ($i = 0; $i < count($archivos['name']); $i++) {
    if (!empty($archivos['name'][$i])) {
        $file_name = basename($archivos['name'][$i]);
        $target_file = $upload_dir . $file_name;

        // Mueve el archivo cargado a la carpeta de destino
        if (move_uploaded_file($archivos['tmp_name'][$i], $target_file)) {
            $nombres_archivos[] = $file_name;
        } else {
            // Manejo de errores en la carga del archivo
            session_start();
            $_SESSION['msj'] = "Error al subir el archivo.";
            header('Location:' . $URL . 'admin/atencion_cliente/ost/index_create.php');
            exit();
        }
    }
}

$evidencia = implode(',', $nombres_archivos);

// Inserta los datos en la tabla OST
$parametros = [
    ':tipo_servicio' => $tipo_servicio,
    ':estado' => $estado,
    ':observacion' => $observacion,
    ':tecnico_tratante' => $tecnico_tratante,
    ':id' => $id_usuario
];

$sql = "UPDATE ost SET tipo_servicio = :tipo_servicio, estado = :estado, observacion = :observacion, tecnico_tratante = :tecnico_tratante";

if (!empty($evidencia)) {
    $sql .= ", evidencia = :archivos";
    $parametros[':archivos'] = $evidencia;
}

$sql .= " WHERE id = :id";

$sentencia = $pdo->prepare($sql);

// Ejecuta la consulta
if ($sentencia->execute($parametros)) {
    // Si la actualización en OST fue exitosa y el estado es 5, actualiza el estado_ticket
    if ($estado == 5) {
        $sql_update_ticket = "UPDATE ost SET estado_ticket = :estado_ticket WHERE id = :id";
        $stmt_update_ticket = $pdo->prepare($sql_update_ticket);
        $nuevo_estado_ticket = 2; // Nuevo valor para estado_ticket
        $stmt_update_ticket->bindParam(':estado_ticket', $nuevo_estado_ticket, PDO::PARAM_INT);
        $stmt_update_ticket->bindParam(':id', $id_usuario, PDO::PARAM_INT); // Asumiendo que $id_ost es el ID del ticket en la tabla stc
        $stmt_update_ticket->execute();
    }

    // Redirige o maneja el mensaje de éxito
    session_start();
    $_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
    header('Location:' . $URL . 'admin/atencion_cliente/ost/index_create.php');
} else {
    // Si hubo un error en la actualización en OST, maneja el mensaje de error
    session_start();
    $_SESSION['msj'] = "Error al introducir la información";
    header('Location:' . $URL . 'admin/atencion_cliente/ost/index_create.php');
}
?>
