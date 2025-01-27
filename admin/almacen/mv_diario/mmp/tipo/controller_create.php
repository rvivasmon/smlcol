<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');
include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

// Valores para actualizar, sanitizando la entrada
$nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
$nomenclatura = htmlspecialchars($_POST['nomenclatura'], ENT_QUOTES, 'UTF-8');

try {
    // Paso 1: Verificar si hay una fila vacía en "tipo_prod_mmp"
    $sqlCheck = "SELECT id FROM t_tipo_producto WHERE tipo_prod_mmp IS NULL OR tipo_prod_mmp = '' LIMIT 1";
    $stmtCheck = $pdo->query($sqlCheck);
    $row = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Paso 2: Actualizar la fila existente
        $sqlUpdate = "UPDATE t_tipo_producto 
                    SET tipo_prod_mmp = :nombre, nomenclatura = :nomenclatura, habilitar_mmp = 1 
                    WHERE id = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);

        $stmtUpdate->bindParam(':nombre', $nombre);
        $stmtUpdate->bindParam(':nomenclatura', $nomenclatura);
        $stmtUpdate->bindParam(':id', $row['id']); // Aquí se corrige el nombre del parámetro

        if ($stmtUpdate->execute()) {
            // Mensaje de éxito en el log o similar
        } else {
            // Manejo de error en actualización
            throw new Exception("Error al actualizar el registro.");
        }
    } else {
        // Paso 3: Insertar un nuevo registro si no hay líneas vacías
        $sqlInsert = "INSERT INTO t_tipo_producto (tipo_prod_mmp, nomenclatura, habilitar_mmp) 
                    VALUES (:nombre, :nomenclatura, 1)";
        $stmtInsert = $pdo->prepare($sqlInsert);

        $stmtInsert->bindParam(':nombre', $nombre);
        $stmtInsert->bindParam(':nomenclatura', $nomenclatura);

        if ($stmtInsert->execute()) {
            // Mensaje de éxito en el log o similar
        } else {
            // Manejo de error en inserción
            throw new Exception("Error al insertar el registro.");
        }
    }

    // Redirección tras éxito
    header('Location: ' . $URL . 'admin/almacen/mv_diario/mmp/tipo');
    exit;

} catch (Exception $e) {
    // Manejo de errores
    echo "Ha ocurrido un error: " . $e->getMessage();
    exit;
}

?>
