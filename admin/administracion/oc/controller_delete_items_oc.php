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
            $query_delete_item = $pdo->prepare("DELETE FROM tabla_items_oc WHERE id_item = :id_item");
            $query_delete_item->bindParam(':id_item', $id_item, PDO::PARAM_INT);
            $query_delete_item->execute();

            // Confirmar la transacción
            $pdo->commit();
            header("Location: index_oc.php?id=$id_oc");
            exit();
        }
    }