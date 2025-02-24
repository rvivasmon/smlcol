<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $procesar = $_POST['procesar'];

    $query = $pdo->prepare("UPDATE items_op SET procesar = :procesar WHERE id = :id");
    $query->bindParam(':procesar', $procesar, PDO::PARAM_INT);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($query->execute()) {
        echo "Registro actualizado correctamente.";
    } else {
        echo "Error al actualizar el registro.";
    }
}
?>
