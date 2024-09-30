<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

// Verificar si se ha enviado el formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $id = $_POST['id'];  // Asegúrate de tener el campo hidden con el ID en el formulario
    $fecha_edicion = $_POST['fecha_edicion'];
    $placa = $_POST['placa'];
    $propietario = $_POST['propietario'];
    $tipo_vehiculo = $_POST['tipo_vehiculo'];
    $pico_placa = $_POST['pico_placa'];
    $soat_hasta = $_POST['soat_hasta'];
    $tecnicomecanica_hasta = $_POST['tecnicomecanica_hasta'];
    $usuario_crea_tarea = $_POST['usuario_crea_tarea'];
    $observacion = $_POST['observacion'];
    $es_electrico = $_POST['es_electrico'];

     // Si el checkbox "es_electrico" no está presente en el POST, asignar 0
    $es_electrico = isset($_POST['es_electrico']) ? 1 : 0;

    // Actualizar el registro en la base de datos
    $query = $pdo->prepare("UPDATE vehiculos SET 
        fecha_ingreso = :fecha_edicion,
        placa = :placa,
        propietario = :propietario,
        tipo_vehiculo = :tipo_vehiculo,
        pico_placa = :pico_placa,
        soat_hasta = :soat_hasta,
        tecnicomecanica_hasta = :tecnicomecanica_hasta,
        observacion = :observacion,
        electrico = :es_electrico,
        usuario_crea_vehiculo = :usuario_crea_tarea 
        WHERE id = :id");

    $query->bindParam(':id', $id);
    $query->bindParam(':fecha_edicion', $fecha_edicion);
    $query->bindParam(':placa', $placa);
    $query->bindParam(':propietario', $propietario);
    $query->bindParam(':tipo_vehiculo', $tipo_vehiculo);
    $query->bindParam(':pico_placa', $pico_placa);
    $query->bindParam(':soat_hasta', $soat_hasta);
    $query->bindParam(':tecnicomecanica_hasta', $tecnicomecanica_hasta);
    $query->bindParam(':usuario_crea_tarea', $usuario_crea_tarea);
    $query->bindParam(':observacion', $observacion);
    $query->bindParam(':es_electrico', $es_electrico);

    if ($query->execute()) {
        header("Location: " . $URL . "admin/administracion/vehiculos/index.php");
        exit();
    } else {
        echo "Error al actualizar en la base de datos.";
    }
}
