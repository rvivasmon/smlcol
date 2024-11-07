<?php

// Conexión a la base de datos
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if (isset($_POST['id_uso'])) {
    $id_uso = $_POST['id_uso'];

    // Preparar la consulta para obtener los modelos según el uso
    $query = $pdo->prepare("SELECT * FROM t_tipo_producto WHERE uso_modelo = :id_uso ORDER BY modelo_modulo ASC");
    $query->bindParam(':id_uso', $id_uso, PDO::PARAM_INT);
    $query->execute();
    $modelos = $query->fetchAll(PDO::FETCH_ASSOC);

    // Generar las opciones para el select 'modelo_modulo1'
    if (!empty($modelos)) {
        echo '<option value="">Seleccione un Modelo</option>';
        foreach ($modelos as $modelo) {
            echo '<option value="'.$modelo['id'].'">'.$modelo['modelo_modulo'].'</option>';
        }
    } else {
        echo '<option value="">No hay modelos disponibles</option>';
    }
}
?>
