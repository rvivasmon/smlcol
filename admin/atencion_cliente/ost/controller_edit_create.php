<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

// Obtiene los datos del formulario
$id_ost = $_POST['id_ost'];
$tipo_servicio = $_POST['tipo_servicio'];
$estado = $_POST['estado35'];
$observacion = $_POST['observacion'];
$id_usuario = $_POST['id_usuario'];    
$tecnico_tratante = $_POST['tecnico_tratante'];
$id_stc = $_POST['id_stc'];

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
    // Si la actualización en OST fue exitosa y el estado es 5 o 6, actualiza el estado_ticket
    if ($estado == 5 || $estado == 6) {
        $sql_update_ticket = "UPDATE ost SET estado_ticket = :estado_ticket WHERE id = :id";
        $stmt_update_ticket = $pdo->prepare($sql_update_ticket);
        $nuevo_estado_ticket = 2; // Nuevo valor para estado_ticket
        $stmt_update_ticket->bindParam(':estado_ticket', $nuevo_estado_ticket, PDO::PARAM_INT);
        $stmt_update_ticket->bindParam(':id', $id_usuario, PDO::PARAM_INT); // Asumiendo que $id_ost es el ID del ticket en la tabla stc
        $stmt_update_ticket->execute();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $estado = $_POST['estado'];
        $id_ost = $_POST['id_ost'];
        $id_stc = $_POST['id_stc']; // Asegúrate de obtener este valor en tu formulario
    
        // Si el estado es 5 o 6, mostramos el modal de confirmación en el lado del cliente (JS)
    
        // Si el usuario selecciona "Sí", actualizamos estado_ticket a 2 en la tabla "stc"
        if (isset($_POST['cerrar_stc']) && $_POST['cerrar_stc'] == 'yes') {
            $sql_update_ticket = "UPDATE stc SET estado_ticket = :estado_ticket WHERE id = :id_stc";
            $stmt_update_ticket = $pdo->prepare($sql_update_ticket);
            $nuevo_estado_ticket = 2;
            $stmt_update_ticket->bindParam(':estado_ticket', $nuevo_estado_ticket, PDO::PARAM_INT);
            $stmt_update_ticket->bindParam(':id_stc', $id_stc, PDO::PARAM_INT);
            $stmt_update_ticket->execute();

        // Si el usuario selecciona "No", incrementamos el campo contador_casos en la tabla "stc"
        } elseif (isset($_POST['cerrar_stc']) && $_POST['cerrar_stc'] == 'no') {
    
            $sql_update_casos = "UPDATE stc SET contador_casos = contador_casos + 1 WHERE id = :id_stc";
            $stmt_update_casos = $pdo->prepare($sql_update_casos);
            $stmt_update_casos->bindParam(':id_stc', $id_stc, PDO::PARAM_INT);
            $stmt_update_casos->execute();

            // Redireccionamos a la edición de STC
            header('Location: edit_index.php?id=' . $id_stc);
            exit();
        }
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
