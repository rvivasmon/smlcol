<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

if (isset($_GET['modelo'])) {
    $modeloId = $_GET['modelo'];

    $query = $pdo->prepare('SELECT id_car_mod, pitch FROM caracteristicas_modulos WHERE modelo_modulo = :modeloId');
    $query->execute(['modeloId' => $modeloId]);
    $pitches = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($pitches);
}
