<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

$fcreacion = $_POST['fecha'];
$tipo_proyecto = $_POST['tipo_proyecto'];
$idproy = $_POST['id_proyecto'];
$nombre_proyecto = $_POST['nombre_proyecto'];
$cliente = $_POST['cliente'];
$contacto = $_POST['contacto_cliente'];
$telefono = $_POST['telefono_contacto'];
$asesor = $_POST['idusuario2'];
$anio_mes1 = $_POST['anio_mes'];
$contador1 = $_POST['contador'];
$ciudad = $_POST['ciudad'];

// Insertar datos principales en la tabla pre_proyecto
$sql = "INSERT INTO pre_proyecto (fecha, tipo_proyecto, idprepro, nombre_preproyecto, cliente, contacto, telefono, asesor, anio_mes, contador, ciudad) VALUES (:fcreacion, :tipo_proyecto, :idproy, :nombre_proyecto, :cliente, :contacto, :telefono, :asesor, :anio_mes1, :contador1, :ciudad)";
$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':fcreacion', $fcreacion);
$sentencia->bindParam(':tipo_proyecto', $tipo_proyecto);
$sentencia->bindParam(':idproy', $idproy);
$sentencia->bindParam(':nombre_proyecto', $nombre_proyecto);
$sentencia->bindParam(':cliente', $cliente);
$sentencia->bindParam(':contacto', $contacto);
$sentencia->bindParam(':telefono', $telefono);
$sentencia->bindParam(':asesor', $asesor);
$sentencia->bindParam(':anio_mes1', $anio_mes1);
$sentencia->bindParam(':contador1', $contador1);
$sentencia->bindParam(':ciudad', $ciudad);

if ($sentencia->execute()) {
    // Obtener el ID generado automáticamente para pre_proyecto
    $id_preproyec = $pdo->lastInsertId();

    $items = $_POST['items'];
    $pantallas = $_POST['pantallas'];
    $estado = $_POST['estado'];
    $categoria_producto = $_POST['categoria_producto'];
    $uso = $_POST['uso'];
    $tipo_producto = $_POST['tipo_producto'];
    $pitch = $_POST['pitch'];
    $x_disponible = $_POST['x_disponible'];
    $y_disponible = $_POST['y_disponible'];
    $justificacion = $_POST['justificacion'];
    $contador = $_POST['contador'];

    for ($i = 0; $i < count($items); $i++) {
        $items1 = $items[$i];
        $pantallas1 = $pantallas[$i];
        $estado1 = $estado[$i];
        $categoria_producto1 = $categoria_producto[$i];
        $uso1 = $uso[$i];
        $tipo_producto1 = $tipo_producto[$i];
        $pitch1 = $pitch[$i];
        $x_disponible1 = $x_disponible[$i];
        $y_disponible1 = $y_disponible[$i];
        $justificacion1 = $justificacion[$i];
        $contador1 = $contador;

        // Insertar datos en la tabla item_preproyecto
        $sql1 = "INSERT INTO item_preproyecto (id_preproyec, items, cantidad_pantallas, estado, categoria, uso, tipo_producto, pitch, x_disponible, y_disponible, justificacion, contador) VALUES (:id_preproyec, :items1, :pantallas1, :estado1, :categoria_producto1, :uso1, :tipo_producto1, :pitch1, :x_disponible1, :y_disponible1, :justificacion1, :contador1)";
        $sentencia1 = $pdo->prepare($sql1);

        $sentencia1->bindParam(':id_preproyec', $id_preproyec);
        $sentencia1->bindParam(':items1', $items1);
        $sentencia1->bindParam(':pantallas1', $pantallas1);
        $sentencia1->bindParam(':estado1', $estado1);
        $sentencia1->bindParam(':categoria_producto1', $categoria_producto1);
        $sentencia1->bindParam(':uso1', $uso1);
        $sentencia1->bindParam(':tipo_producto1', $tipo_producto1);
        $sentencia1->bindParam(':pitch1', $pitch1);
        $sentencia1->bindParam(':x_disponible1', $x_disponible1);
        $sentencia1->bindParam(':y_disponible1', $y_disponible1);
        $sentencia1->bindParam(':justificacion1', $justificacion1);
        $sentencia1->bindParam(':contador1', $contador1);

        if (!$sentencia1->execute()) {
            session_start();
            $_SESSION['Mensajes'] = array(
                'title' => 'Error',
                'text' => 'Error al introducir la información',
                'icon' => 'error'
            );
            header('Location: ' . $URL . 'admin/Administracion/tecnicos/create_tecnicos.php');
            exit;
        }
    }

    session_start();
    $_SESSION['Mensajes'] = array(
        'title' => 'Good job!',
        'text' => '¡Usuario creado exitosamente!',
        'icon' => 'success'
    );
    header('Location: ' . $URL . 'admin/crm/preproyectos');
    exit;
} else {
    session_start();
    $_SESSION['Mensajes'] = array(
        'title' => 'Error',
        'text' => 'Error al introducir la información',
        'icon' => 'error'
    );
    header('Location: ' . $URL . 'admin/Administracion/tecnicos/create_tecnicos.php');
    exit;
}
?>
