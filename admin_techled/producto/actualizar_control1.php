<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

if (isset($_POST['id']) && isset($_POST['habilitar'])) {
    $id = $_POST['id'];
    $habilitar = $_POST['habilitar'];

    $query = $pdo->prepare('UPDATE referencias_control SET habilitar = :habilitar WHERE id_referencia = :id');
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
