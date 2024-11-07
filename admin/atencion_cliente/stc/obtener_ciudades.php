<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

header('Content-Type: application/json');

if (isset($_GET['cliente_id'])) {
    $cliente_id = $_GET['cliente_id'];

    // Consulta para obtener el id y el nombre de la ciudad asociada al cliente seleccionado
    $query = $pdo->prepare('SELECT DISTINCT
                                tc.id AS ciudad_id,
                                tc.ciudad AS nombre_ciudad
                            FROM
                                oc_admin AS oca
                            JOIN
                                t_ciudad AS tc ON oca.ciudad = tc.id
                            WHERE
                                oca.cliente = :cliente_id');
    $query->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $query->execute();

    // Obtiene el resultado de la consulta como un array asociativo
    $ciudades = $query->fetchAll(PDO::FETCH_ASSOC);

    // Devolver el array de ciudades en formato JSON
    echo json_encode($ciudades);
}
?>
