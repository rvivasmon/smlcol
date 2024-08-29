<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

if (isset($_GET['uso'])) {
    $usoId = $_GET['uso'];

    $query = $pdo->prepare('SELECT id, modelo_modulo FROM t_tipo_producto WHERE uso_modelo = :usoId');
    $query->execute(['usoId' => $usoId]);
    $modelos = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($modelos);
}
