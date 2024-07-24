<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$id_categoria = $_GET['id_categoria'];

$query = $pdo->prepare('SELECT id, uso_productos FROM t_uso_productos WHERE categoria_productos = :id_categoria');
$query->execute(['id_categoria' => $id_categoria]);
$usos = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($usos);
?>
