<?php
include "../../app/config/conexion.php"; // Ajusta la ruta según tu estructura

// Incluir el archivo backend.php que maneja la lógica de consultas
include "./chat/get_notifications.php";


// Consulta para contar los mensajes no leídos
$query = "SELECT COUNT(*) AS nuevos_mensajes FROM mensajes WHERE visto = 0";
$result = $conexion->query($query);
$row = $result->fetch_assoc();

// Devuelve la cantidad de mensajes en formato JSON
echo json_encode(["nuevos_mensajes" => $row['nuevos_mensajes']]);
?>
