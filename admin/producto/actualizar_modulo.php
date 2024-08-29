<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

if (isset($_POST['id']) && isset($_POST['habilitar'])) {
    $id = $_POST['id'];
    $habilitar = $_POST['habilitar'];

    $query = $pdo->prepare('UPDATE caracteristicas_modulos SET habilitar = :habilitar WHERE id_car_mod = :id');
    $query->bindParam(':habilitar', $habilitar, PDO::PARAM_INT);
    $query->bindParam(':id', $id, PDO::PARAM_INT);

    if ($query->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'invalid';
}
?>
