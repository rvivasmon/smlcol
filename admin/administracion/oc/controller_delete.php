<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

if (isset($_POST['id']) || isset($_GET['id_item'])) {
    try {
        // Iniciar la transacción
        $pdo->beginTransaction();
        
        // Eliminar el OC completo con sus ítems asociados
        if (isset($_POST['id'])) {
            $id_oc = $_POST['id'];

            // Eliminar los ítems asociados
            $query_delete_items = $pdo->prepare("DELETE FROM items_oc WHERE id_oc = :id_oc");
            $query_delete_items->bindParam(':id_oc', $id_oc, PDO::PARAM_INT);
            $query_delete_items->execute();

            // Eliminar el OC
            $query_delete_oc = $pdo->prepare("DELETE FROM oc WHERE id = :id_oc");
            $query_delete_oc->bindParam(':id_oc', $id_oc, PDO::PARAM_INT);
            $query_delete_oc->execute();

            // Confirmar la transacción
            $pdo->commit();
            header("Location: index_oc.php");
            exit();
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: index_oc.php");
    exit();
}