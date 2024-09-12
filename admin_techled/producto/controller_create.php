<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../app/config/config.php');
include('../../app/config/conexion.php');
include('../../layout_techled/admin/sesion.php');
include('../../layout_techled/admin/datos_sesion_user.php');

$producto = $_POST['producto'];
$id_usuario = $_POST['idusuario'];

    /*  CAMPOS VERIFICADORES MODULOS    */
    $uso = !empty($_POST['uso']) ? $_POST['uso'] : NULL;
    $modelo_modulo1 = !empty($_POST['modelo_modulo1']) ? $_POST['modelo_modulo1'] : NULL;
    $pitch = !empty($_POST['pitch']) ? $_POST['pitch'] : NULL;
    $medida_x = !empty($_POST['medida_x']) ? $_POST['medida_x'] : NULL;
    $medida_y = !empty($_POST['medida_y']) ? $_POST['medida_y'] : NULL;
    $pixel_x = !empty($_POST['pixel_x']) ? $_POST['pixel_x'] : NULL;
    $pixel_y = !empty($_POST['pixel_y']) ? $_POST['pixel_y'] : NULL;
    $serie_modulo = !empty($_POST['serie_modulo']) ? $_POST['serie_modulo'] : NULL;
    $referencia_modulo = !empty($_POST['referencia_modulo']) ? $_POST['referencia_modulo'] : NULL;

    /*  CAMPOS CREACIÓN MODULOS */
$uso3 = !empty($_POST['uso3']) ? $_POST['uso3'] : NULL;
$modelo_modulo3 = !empty($_POST['modelo_modulo3']) ? $_POST['modelo_modulo3'] : NULL;
$pitch3 = !empty($_POST['pitch3']) ? $_POST['pitch3'] : NULL;
$medida_x3 = !empty($_POST['medida_x3']) ? $_POST['medida_x3'] : NULL;
$medida_y3 = !empty($_POST['medida_y3']) ? $_POST['medida_y3'] : NULL;
$pixel_x3 = !empty($_POST['pixel_x3']) ? $_POST['pixel_x3'] : NULL;
$pixel_y3 = !empty($_POST['pixel_y3']) ? $_POST['pixel_y3'] : NULL;
$serie_modulo3 = !empty($_POST['serie_modulo3']) ? $_POST['serie_modulo3'] : NULL;
$referencia_modulo3 = !empty($_POST['referencia_modulo3']) ? $_POST['referencia_modulo3'] : NULL;

    /*  CAMPOS VERIFICADORES CONTROLADORAS   */
    $marca_control = !empty($_POST['marca_control']) ? $_POST['marca_control'] : NULL;
    $funcion_control = !empty($_POST['funcion_control']) ? $_POST['funcion_control'] : NULL;
    $referencia_control = !empty($_POST['referencia_control']) ? $_POST['referencia_control'] : NULL;

    /*  CAMPOS CREACIÓN CONTROLADORAS   */
$marca_control3 = !empty($_POST['marca_control3']) ? $_POST['marca_control3'] : NULL;
$funcion_control3 = !empty($_POST['funcion_control3']) ? $_POST['funcion_control3'] : NULL;
$referencia_control3 = !empty($_POST['referencia_control3']) ? $_POST['referencia_control3'] : NULL;
$pixel_maximo3 = !empty($_POST['pixel_maximo3']) ? $_POST['pixel_maximo3'] : NULL;
$pixel_x_maximo3 = !empty($_POST['pixel_x_maximo3']) ? $_POST['pixel_x_maximo3'] : NULL;
$pixel_y_maximo3 = !empty($_POST['pixel_y_maximo3']) ? $_POST['pixel_y_maximo3'] : NULL;
$sim3 = !empty($_POST['sim3']) ? $_POST['sim3'] : NULL;
$puertos3 = !empty($_POST['puertos3']) ? $_POST['puertos3'] : NULL;
$pixel_x_puerto3 = !empty($_POST['pixel_x_puerto3']) ? $_POST['pixel_x_puerto3'] : NULL;
$descripcion3 = !empty($_POST['descripcion3']) ? $_POST['descripcion3'] : NULL;

    /*  CAMPOS VERIFICADORES FUENTES    */
    $marca_fuente = !empty($_POST['marca_fuente']) ? $_POST['marca_fuente'] : NULL;
    $tipo_fuente = !empty($_POST['tipo_fuente']) ? $_POST['tipo_fuente'] : NULL;
    $modelo_fuente = !empty($_POST['modelo_fuente']) ? $_POST['modelo_fuente'] : NULL;
    $voltaje_fuente = !empty($_POST['voltaje_fuente']) ? $_POST['voltaje_fuente'] : NULL;

    /*  CAMPOS CREACIÓN FUENTES */
$marca_fuente3 = !empty($_POST['marca_fuente3']) ? $_POST['marca_fuente3'] : NULL;
$tipo_fuente3 = !empty($_POST['tipo_fuente3']) ? $_POST['tipo_fuente3'] : NULL;
$modelo_fuente3 = !empty($_POST['modelo_fuente3']) ? $_POST['modelo_fuente3'] : NULL;
$voltaje_fuente3 = !empty($_POST['voltaje_fuente3']) ? $_POST['voltaje_fuente3'] : NULL;

$usuario = $_POST['idusuario'];

// Realizar las divisiones y redondear los resultados a enteros
$pixel_x3 = !empty($pitch3) && !empty($medida_x3) ? round($medida_x3 / $pitch3) : NULL;
$pixel_y3 = !empty($pitch3) && !empty($medida_y3) ? round($medida_y3 / $pitch3) : NULL;

try {
    if ($producto == 1 || $producto == 'módulo') {
        // Verificar y ejecutar la inserción de uso3
        if (!is_null($uso3)) {
            $sql_check_uso = "SELECT COUNT(*) FROM t_uso_productos WHERE producto_uso = :uso3";
            $sentencia_check_uso = $pdo->prepare($sql_check_uso);
            $sentencia_check_uso->bindParam(':uso3', $uso3);
            $sentencia_check_uso->execute();
            $count = $sentencia_check_uso->fetchColumn();

            // Si existe y el producto es 1, no hacer nada
            if ($count > 0) {
                if ($producto == 1) {
                    // No guardar ningún registro
                    header('Location:' . $URL . 'admin/almacen/inventario');
                    session_start();
                    $_SESSION['msj'] = "El registro ya existe y no se ha guardado.";
                    exit;
                }
            } else {
                // Guardar el registro
                $sql_modulo = "INSERT INTO t_uso_productos (t_productos, producto_uso) VALUES (:producto, :uso3)";
                $sentencia_modulo = $pdo->prepare($sql_modulo);
                $sentencia_modulo->bindParam(':producto', $producto);
                $sentencia_modulo->bindParam(':uso3', $uso3);
                $sentencia_modulo->execute();
            }
        }

        // Verificar y ejecutar la inserción de modelo_modulo3
        if (!is_null($modelo_modulo3)) {
            $sql_modulo_tipo = "INSERT INTO t_tipo_producto (modelo_modulo, uso_modelo) VALUES (:modelo_modulo3, :uso)";
            $sentencia_modulo_tipo = $pdo->prepare($sql_modulo_tipo);
            $sentencia_modulo_tipo->bindParam(':modelo_modulo3', $modelo_modulo3);
            $sentencia_modulo_tipo->bindParam(':uso', $uso);
            $sentencia_modulo_tipo->execute();
        }

        // Verificar y ejecutar la inserción de pitch3, medida_x3, medida_y3, pixel_x3, pixel_y3
        // Verificar cuál de los dos campos tiene un valor y asignar ese valor a $pitch_final
    $pitch_final = !empty($pitch) ? $pitch : $pitch3;

    if (!is_null($pitch_final) && !is_null($medida_x3) && !is_null($medida_y3) && !is_null($pixel_x3) && !is_null($pixel_y3) && !is_null($serie_modulo3) && !is_null($referencia_modulo3)) {
        $sql_modulo1 = "INSERT INTO caracteristicas_modulos (pitch, modelo_modulo, medida_x, medida_y, pixel_x, pixel_y, serie_modulo, referencia_modulo) 
                        VALUES (:pitch, :modelo_modulo1, :medida_x3, :medida_y3, :pixel_x3, :pixel_y3, :serie_modulo3, :referencia_modulo3)";
        $sentencia_modulo1 = $pdo->prepare($sql_modulo1);
        $sentencia_modulo1->bindParam(':pitch', $pitch_final);
        $sentencia_modulo1->bindParam(':modelo_modulo1', $modelo_modulo1);
        $sentencia_modulo1->bindParam(':medida_x3', $medida_x3);
        $sentencia_modulo1->bindParam(':medida_y3', $medida_y3);
        $sentencia_modulo1->bindParam(':pixel_x3', $pixel_x3);
        $sentencia_modulo1->bindParam(':pixel_y3', $pixel_y3);
        $sentencia_modulo1->bindParam(':serie_modulo3', $serie_modulo3);
        $sentencia_modulo1->bindParam(':referencia_modulo3', $referencia_modulo3);
        $sentencia_modulo1->execute();
    }

// Verificar si el campo "pitch" tiene un valor y obtener el "id_car_mod"
if (!is_null($pitch)) {
    // Obtener el id_car_mod correspondiente al pitch seleccionado
    $sql_get_id = "SELECT id_car_mod FROM caracteristicas_modulos WHERE pitch = :pitch LIMIT 1";
    $sentencia_get_id = $pdo->prepare($sql_get_id);
    $sentencia_get_id->bindParam(':pitch', $pitch);
    $sentencia_get_id->execute();
    $id_car_mod = $sentencia_get_id->fetchColumn();

    // Si se encuentra un id_car_mod correspondiente, se realiza la actualización
    if ($pitch) {
        // Actualizar los valores de medida_x, medida_y, serie_modulo y referencia_modulo
        $sql_update_modulo =    "UPDATE caracteristicas_modulos SET medida_x = :medida_x3, medida_y = :medida_y3, serie_modulo = :serie_modulo3, referencia_modulo = :referencia_modulo3 WHERE id_car_mod = :pitch";
        $sentencia_update_modulo = $pdo->prepare($sql_update_modulo);
        $sentencia_update_modulo->bindParam(':medida_x3', $medida_x3);
        $sentencia_update_modulo->bindParam(':medida_y3', $medida_y3);
        $sentencia_update_modulo->bindParam(':serie_modulo3', $serie_modulo3);
        $sentencia_update_modulo->bindParam(':referencia_modulo3', $referencia_modulo3);
        $sentencia_update_modulo->bindParam(':pitch', $pitch);
        $sentencia_update_modulo->execute();

        // Realizar las divisiones y redondear los resultados a enteros
        $pixel_x3 = !empty($pitch) && !empty($medida_x3) ? round($medida_x3 / $pitch) : NULL;
        $pixel_y3 = !empty($pitch) && !empty($medida_y3) ? round($medida_y3 / $pitch) : NULL;

        // Actualizar los valores de pixel_x y pixel_y en la base de datos
        $sql_update_pixels = "UPDATE caracteristicas_modulos SET pixel_x = :pixel_x3, pixel_y = :pixel_y3 WHERE id_car_mod = :pitch";
        $sentencia_update_pixels = $pdo->prepare($sql_update_pixels);
        $sentencia_update_pixels->bindParam(':pixel_x3', $pixel_x3);
        $sentencia_update_pixels->bindParam(':pixel_y3', $pixel_y3);
        $sentencia_update_pixels->bindParam(':pitch', $pitch);
        $sentencia_update_pixels->execute();
    }
}


    } elseif ($producto == 2 || $producto == 'controladora') {
        
        // Si "marca_control3" tiene datos, se ejecuta la inserción en la tabla "caracteristicas_control"
        $id_car_ctrl_marca = null;
        if (!is_null($marca_control3)) {
            $sql_marca = "INSERT INTO caracteristicas_control (marca_control) VALUES (:marca_control3)";
            $sentencia_marca = $pdo->prepare($sql_marca);
            $sentencia_marca->bindParam(':marca_control3', $marca_control3);
            $sentencia_marca->execute();

            // Obtener el ID del registro insertado
            $id_car_ctrl_marca = $pdo->lastInsertId();
        }

        // Si "funcion_control3" tiene datos, se ejecuta la inserción en la tabla "caracteristicas_control"
        $id_car_ctrl_funcion = null;
        if (!is_null($funcion_control3)) {
            $sql_funcion = "INSERT INTO caracteristicas_control (funcion_control) VALUES (:funcion_control3)";
            $sentencia_funcion = $pdo->prepare($sql_funcion);
            $sentencia_funcion->bindParam(':funcion_control3', $funcion_control3);
            $sentencia_funcion->execute();

            // Obtener el ID del registro insertado
            $id_car_ctrl_funcion = $pdo->lastInsertId();
        }

        // Si alguno de los campos relacionados a "referencias_control" tiene datos, se ejecuta la inserción en la tabla "referencias_control"
        if ((!is_null($referencia_control3) || !is_null($pixel_maximo3) || !is_null($pixel_x_maximo3) || !is_null($pixel_y_maximo3) || !is_null($sim3) || !is_null($puertos3) || !is_null($pixel_x_puerto3) || !is_null($descripcion3))) {
            $sql_referencia =   "INSERT INTO referencias_control (marca, funcion, referencia, descripcion, sim, puertos, px_x_puerto, pixel_max, pixel_x_max, pixel_y_max) 
                                VALUES (:marca_control, :funcion_control, :referencia_control3, :descripcion3, :sim3, :puertos3, :pixel_x_puerto3, :pixel_maximo3, :pixel_x_maximo3, :pixel_y_maximo3)";
            $sentencia_referencia = $pdo->prepare($sql_referencia);
            $sentencia_referencia->bindParam(':marca_control', $marca_control);
            $sentencia_referencia->bindParam(':funcion_control', $funcion_control);
            $sentencia_referencia->bindParam(':referencia_control3', $referencia_control3);
            $sentencia_referencia->bindParam(':descripcion3', $descripcion3);
            $sentencia_referencia->bindParam(':sim3', $sim3);
            $sentencia_referencia->bindParam(':puertos3', $puertos3);
            $sentencia_referencia->bindParam(':pixel_x_puerto3', $pixel_x_puerto3);
            $sentencia_referencia->bindParam(':pixel_maximo3', $pixel_maximo3);
            $sentencia_referencia->bindParam(':pixel_x_maximo3', $pixel_x_maximo3);
            $sentencia_referencia->bindParam(':pixel_y_maximo3', $pixel_y_maximo3);
            $sentencia_referencia->execute();
        }

    } elseif ($producto == 3 || $producto == 'fuente') {
        // Condicional para insertar en caracteristicas_fuentes si "marca_fuente3" tiene datos
        if (!is_null($marca_fuente3)) {
            $sql_fuente = "INSERT INTO caracteristicas_fuentes (marca_fuente) VALUES (:marca_fuente3)";
            $sentencia_fuente = $pdo->prepare($sql_fuente);
            $sentencia_fuente->bindParam(':marca_fuente3', $marca_fuente3);
            $sentencia_fuente->execute();
        }

        // Condicional para insertar en caracteristicas_fuentes si "tipo_fuente3" tiene datos
        if (!is_null($tipo_fuente3)) {
            $sql_fuente_tipo = "INSERT INTO caracteristicas_fuentes (tipo_fuente) VALUES (:tipo_fuente3)";
            $sentencia_fuente_tipo = $pdo->prepare($sql_fuente_tipo);
            $sentencia_fuente_tipo->bindParam(':tipo_fuente3', $tipo_fuente3);
            $sentencia_fuente_tipo->execute();
        }

        // Condicional para insertar en referencias_fuentes si "modelo_fuente3" tiene datos
        if (!is_null($modelo_fuente3)) {
            $sql_fuente_modelo = "INSERT INTO referencias_fuente (marca_fuente, tipo_fuente, modelo_fuente) VALUES (:marca_fuente, :tipo_fuente, :modelo_fuente3)";
            $sentencia_fuente_modelo = $pdo->prepare($sql_fuente_modelo);
            $sentencia_fuente_modelo->bindParam(':marca_fuente', $marca_fuente);
            $sentencia_fuente_modelo->bindParam(':tipo_fuente', $tipo_fuente);
            $sentencia_fuente_modelo->bindParam(':modelo_fuente3', $modelo_fuente3);
            $sentencia_fuente_modelo->execute();
        }

        // Condicional para actualizar "voltaje_fuente3" en referencias_fuentes si "voltaje_fuente3" tiene datos
        if (!is_null($voltaje_fuente3)) {
            $sql_fuente_voltaje = "UPDATE referencias_fuente SET voltaje_salida = :voltaje_fuente3 WHERE id_referencias_fuentes = :modelo_fuente";
            $sentencia_fuente_voltaje = $pdo->prepare($sql_fuente_voltaje);
            $sentencia_fuente_voltaje->bindParam(':voltaje_fuente3', $voltaje_fuente3);
            $sentencia_fuente_voltaje->bindParam(':modelo_fuente', $modelo_fuente); // Asegúrate de que $modulo_fuente contenga el id_referencia
            $sentencia_fuente_voltaje->execute();
                }
            }

    header('Location:' . $URL . 'admin_techled/almacen/inventario');
    session_start();
    $_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
