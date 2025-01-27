<?php
include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

if (isset($_POST['categoria_id'])) {
    $categoria_id = $_POST['categoria_id'];

    // Obtener los productos filtrados
    $query_productos = $pdo->prepare('
        SELECT id_producto, producto 
        FROM t_productos 
        WHERE tipo_prod_mmp = :categoria_id 
          AND producto IS NOT NULL 
          AND producto <> "" 
          AND habilitar_mmp = 1
        ORDER BY producto ASC
    ');
    $query_productos->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
    $query_productos->execute();
    $productos = $query_productos->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los datos como JSON
    echo json_encode($productos);
}
?>
