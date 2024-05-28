<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

$selected_ids = explode(',', $_POST['selected_ids']);
$num_envoys = $_POST['num_envoys'];
$ship = $_POST['ship'];
$guia = $_POST['guia'];
$fecha_guia = $_POST['fecha_guia'];
$obschina = $_POST['obschina'];

$placeholders = rtrim(str_repeat('?,', count($selected_ids)), ',');
$sql = "UPDATE tracking 
        SET num_envoys = ?, ship = ?, guia = ?, fecha_guia = ?, observaciones_china = ? 
        WHERE id IN ($placeholders)";

$stmt = $pdo->prepare($sql);
$params = [$num_envoys, $ship, $guia, $fecha_guia, $obschina];
$params = array_merge($params, $selected_ids);

if ($stmt->execute($params)) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'error' => $stmt->errorInfo()]);
}
?>
