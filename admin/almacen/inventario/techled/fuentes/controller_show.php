<?php

$id_fuente = $_GET['id'];

    $query = $pdo->prepare('SELECT 
    ap.*,
    cf.marca_fuente as nombre_marca,
    cf1.tipo_fuente as nombre_tipo,
    rf.voltaje_salida as nombre_voltaje,
    rf.modelo_fuente as nombre_modelo,
    da.posiciones as nombre_posicion
FROM
    alma_principal AS ap
INNER JOIN 
    referencias_fuente AS rf ON ap.producto = rf.id_referencias_fuentes
LEFT JOIN
    caracteristicas_fuentes AS cf ON rf.marca_fuente = cf.id_car_fuen
LEFT JOIN
    caracteristicas_fuentes AS cf1 ON rf.tipo_fuente = cf1.id_car_fuen
LEFT JOIN
    distribucion_almacen AS da ON ap.posicion = da.id
WHERE
    ap.id_almacen_principal = :id_fuente
');

$query->execute(['id_fuente' => $id_fuente]);
$almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($almacenes_pricipales as $almacen_pricipal){
    $id = $almacen_pricipal['id_almacen_principal'];
    $marca_fuente = $almacen_pricipal['nombre_marca'];
    $tipo_fuente = $almacen_pricipal['nombre_tipo'];
    $voltaje_salida = $almacen_pricipal['nombre_voltaje'];
    $modelo_fuente = $almacen_pricipal['nombre_modelo'];
    $posicion = $almacen_pricipal['nombre_posicion'];
    $observacion = $almacen_pricipal['observacion'];
    $existencia = $almacen_pricipal['cantidad_plena'];
    $fecha_ingreso = $almacen_pricipal['CREATED_AT'];

}

