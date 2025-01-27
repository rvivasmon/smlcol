<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');
include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

// Capturar datos del formulario
$movimiento = $_POST['movimiento']; // 'entrada' o 'salida'
$fecha = $_POST['fecha'];
$categoria = $_POST['categoria'];
$producto = $_POST['producto'];
$cantidad_e_s = intval($_POST['cantidad']); // Asegurarse de que sea numérico
$usuario = $_POST['idusuario'];
$observacion = $_POST['observacion'];
$tamano_modulo = $_POST['tamano_modulo'];
$ubicacion = $_POST['ubicacion'];

try {
    $pdo->beginTransaction(); // Iniciar una transacción

    // *** Tabla alma_mmp ***
    // Verificar si la categoría ya existe en la tabla alma_mmp
    $queryCategoria = $pdo->prepare("SELECT id_prod_term FROM alma_mmp WHERE tipo = :tipo");
    $queryCategoria->execute([':tipo' => $categoria]);
    $categoriaExistente = $queryCategoria->fetch(PDO::FETCH_ASSOC);

    if (!$categoriaExistente) {
        // Si la categoría no existe, insertarla junto con el producto y la cantidad
        $insertCategoria = $pdo->prepare("
            INSERT INTO alma_mmp (tipo, producto, cantidad, tamano_modulo, ubicacion)
            VALUES (:tipo, :producto, :cantidad, :tamano_modulo, :ubicacion)
        ");
        $insertCategoria->execute([
            ':tipo' => $categoria,
            ':producto' => $producto,
            ':cantidad' => $cantidad_e_s,
            ':tamano_modulo' => $tamano_modulo,
            ':ubicacion' => $ubicacion,
        ]);
    } else {
        // Si la categoría existe, verificar si el producto ya está en la tabla
        $queryProducto = $pdo->prepare("
            SELECT id_prod_term, cantidad FROM alma_mmp WHERE tipo = :tipo AND producto = :producto
        ");
        $queryProducto->execute([':tipo' => $categoria, ':producto' => $producto]);
        $productoExistente = $queryProducto->fetch(PDO::FETCH_ASSOC);

        if (!$productoExistente) {
            // Si el producto no existe en la categoría, insertarlo con la cantidad
            $insertProducto = $pdo->prepare("
                INSERT INTO alma_mmp (tipo, producto, cantidad, tamano_modulo, ubicacion)
                VALUES (:tipo, :producto, :cantidad, :tamano_modulo, :ubicacion)
            ");
            $insertProducto->execute([
                ':tipo' => $categoria,
                ':producto' => $producto,
                ':cantidad' => $cantidad_e_s,
                ':tamano_modulo' => $tamano_modulo,
                ':ubicacion' => $ubicacion,
            ]);
        } else {
            // Si el producto existe, actualizar la cantidad según el movimiento
            $cantidadActual = $productoExistente['cantidad'];
            $nuevaCantidad = ($movimiento === 'entrada') 
                ? $cantidadActual + $cantidad_e_s 
                : $cantidadActual - $cantidad_e_s;

            $updateCantidad = $pdo->prepare("
                UPDATE alma_mmp 
                SET cantidad = :cantidad 
                WHERE id_prod_term = :id
            ");
            $updateCantidad->execute([
                ':cantidad' => $nuevaCantidad,
                ':id' => $productoExistente['id_prod_term']
            ]);
        }
    }

    // *** Tabla movimiento_mmp ***
    // Registrar el movimiento en la tabla movimiento_mmp
    $campoCantidad = ($movimiento === 'entrada') ? 'cantidad_entrada' : 'cantidad_salida';
    $insertMovimiento = $pdo->prepare("
        INSERT INTO movimiento_mmp (fecha, tipo_producto, producto_mmp, $campoCantidad, observaciones, id_usuario)
        VALUES (:fecha, :tipo_producto, :producto_mmp, :cantidad, :observaciones, :usuario)
    ");
    $insertMovimiento->execute([
        ':fecha' => $fecha,
        ':tipo_producto' => $categoria,
        ':producto_mmp' => $producto,
        ':cantidad' => $cantidad_e_s,
        ':observaciones' => $observacion,
        ':usuario' => $usuario
    ]);

    $pdo->commit(); // Confirmar la transacción
    session_start();
    $_SESSION['msj'] = "Se ha registrado la información correctamente";
    header('Location:' . $URL . 'admin/almacen/mv_diario/mmp');

} catch (Exception $e) {
    $pdo->rollBack(); // Revertir la transacción en caso de error
    echo "Error: " . $e->getMessage();
    exit;
}

?>
