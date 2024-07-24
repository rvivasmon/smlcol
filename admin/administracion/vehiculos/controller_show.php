<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');


// Fin del código para generar el ID VEHICULOS
$id_get = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM vehiculos WHERE vehiculos.id = '$id_get' ");

$query->execute();
$vehiculo = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($vehiculo as $vehiculos){
    $id = $vehiculos['id'];
    $usuario_crea_vehiculo = $_POST['usuario_crea_vehiculo'];
    $placa = $vehiculos['placa'];
    $propietario = $vehiculos['propietario'];
    $tipo_vehiculo = $vehiculos['tipo_vehiculo'];
    $pico_placa = $vehiculos['pico_placa'];
    $soat_hasta = $vehiculos['soat_hasta'];
    $tecnicomecanica_hasta = $vehiculos['tecnicomecanica_hasta'];
    $usuario_crea_tarea = $_POST['usuario_crea_tarea'];
    $usuario_termina_tarea = $_POST['usuario_termina_tarea'];
    $tarea_realizar = $vehiculos['tarea_realizar'];
    $clase_tarea = $_POST['clase_tarea'];
    $fecha_tarea =$vehiculos['fecha_tarea'];
    $observacion = $vehiculos['observacion'];
}