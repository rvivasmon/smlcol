<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $tipo_proyecto = $_POST['tipo_proyecto'];
    $id_proyecto = $_POST['id_proyecto'];
    $ciudad = $_POST['ciudad'];
    $nombre_proyecto = $_POST['nombre_proyecto'];
    $cliente = $_POST['cliente'];
    $contacto_cliente = $_POST['contacto_cliente'];
    $telefono_contacto = $_POST['telefono_contacto'];
    $asesor_encargado = $_POST['asesor_encargado'];
    $anio_mes = $_POST['anio_mes'];
    $contador = $_POST['contador'];
    $item_data = json_decode($_POST['item_data'], true);

    $pdo->beginTransaction();

    try {
        $query_pre_proyecto = $pdo->prepare('
            INSERT INTO pre_proyecto (fecha, tipo_proyecto, idprepro, ciudad, nombre_preproyecto, cliente, contacto, telefono, asesor, anio_mes, contador) 
            VALUES (:fecha, :tipo_proyecto, :id_proyecto, :ciudad, :nombre_proyecto, :cliente, :contacto_cliente, :telefono_contacto, :asesor_encargado, :anio_mes, :contador)
        ');

        $query_pre_proyecto->execute([
            ':fecha' => $fecha,
            ':tipo_proyecto' => $tipo_proyecto,
            ':id_proyecto' => $id_proyecto,
            ':ciudad' => $ciudad,
            ':nombre_proyecto' => $nombre_proyecto,
            ':cliente' => $cliente,
            ':contacto_cliente' => $contacto_cliente,
            ':telefono_contacto' => $telefono_contacto,
            ':asesor_encargado' => $asesor_encargado,
            ':contador' => $contador,
            ':anio_mes' => $anio_mes,
        ]);

        $pre_proyecto_id = $pdo->lastInsertId();

        $query_item_pre_proyecto = $pdo->prepare('
            INSERT INTO item_preproyecto (id_preproyec, cantidad_pantallas, estado, categoria, uso, tipo_producto, modelo_uso, pitch, x_disponible, y_disponible, justificacion) 
            VALUES (:pre_proyecto_id, :cantidad_pantallas, :estado, :categoria_producto, :uso, :tipo_producto, :tipo_modulo, :pitch, :x_disponible, :y_disponible, :justificacion)
        ');

        foreach ($item_data as $item) {
            $query_item_pre_proyecto->execute([
                ':pre_proyecto_id' => $pre_proyecto_id,
                ':cantidad_pantallas' => !empty($item['pantallas']) ? $item['pantallas'] : null,
                ':estado' => !empty($item['estado']) ? $item['estado'] : null,
                ':categoria_producto' => !empty($item['categoria_producto']) ? $item['categoria_producto'] : null,
                ':uso' => !empty($item['uso']) ? $item['uso'] : null,
                ':tipo_producto' => !empty($item['tipo_producto']) ? $item['tipo_producto'] : null,
                ':tipo_modulo' => !empty($item['tipo_modulo']) ? $item['tipo_modulo'] : null,
                ':pitch' => !empty($item['pitch']) ? $item['pitch'] : null,
                ':x_disponible' => !empty($item['x_disponible']) ? $item['x_disponible'] : null,
                ':y_disponible' => !empty($item['y_disponible']) ? $item['y_disponible'] : null,
                ':justificacion' => !empty($item['justificacion']) ? $item['justificacion'] : null,
            ]);
        }

        $pdo->commit();
        header('Location: ' . $URL . 'admin/crm/preproyectos');
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error de base de datos: " . $e->getMessage();
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
