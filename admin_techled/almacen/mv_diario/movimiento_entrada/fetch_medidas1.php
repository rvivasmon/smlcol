<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

if (isset($_GET['pitch'])) {
    $pitchValue = $_GET['pitch'];

    $query = $pdo->prepare('SELECT id_car_mod, medida_x, medida_y, pixel_x, pixel_y, serie_modulo, referencia_modulo FROM caracteristicas_modulos WHERE id_car_mod = :pitchValue');
    $query->execute(['pitchValue' => $pitchValue]);
    $medidas = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($medidas);
}
