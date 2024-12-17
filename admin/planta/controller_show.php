<?php

$id_pantallas = $_GET['id'];

$query_pantallas = $pdo->prepare("SELECT idp.*,
                                            idp.id_producto AS id_producto,
                                            op.op AS nombre_op,
                                            pop_admin.pop AS pop,
                                            clientes.nombre_comercial AS cliente,
                                            t_ciudad.ciudad AS ciudad,
                                            oc_admin.nombre_proyecto AS proyecto,
                                            oc_admin.lugar_instalacion AS lugar
                                        FROM
                                            id_producto as idp
                                        LEFT JOIN
                                            op ON idp.op = op.id
                                        LEFT JOIN
                                            pop_admin ON op.pop = pop_admin.id
                                        LEFT JOIN
                                            oc_admin ON pop_admin.oc = oc_admin.id
                                        LEFT JOIN
                                            clientes ON oc_admin.cliente = clientes.id
                                        LEFT JOIN
                                            t_ciudad ON oc_admin.ciudad = t_ciudad.id
                                        WHERE
                                            idp.id = $id_pantallas
                                        ");

$query_pantallas->execute();
$pantallas_id = $query_pantallas->fetchAll(PDO::FETCH_ASSOC);

foreach($pantallas_id as $pantalla_id){
    $id = $pantalla_id['id'];
    $fecha = $pantalla_id['fecha'];
    $op = $pantalla_id['nombre_op'];
    $id_producto = $pantalla_id['id_producto'];
    $imagen_qr = $pantalla_id['qr_image_path'];
    $url = $pantalla_id['url'];
    $pop = $pantalla_id['pop'];
    $cliente = $pantalla_id['cliente'];
    $proyecto = $pantalla_id['proyecto'];
    $ciudad = $pantalla_id['ciudad'];
    $lugar_instalacion = $pantalla_id['lugar'];

}

?>