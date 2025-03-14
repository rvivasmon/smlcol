<?php

$id_control = $_GET['id'];

$query = $pdo->prepare('SELECT 
                                    ap.*,
                                    cc.marca_control as nombre_marca,
                                    cc1.funcion_control as nombre_funcion,
                                    rfc.referencia as nombre_referencia,
                                    da.posiciones as nombre_posicion
                                FROM
                                    alma_techled AS ap
                                INNER JOIN 
                                    referencias_control AS rfc ON ap.producto = rfc.id_referencia
                                LEFT JOIN
                                    caracteristicas_control AS cc ON rfc.marca = cc.id_car_ctrl
                                LEFT JOIN
                                    caracteristicas_control AS cc1 ON rfc.funcion = cc1.id_car_ctrl
                                LEFT JOIN
                                    distribucion_almacen AS da ON ap.posicion = da.id
                                WHERE
                                    ap.id_techled = :id_control
                                ');

$query->execute(['id_control' => $id_control]);
$almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($almacenes_pricipales as $almacen_pricipal){
    $id = $almacen_pricipal['id_techled'];
    $marca = $almacen_pricipal['nombre_marca'];
    $funcion = $almacen_pricipal['nombre_funcion'];
    $referencia = $almacen_pricipal['nombre_referencia'];
    $posicion = $almacen_pricipal['nombre_posicion'];
    $existencia = $almacen_pricipal['cantidad_plena'];
    $observacion1 = $almacen_pricipal['observacion'];
    $fecha_ingreso = $almacen_pricipal['CREATED_AT'];

}

