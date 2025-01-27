<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');
include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

// Valores para actualizar, sanitizando la entrada
$tipo_producto = htmlspecialchars($_POST['tipo_producto'], ENT_QUOTES, 'UTF-8');
$producto = htmlspecialchars($_POST['producto'], ENT_QUOTES, 'UTF-8');

try {
    // Paso 1: Verificar si hay una fila vacía en "tipo_prod_mmp"
    $sqlCheck = "SELECT id_producto FROM t_productos WHERE tipo_prod_mmp IS NULL OR tipo_prod_mmp = '' LIMIT 1";
    $stmtCheck = $pdo->query($sqlCheck);
    $row = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Paso 2: Actualizar la fila existente
        $sqlUpdate = "UPDATE t_productos 
                    SET tipo_prod_mmp = :tipo_producto, producto = :producto, habilitar_mmp = 1 
                    WHERE id_producto = :id_producto";
        $stmtUpdate = $pdo->prepare($sqlUpdate);

        $stmtUpdate->bindParam(':tipo_producto', $tipo_producto);
        $stmtUpdate->bindParam(':producto', $producto);
        $stmtUpdate->bindParam(':id_producto', $row['id_producto']); // Aquí se corrige el nombre del parámetro

        if ($stmtUpdate->execute()) {
            // Mensaje de éxito en el log o similar
        } else {
            // Manejo de error en actualización
            throw new Exception("Error al actualizar el registro.");
        }
    } else {
        // Paso 3: Insertar un nuevo registro si no hay líneas vacías
        $sqlInsert = "INSERT INTO t_tipo_producto (tipo_prod_mmp, producto, habilitar_mmp) 
                    VALUES (:tipo_producto, :producto, 1)";
        $stmtInsert = $pdo->prepare($sqlInsert);

        $stmtInsert->bindParam(':tipo_producto', $tipo_producto);
        $stmtInsert->bindParam(':producto', $producto);

        if ($stmtInsert->execute()) {
            // Mensaje de éxito en el log o similar
        } else {
            // Manejo de error en inserción
            throw new Exception("Error al insertar el registro.");
        }
    }

    // Redirección tras éxito
    header('Location: ' . $URL . 'admin/almacen/mv_diario/mmp/producto');
    exit;

} catch (Exception $e) {
    // Manejo de errores
    echo "Ha ocurrido un error: " . $e->getMessage();
    exit;
}

?>
