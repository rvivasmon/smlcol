<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $placa = $_POST['placa'];
    $propietario = $_POST['propietario'];
    $tipo_vehiculo = $_POST['tipo_vehiculo'];
    $pico_placa = $_POST['pico_placa'];
    $soat_hasta = $_POST['soat_hasta'];
    $tecnicomecanica_hasta = $_POST['tecnicomecanica_hasta'];
    $usuario_crea_vehiculo = $_POST['usuario_crea_vehiculo'];
    $kilometraje_actual = $_POST['kilometraje_actual'];
    $observacion = $_POST['observacion'];

    $query = $pdo->prepare("INSERT INTO vehiculos (fecha_ingreso, placa, propietario, tipo_vehiculo, pico_placa, soat_hasta, tecnicomecanica_hasta, usuario_crea_vehiculo, kilometraje_actual, observacion) VALUES (:fecha_ingreso, :placa, :propietario, :tipo_vehiculo, :pico_placa, :soat_hasta, :tecnicomecanica_hasta, :usuario_crea_vehiculo, :kilometraje_actual, :observacion)");

    $query->bindParam(':fecha_ingreso', $fecha_ingreso);
    $query->bindParam(':placa', $placa);
    $query->bindParam(':propietario', $propietario);
    $query->bindParam(':tipo_vehiculo', $tipo_vehiculo);
    $query->bindParam(':pico_placa', $pico_placa);
    $query->bindParam(':soat_hasta', $soat_hasta);
    $query->bindParam(':tecnicomecanica_hasta', $tecnicomecanica_hasta);
    $query->bindParam(':usuario_crea_vehiculo', $usuario_crea_vehiculo);
    $query->bindParam(':kilometraje_actual', $kilometraje_actual);
    $query->bindParam(':observacion', $observacion);

    if ($query->execute()) {
        header("Location: " . $URL . "admin/administracion/vehiculos/index.php");
        exit();
    } else {
        echo "Error al insertar en la base de datos.";
    }
}