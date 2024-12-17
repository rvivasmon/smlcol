<?php

$id_modulo = $_GET['id'];

$query = $pdo->prepare("SELECT 
                                ap.*,
                                tup.producto_uso as nombre_uso,
                                tp.pitch as nombre_pitch,
                                ttp.modelo_modulo as nombre_modelo,
                                pmc.serie as nombre_serie,
                                ttm.tamanos_modulos as nombre_tamano,
                                ap.CREATED_AT as nombre_fecha,
                                da.posiciones as nombre_posicion
                            FROM
                                alma_principal AS ap
                            INNER JOIN 
                                producto_modulo_creado AS pmc ON ap.producto = pmc.id
                            LEFT JOIN
                                tabla_pitch AS tp ON pmc.pitch = tp.id
                            LEFT JOIN
                                t_tipo_producto AS ttp ON pmc.modelo = ttp.id
                            LEFT JOIN
                                tabla_tamanos_modulos AS ttm ON pmc.tamano = ttm.id
                            LEFT JOIN
                                t_uso_productos AS tup ON pmc.uso = tup.id_uso
                            LEFT JOIN
                                distribucion_almacen AS da ON ap.posicion = da.id
                            WHERE
                                ap.id_almacen_principal = :id_modulo
                            ");

$query->execute(['id_modulo' => $id_modulo]);
$almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($almacenes_pricipales as $almacen_pricipal){
    $id = $almacen_pricipal['id_almacen_principal'];
    $fecha_ingreso = $almacen_pricipal['nombre_fecha'];
    $uso = $almacen_pricipal['nombre_uso'];
    $pitch = $almacen_pricipal['nombre_pitch'];
    $modelo_modulo = $almacen_pricipal['nombre_modelo'];
    $serie_modulo = $almacen_pricipal['nombre_serie'];
    $tamano = $almacen_pricipal['nombre_tamano'];
    $existencia = $almacen_pricipal['cantidad_plena'];
    $observacion = $almacen_pricipal['observacion'];
    $posicion = $almacen_pricipal['nombre_posicion'];
}

