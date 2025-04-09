<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto = $_POST['producto'];
    $modelo = $_POST['modelo'];
    $serial = $_POST['serial'];
    $cantidad = $_POST['cantidad']; 
    $valor = $_POST['valor']; 
    $descripcion = $_POST['descripcion'];
    $archivo_nombre = '';

    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        // Obtener extensión del archivo
        $ext = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
        
        // Generar nombre único para el archivo
        $archivo_nombre = 'file_' . time() . '_' . uniqid() . '.' . $ext;

        // Ruta de destino para el archivo
        $ruta_archivo = '../../img_uploads/img_techled/' . $archivo_nombre;

        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo)) {
            die('Error al subir el archivo.');
        }
    }

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO techled (producto, modelo, serial, cantidad, descripcion, valor, archivo) 
            VALUES (:producto, :modelo, :serial, :cantidad, :descripcion, :valor, :archivo)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':producto', $producto);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':serial', $serial);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':archivo', $archivo_nombre);  // Guardar solo un archivo

    if ($stmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        print_r($stmt->errorInfo());
        die('Error al guardar el producto.');
    }
}
?>
