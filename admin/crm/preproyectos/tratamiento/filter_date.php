<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

// Comprobar qué parámetro está presente y realizar la consulta correspondiente
if (isset($_GET['categoria']) && !isset($_GET['uso']) && !isset($_GET['tipo_modulo'])) {
    // Verificar si el parámetro está pidiendo tipos de productos o usos
    if ($_GET['tipo'] === 'producto') {
        // Función para obtener los tipos de productos
        $categoria = $_GET['categoria'];
        $query = $pdo->prepare("SELECT * FROM t_tipo_producto WHERE id_producto = :categoria AND tipo_producto21 IS NOT NULL AND tipo_producto21 != '' ORDER BY tipo_producto21 ASC");
        $query->execute(['categoria' => $categoria]);
        $tipos = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($tipos);
    } elseif ($_GET['tipo'] === 'uso') {
        // Función para obtener los usos de productos, asegurando que no muestre nulos ni vacíos
        $categoria = $_GET['categoria'];
        $query = $pdo->prepare("SELECT * FROM t_uso_productos WHERE categoria_productos = :categoria AND producto_uso IS NOT NULL AND producto_uso != '' ORDER BY producto_uso ASC");
        $query->execute(['categoria' => $categoria]);
        $usos = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($usos);
    }
} elseif (isset($_GET['uso']) && !isset($_GET['tipo_modulo'])) {
    // Función para obtener los tipos de módulo
    $uso = $_GET['uso'];
    $query = $pdo->prepare("SELECT * FROM t_tipo_producto WHERE uso_modelo = :uso AND modelo_modulo IS NOT NULL AND modelo_modulo != '' ORDER BY modelo_modulo ASC");
    $query->execute(['uso' => $uso]);
    $modelos = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($modelos);

} elseif (isset($_GET['tipo_modulo'])) {
    // Función para obtener los pitches
    $tipo_modulo = $_GET['tipo_modulo'];
    $query = $pdo->prepare("SELECT * FROM caracteristicas_modulos WHERE modelo_modulo = :tipo_modulo AND pitch IS NOT NULL AND pitch != '' ORDER BY pitch ASC");
    $query->execute(['tipo_modulo' => $tipo_modulo]);
    $pitches = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($pitches);

} else {
    // Manejo de caso cuando no se recibe ningún parámetro válido
    echo json_encode(['error' => 'Parámetro no válido o faltante']);
}
?>
