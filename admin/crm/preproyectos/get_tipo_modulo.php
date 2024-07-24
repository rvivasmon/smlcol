<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$id_uso = $_GET['id_uso'];

$query = $pdo->prepare('SELECT id, modelo_modulo FROM t_tipo_producto WHERE uso_modelo = :id_uso');
$query->execute(['id_uso' => $id_uso]);
$tipos_modulo = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($tipos_modulo);
?>
