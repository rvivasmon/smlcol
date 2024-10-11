<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $celular = $_POST['celular'];
    $telefono = $_POST['telefono'];

    // Insertar el contacto en la base de datos
    $query = $pdo->prepare("INSERT INTO contactos (nombre, celular, telefono) VALUES (?, ?, ?)");
    if ($query->execute([$nombre, $celular, $telefono])) {
        // Obtener el ID del nuevo contacto
        $id_contacto = $pdo->lastInsertId();

        // Devolver el éxito y el ID del contacto
        echo json_encode(['success' => true, 'id_contacto' => $id_contacto]);
    } else {
        // Error al guardar el contacto
        echo json_encode(['success' => false]);
    }
}
?>
