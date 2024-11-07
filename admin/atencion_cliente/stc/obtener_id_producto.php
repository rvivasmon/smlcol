<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

header('Content-Type: application/json');

if (isset($_GET['proyecto_id'])) {
    $proyecto_id = $_GET['proyecto_id'];

    $query = $pdo->prepare('SELECT 
                                        ip.id_producto
                                    FROM
                                        id_producto AS ip
                                    JOIN
                                        op ON ip.op = op.id
                                    JOIN
                                        pop_admin AS pop ON op.pop = pop.id
                                    JOIN
                                        oc_admin AS oc ON pop.oc = oc.id
                                    WHERE
                                        oc.id = :proyecto_id
                                    LIMIT 1
                            ');
    
    $query->bindParam(':proyecto_id', $proyecto_id, PDO::PARAM_INT);
    $query->execute();
    
    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        echo json_encode(['id_producto' => $result['id_producto']]);
    } else {
        echo json_encode(['id_producto' => null]);
    }
}
?>
