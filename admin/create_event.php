<?php
include('../app/config/config.php');
include('../app/config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $start = $_POST['start'];
    $color = $_POST['color'];
    $usuario = $_POST['usuario'];
    $recordatorio = $_POST['recordatorio'];

    // Insertar evento en la base de datos
    $sql = "INSERT INTO eventos (title, start_date, color, usuario, recordatorio) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $start, $color, $usuario, $recordatorio]);

    // Redireccionar de vuelta al calendario
    header('Location: index.php');
}
?>