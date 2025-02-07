<?php 
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');


if (isset($_GET['pitch'])) {
    $pitch = $_GET['pitch'];

    $query = $pdo->prepare('
    SELECT pmc.tamano AS tamano, 
    ttm.tamanos_modulos AS descripcion
    FROM producto_modulo_creado AS pmc
    LEFT JOIN tabla_tamanos_modulos AS ttm ON pmc.tamano = ttm.id
    WHERE pmc.pitch = ?
');
    $query->execute([$pitch]);
    $medidas = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($medidas);
}

?>