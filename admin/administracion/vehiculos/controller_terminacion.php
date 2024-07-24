<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placa = $_POST['placa'];
    $propietario = $vehiculo['propietario'];
    $usuario_termina_tarea = $_POST['usuario_termina_tarea'];
    $tarea_realizar = 'TAREA TERMINADA'; // Mensaje de TAREA TERMINADA automáticamente
    $observacion = $_POST['observacion'];
    $fecha_terminacion = $_POST['fecha_terminacion'];
    $fecha_tarea ='TAREA TERMINADA';

    $query = $pdo->prepare("UPDATE vehiculos SET tarea_realizar = :tarea_realizar, usuario_termina_tarea = :usuario_termina_tarea, observacion = :observacion, fecha_terminacion = :fecha_terminacion, fecha_tarea = :fecha_tarea WHERE placa = :placa");

    $query->bindParam(':tarea_realizar', $tarea_realizar);
    $query->bindParam(':usuario_termina_tarea', $usuario_termina_tarea);
    $query->bindParam(':observacion', $observacion);
    $query->bindParam(':fecha_terminacion', $fecha_terminacion);
    $query->bindParam(':fecha_tarea', $fecha_tarea);
    $query->bindParam(':placa', $placa);

    if ($query->execute()) {
        header("Location: ../../admin/administracion/vehiculos/index.php");
        exit();
    } else {
        echo "Error al actualizar en la base de datos.";
    }
}