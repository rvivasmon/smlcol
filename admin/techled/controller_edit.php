<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

// Verificar que el id y los datos del formulario están presentes
if (isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['producto']) && isset($_POST['modelo']) && isset($_POST['serial']) && isset($_POST['cantidad']) && isset($_POST['valor']) && isset($_POST['descripcion'])) {
    
    $id = $_POST['id'];
    $producto = $_POST['producto'];
    $modelo = $_POST['modelo'];
    $serial = $_POST['serial'];
    $cantidad = $_POST['cantidad'];
    $valor = $_POST['valor'];
    $descripcion = $_POST['descripcion'];
    $archivo_nombre = '';
    // Variable para los archivos guardados
    $mas_archivos = '';

    // Verificar si hay archivos cargados
    if (isset($_FILES['archivos']) && !empty($_FILES['archivos']['name'][0])) {
        $archivos = $_FILES['archivos'];
        $archivos_guardados = [];

        // Directorio donde se guardarán los archivos
        $directorio_subida = '../../img_uploads/img_techled/';

        // Procesar cada archivo
        foreach ($archivos['name'] as $index => $nombre_archivo) {
            // Establecer el nombre de archivo único para evitar conflictos
            $ext = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
            $nombre_archivo_unico = 'file_' . time() . '_' . uniqid() . '.' . $ext; // Usamos uniqid para mayor unicidad
            $ruta_archivo = $directorio_subida . $nombre_archivo_unico;

            // Mover el archivo a la carpeta de destino
            if (move_uploaded_file($archivos['tmp_name'][$index], $ruta_archivo)) {
                // Guardar la ruta entre corchetes
                $archivos_guardados[] = $nombre_archivo_unico;
            }
        }

        // Si ya existen archivos previos en la base de datos, los obtenemos
        $query_select = $pdo->prepare("SELECT archivo FROM techled WHERE id = :id");
        $query_select->bindParam(':id', $id);
        $query_select->execute();
        $row = $query_select->fetch(PDO::FETCH_ASSOC);
        $archivos_existentes = !empty($row['archivo']) ? explode(',', $row['archivo']) : [];

        // Concatenar los archivos existentes con los nuevos
        $archivos_totales = array_merge($archivos_existentes, $archivos_guardados);

        // Convertir la lista de archivos a una cadena separada por comas
        $mas_archivos = implode(',', $archivos_totales);
    }

    // Actualizar los datos en la base de datos
    $query_update = $pdo->prepare("UPDATE techled SET producto = :producto, modelo = :modelo, serial = :serial, cantidad = :cantidad, descripcion = :descripcion, valor = :valor, archivo = :archivo WHERE id = :id");
    $query_update->bindParam(':producto', $producto);
    $query_update->bindParam(':modelo', $modelo);
    $query_update->bindParam(':serial', $serial);
    $query_update->bindParam(':cantidad', $cantidad);
    $query_update->bindParam(':descripcion', $descripcion);
    $query_update->bindParam(':valor', $valor);
    $query_update->bindParam(':archivo', $mas_archivos);  // Almacenar todos los archivos como una lista separada por comas
    $query_update->bindParam(':id', $id);

    if ($query_update->execute()) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error al actualizar.";
    }
}
?>
