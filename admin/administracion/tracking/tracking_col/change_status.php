<?php
session_start();
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

// Asegúrate de que el usuario esté autenticado
if (!isset($_SESSION['sesion_cargo']) || $_SESSION['sesion_cargo'] != 'Administrador') {
    echo 'NO AUTORIZADO';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $date_status = ($status == 2) ? date('Y-m-d H:i:s') : null;

    $query = $pdo->prepare('UPDATE tracking SET status = :status, date_status = :date_status WHERE id = :id');
    $query->bindParam(':status', $status);
    $query->bindParam(':date_status', $date_status);
    $query->bindParam(':id', $id);

    if ($query->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>