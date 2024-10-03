<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

// Verificar si el parámetro 'id_tipoproducto' está presente
if (isset($_GET['id_tipoproducto'])) {
    $idTipoproducto = intval($_GET['id_tipoproducto']);  // Convertir a entero para seguridad
    
    // Preparar la consulta
    $stmt = $pdo->prepare("SELECT id, peso_producto21 FROM t_tipo_producto WHERE id = :idTipoproducto");
    
    // Ejecutar la consulta con el parámetro
    $stmt->execute(['idTipoproducto' => $idTipoproducto]);
    
    // Obtener el resultado
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar si se obtuvo un resultado
    if ($result) {
        // Devolver el resultado en formato JSON
        echo json_encode($result);
    } else {
        // En caso de que no se encuentre el producto, devolver un mensaje de error
        echo json_encode(['error' => 'Producto no encontrado']);
    }
}
?>

