<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');


if (isset($_GET['medida'])) {
    $medida = $_GET['medida'];

    $query = $pdo->prepare('SELECT tamano_x, tamano_y FROM producto_modulo_creado WHERE tamano = ? LIMIT 1');
    $query->execute([$medida]);
    $tamanos = $query->fetch(PDO::FETCH_ASSOC);

    echo json_encode($tamanos);
}
?>
