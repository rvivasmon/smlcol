<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

if (isset($_POST['id']) || isset($_GET['id_item'])) {

        // Iniciar la transacción
        $pdo->beginTransaction();

    // Eliminar ítem específico
    if (isset($_GET['id_item'])) {
        $id_item = $_GET['id_item'];
        $id_oc = $_GET['id'];

        // Eliminar el ítem
        $query_delete_item = $pdo->prepare("DELETE FROM items_oc WHERE id_item = :id_item");
        $query_delete_item->bindParam(':id_item', $id_item, PDO::PARAM_INT);
        $query_delete_item->execute();

        // Obtener el número actualizado de ítems para esa OC
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

// Actualizar el campo 'contador' para todos los ítems de esta OC
$query_get_items = $pdo->prepare('
SELECT id_item 
FROM items_oc 
WHERE id_oc = :id_oc
ORDER BY id_item ASC
');
$query_get_items->execute([':id_oc' => $id_oc]);
$items = $query_get_items->fetchAll(PDO::FETCH_ASSOC);
$query_get_items->closeCursor();

$contador = 1;
foreach ($items as $item) {
$query_update_contador = $pdo->prepare('
    UPDATE items_oc 
    SET contador = :contador 
    WHERE id_item = :id_item
');
$query_update_contador->execute([
    ':contador' => $contador,
    ':id_item' => $item['id_item']
]);
$contador++;
}

// Confirmar la transacción
$pdo->commit();
header("Location: edit.php?id=$id_oc");
exit();
    }
}