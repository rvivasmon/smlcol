<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $referencia = $_POST['referencia'];
    $moduloId = $_POST['id'];

    // Verificar si se subió una imagen
    if (isset($_FILES['archivo_adjunto']) && $_FILES['archivo_adjunto']['error'] === UPLOAD_ERR_OK) {
        $nombreDelArchivo = date("Y-m-d-H-i-s") . "__" . basename($_FILES['archivo_adjunto']['name']);
        $rutaImagen = "../../../../img_uploads/" . $nombreDelArchivo;

        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($_FILES['archivo_adjunto']['tmp_name'], $rutaImagen)) {
            // Actualizar la base de datos con referencia y nombre de archivo
            $query = $pdo->prepare("UPDATE producto_modulo_creado SET referencia = :referencia, ruta = :rutaImagen WHERE id = :moduloId");
            $query->bindParam(':referencia', $referencia);
            $query->bindParam(':rutaImagen', $nombreDelArchivo);  // Guardamos solo el nombre del archivo
            $query->bindParam(':moduloId', $moduloId);
            $query->execute();

            // Redirigir al formulario después de guardar los datos
            header("Location: create_movimiento_entrada_final.php");
            exit(); // Termina el script después de la redirección
        } else {
            echo "<script>alert('Error al cargar la imagen.');</script>";
        }
    } else {
        echo "<script>alert('Por favor, seleccione una imagen válida.');</script>";
    }
}
?>