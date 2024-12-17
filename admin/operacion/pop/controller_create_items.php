<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$id_oc = $_POST['id_oc'];  // ID del OC al que se va a asociar el ítem
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];
$instalacion = $_POST['instalacion'];

// Preparar la consulta de inserción
$query_insert_item = $pdo->prepare("INSERT INTO items_oc (id_oc, descripcion, cantidad, instalacion) VALUES (:id_oc, :descripcion, :cantidad, :instalacion)");

// Vincular los parámetros
$query_insert_item->bindParam(':id_oc', $id_oc, PDO::PARAM_INT);
$query_insert_item->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
$query_insert_item->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
$query_insert_item->bindParam(':instalacion', $instalacion, PDO::PARAM_STR);

// Ejecutar la inserción y comprobar si fue exitosa
if ($query_insert_item->execute()) {
    // Obtener el número actual de ítems asociados a esta OC
    $query_get_num_items = $pdo->prepare('
        SELECT COUNT(*) as num_items 
        FROM items_oc 
        WHERE id_oc = :id_oc
    ');
    $query_get_num_items->execute([':id_oc' => $id_oc]);
    $result = $query_get_num_items->fetch(PDO::FETCH_ASSOC);
    $num_items = $result['num_items'];
    $query_get_num_items->closeCursor(); // Liberar el objeto PDOStatement

    // Actualizar el campo 'num_items' en la tabla 'oc'
    $query_update_oc = $pdo->prepare('
        UPDATE oc 
        SET num_items = :num_items 
        WHERE id = :id_oc
    ');
    $query_update_oc->execute([
        ':num_items' => $num_items, 
        ':id_oc' => $id_oc
    ]);

    // Obtener los ítems actuales para esta OC ordenados por ID
    $query_get_items = $pdo->prepare('
        SELECT id_item 
        FROM items_oc 
        WHERE id_oc = :id_oc
        ORDER BY id_item ASC
    ');
    $query_get_items->execute([':id_oc' => $id_oc]);
    $items = $query_get_items->fetchAll(PDO::FETCH_ASSOC);
    $query_get_items->closeCursor();

    // Actualizar el campo 'contador' para todos los ítems de esta OC
    $contador = 1; // Inicia el contador desde 1
    foreach ($items as $item) {
        $query_update_contador = $pdo->prepare('
            UPDATE items_oc 
            SET contador = :contador 
            WHERE id_item = :id_item
        ');
        $query_update_contador->execute([
            ':contador' => $contador, // Asigna el valor actual del contador
            ':id_item' => $item['id_item']
        ]);
        $contador++; // Incrementa el contador para el siguiente registro
    }

    // Redirigir a la página con el ID
    header("Location: " . $URL . "admin/administracion/oc/edit.php?id=" . $id_oc);
    exit(); // Asegura que el script se detiene después de la redirección
} else {
    echo "Error al insertar el ítem.";
}
