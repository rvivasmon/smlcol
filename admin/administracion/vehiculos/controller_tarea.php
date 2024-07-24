<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

// Verificar si se ha enviado el formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $fecha_asignacion_tarea = $_POST['fecha_asignacion_tarea'];
    $placa = $_POST['placa'];
    $propietario = $_POST['propietario'];
    $tipo_vehiculo = $_POST['tipo_vehiculo'];
    $pico_placa = $_POST['pico_placa'];
    $soat_hasta = $_POST['soat_hasta'];
    $tecnicomecanica_hasta = $_POST['tecnicomecanica_hasta'];
    $tarea_realizar = $_POST['tarea_realizar'];
    $clase_tarea = $_POST['clase_tarea'];
    $usuario_crea_tarea = $_POST['usuario_crea_tarea'];
    $observacion = $_POST['observacion'];
    $fecha_tarea = $_POST['fecha_tarea'];

    // Actualizar el registro en la base de datos
    $query = $pdo->prepare("UPDATE vehiculos SET fecha_asignacion_tarea = :fecha_asignacion_tarea, tarea_realizar = :tarea_realizar, observacion = :observacion, fecha_tarea = :fecha_tarea, clase_tarea = :clase_tarea, usuario_crea_tarea = :usuario_crea_tarea WHERE placa = :placa");

    $query->bindParam(':fecha_asignacion_tarea', $fecha_asignacion_tarea);
    $query->bindParam(':clase_tarea', $clase_tarea);
    $query->bindParam(':usuario_crea_tarea', $usuario_crea_tarea);
    $query->bindParam(':tarea_realizar', $tarea_realizar);
    $query->bindParam(':observacion', $observacion);
    $query->bindParam(':fecha_tarea', $fecha_tarea);
    $query->bindParam(':placa', $placa);;


    if ($query->execute()) {
        header("Location: " . $URL . "admin/administracion/vehiculos/index.php");
        exit();
    } else {
        echo "Error al actualizar en la base de datos.";
    }
}