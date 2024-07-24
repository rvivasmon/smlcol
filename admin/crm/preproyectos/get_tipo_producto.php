<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$id_categoria = $_GET['id_categoria'];

$query = $pdo->prepare('SELECT id, tipo_producto21 FROM t_tipo_producto WHERE id_producto = :id_categoria');
$query->execute(['id_categoria' => $id_categoria]);
$tipos_producto = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($tipos_producto);
?>
