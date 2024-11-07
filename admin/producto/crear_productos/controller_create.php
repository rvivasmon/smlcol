<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

$producto = $_POST['producto'];
$id_usuario = $_POST['idusuario'];
$almagrupo = $_POST['almacen_grupo'];

$evidencias = $_POST['archivo_adjunto'];

$nombreDelArchivo = date( "Y-m-d-h-i-s");
$filename = $nombreDelArchivo."__".$_FILES['archivo_adjunto']['name'];
$location = "../../../img_uploads/".$filename;

move_uploaded_file($_FILES['archivo_adjunto']['tmp_name'],$location);


    /*  CAMPOS VERIFICADORES MODULOS    */
    $uso = !empty($_POST['uso']) ? $_POST['uso'] : NULL;
    $modelo_modulo1 = !empty($_POST['modelo_modulo1']) ? $_POST['modelo_modulo1'] : NULL;
    $pitch = !empty($_POST['pitch']) ? $_POST['pitch'] : NULL;
    $medida_modulo = !empty($_POST['medida_modulo']) ? $_POST['medida_modulo'] : NULL;
    $medida_x = !empty($_POST['medida_x']) ? $_POST['medida_x'] : NULL;
    $medida_y = !empty($_POST['medida_y']) ? $_POST['medida_y'] : NULL;
    $pixel_x = !empty($_POST['pixel_x']) ? $_POST['pixel_x'] : NULL;
    $pixel_y = !empty($_POST['pixel_y']) ? $_POST['pixel_y'] : NULL;
    $serie_modulo = !empty($_POST['serie_modulo']) ? $_POST['serie_modulo'] : NULL;
    $referencia_modulo = !empty($_POST['referencia_modulo']) ? $_POST['referencia_modulo'] : NULL;
    $ruta = !empty($_POST['archivo_adjunto']) ? $_POST['archivo_adjunto'] : NULL;

    /*  CAMPOS CREACIÓN CONTROLADORAS   */
    $marca_control3 = !empty($_POST['marca_control']) ? $_POST['marca_control'] : NULL;
    $funcion_control3 = !empty($_POST['funcion_control']) ? $_POST['funcion_control'] : NULL;
    $sim3 = !empty($_POST['sim']) ? $_POST['sim'] : NULL;
    $puertos3 = !empty($_POST['puertos']) ? $_POST['puertos'] : NULL;
    $referencia_control3 = !empty($_POST['referencia_control']) ? $_POST['referencia_control'] : NULL;
    $pixel_maximo3 = !empty($_POST['pixel_maximo']) ? $_POST['pixel_maximo'] : NULL;
    $pixel_x_puerto3 = !empty($_POST['pixel_x_puerto']) ? $_POST['pixel_x_puerto'] : NULL;
    $pixel_x_maximo3 = !empty($_POST['pixel_x_maximo']) ? $_POST['pixel_x_maximo'] : NULL;
    $pixel_y_maximo3 = !empty($_POST['pixel_y_maximo']) ? $_POST['pixel_y_maximo'] : NULL;
    $descripcion3 = !empty($_POST['descripcion']) ? $_POST['descripcion'] : NULL;

    /*  CAMPOS VERIFICADORES FUENTES    */
    $marca_fuente = !empty($_POST['marca_fuente']) ? $_POST['marca_fuente'] : NULL;
    $tipo_fuente = !empty($_POST['tipo_fuente']) ? $_POST['tipo_fuente'] : NULL;
    $voltaje_fuente = !empty($_POST['voltaje_fuente']) ? $_POST['voltaje_fuente'] : NULL;
    $modelo_fuente = !empty($_POST['modelo_fuente']) ? $_POST['modelo_fuente'] : NULL;

try {
    if ($producto == 1 || $producto == 'módulo') {
        // Verifica que todas las variables estén definidas
        if (isset($uso, $modelo_modulo1, $pitch, $medida_modulo, $medida_x, $medida_y, $pixel_x, $pixel_y, $serie_modulo, /*$referencia_modulo*/)) {
            $sql_modulo1 = "INSERT INTO producto_modulo_creado (uso, modelo, pitch, tamano, tamano_x, tamano_y, pixel_x, pixel_y, serie, referencia, ruta, almacen) 
                            VALUES (:uso, :modelo_modulo1, :pitch, :medida_modulo, :medida_x, :medida_y, :pixel_x, :pixel_y, :serie_modulo, :referencia_modulo, :evidencias, :almagrupo)";
            $sentencia_modulo1 = $pdo->prepare($sql_modulo1);
            $sentencia_modulo1->bindParam(':uso', $uso);
            $sentencia_modulo1->bindParam(':modelo_modulo1', $modelo_modulo1);
            $sentencia_modulo1->bindParam(':pitch', $pitch);
            $sentencia_modulo1->bindParam(':medida_modulo', $medida_modulo);
            $sentencia_modulo1->bindParam(':medida_x', $medida_x);
            $sentencia_modulo1->bindParam(':medida_y', $medida_y);
            $sentencia_modulo1->bindParam(':pixel_x', $pixel_x);
            $sentencia_modulo1->bindParam(':pixel_y', $pixel_y);
            $sentencia_modulo1->bindParam(':serie_modulo', $serie_modulo);
            $sentencia_modulo1->bindParam(':referencia_modulo', $referencia_modulo);
            $sentencia_modulo1->bindParam(':evidencias', $filename);
            $sentencia_modulo1->bindParam(':almagrupo', $almagrupo);
            $sentencia_modulo1->execute();
        }

    } elseif ($producto == 2 || $producto == 'controladora') {
        if (isset($marca_control3, $funcion_control3, $referencia_control3)) {
            $sql_referencia = "INSERT INTO referencias_control (marca, funcion, referencia, descripcion, sim, puertos, px_x_puerto, pixel_max, pixel_x_max, pixel_y_max, ruta, almacen) 
                            VALUES (:marca_control3, :funcion_control3, :referencia_control3, :descripcion3, :sim3, :puertos3, :pixel_x_puerto3, :pixel_maximo3, :pixel_x_maximo3, :pixel_y_maximo3, :evidencias, :almagrupo)";
            $sentencia_referencia = $pdo->prepare($sql_referencia);
            $sentencia_referencia->bindParam(':marca_control3', $marca_control3);
            $sentencia_referencia->bindParam(':funcion_control3', $funcion_control3);
            $sentencia_referencia->bindParam(':referencia_control3', $referencia_control3);
            $sentencia_referencia->bindParam(':descripcion3', $descripcion3);
            $sentencia_referencia->bindParam(':sim3', $sim3);
            $sentencia_referencia->bindParam(':puertos3', $puertos3);
            $sentencia_referencia->bindParam(':pixel_x_puerto3', $pixel_x_puerto3);
            $sentencia_referencia->bindParam(':pixel_maximo3', $pixel_maximo3);
            $sentencia_referencia->bindParam(':pixel_x_maximo3', $pixel_x_maximo3);
            $sentencia_referencia->bindParam(':pixel_y_maximo3', $pixel_y_maximo3);
            $sentencia_referencia->bindParam(':evidencias', $filename);
            $sentencia_referencia->bindParam(':almagrupo', $almagrupo);
            $sentencia_referencia->execute();
        }

    } elseif ($producto == 3 || $producto == 'fuente') {
        if (isset($marca_fuente, $tipo_fuente, $voltaje_fuente, $modelo_fuente)) {
            $sql_fuente_modelo = "INSERT INTO referencias_fuente (marca_fuente, tipo_fuente, voltaje_salida, modelo_fuente, ruta, almacen) VALUES (:marca_fuente, :tipo_fuente, :voltaje_fuente, :modelo_fuente, :evidencias, :almagrupo)";
            $sentencia_fuente_modelo = $pdo->prepare($sql_fuente_modelo);
            $sentencia_fuente_modelo->bindParam(':marca_fuente', $marca_fuente);
            $sentencia_fuente_modelo->bindParam(':tipo_fuente', $tipo_fuente);
            $sentencia_fuente_modelo->bindParam(':voltaje_fuente', $voltaje_fuente);
            $sentencia_fuente_modelo->bindParam(':modelo_fuente', $modelo_fuente);
            $sentencia_fuente_modelo->bindParam(':evidencias', $filename);
            $sentencia_fuente_modelo->bindParam(':almagrupo', $almagrupo);
            $sentencia_fuente_modelo->execute();
        }
    }

    header('Location:' . $URL . 'admin/almacen/inventario');
    session_start();
    $_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
    
?>
