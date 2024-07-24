<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../app/config/config.php');
include('../../app/config/conexion.php');
include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

$fecha = $_POST['fecha'];
$producto = $_POST['producto'];
$pitch = !empty($_POST['pitch']) ? $_POST['pitch'] : NULL;
$modelo_modulo1 = !empty($_POST['modelo_modulo1']) ? $_POST['modelo_modulo1'] : NULL;
$marca_control1 = !empty($_POST['marca_control1']) ? $_POST['marca_control1'] : NULL;
$funcion_control = !empty($_POST['funcion_control']) ? $_POST['funcion_control'] : NULL;
$marca_fuente = !empty($_POST['marca_fuente']) ? $_POST['marca_fuente'] : NULL;
$medida_x = !empty($_POST['medida_x']) ? $_POST['medida_x'] : NULL;
$medida_y = !empty($_POST['medida_y']) ? $_POST['medida_y'] : NULL;
$usuario = $_POST['idusuario'];

echo '<pre>';
print_r($_POST);
echo '</pre>';

// Realizar las divisiones y redondear los resultados a enteros
$pixel_x = !empty($pitch) && !empty($medida_x) ? round($medida_x / $pitch) : NULL;
$pixel_y = !empty($pitch) && !empty($medida_y) ? round($medida_y / $pitch) : NULL;


try{
    if($producto == 1 || $producto == 'módulo'){
        $sql_modulo = "INSERT INTO caracteristicas_modulos (pitch, modelo_modulo, medida_x, medida_y, pixel_x, pixel_y) VALUES (:pitch, :modelo_modulo1, :medida_x, :medida_y, :pixel_x, :pixel_y)";
        $sentencia_modulo = $pdo->prepare($sql_modulo);
        $sentencia_modulo->bindParam(':pitch', $pitch);
        $sentencia_modulo->bindParam(':modelo_modulo1', $modelo_modulo1);
        $sentencia_modulo->bindParam(':medida_x', $medida_x);
        $sentencia_modulo->bindParam(':medida_y', $medida_y);
        $sentencia_modulo->bindParam(':pixel_x', $pixel_x);
        $sentencia_modulo->bindParam(':pixel_y', $pixel_y);
        $sentencia_modulo->execute();
    } elseif($producto == 2 || $producto == 'controladora'){
        $sql_control = "INSERT INTO caracteristicas_control (marca_control, funcion_control) VALUES (:marca_control1, :funcion_control)";
        $sentencia_control = $pdo->prepare($sql_control);
        $sentencia_control->bindParam(':marca_control1', $marca_control1);
        $sentencia_control->bindParam(':funcion_control', $funcion_control);
        $sentencia_control->execute();
    } elseif($producto == 3 || $producto == 'fuente'){
        $sql_fuente = "INSERT INTO caracteristicas_fuentes (marca_fuente) VALUES (:marca_fuente)";
        $sentencia_fuente = $pdo->prepare($sql_fuente);
        $sentencia_fuente->bindParam(':marca_fuente', $marca_fuente);
        $sentencia_fuente->execute();
    }

    header('Location:' . $URL . 'admin/almacen/inventario');
    session_start();
    $_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();

}

?>