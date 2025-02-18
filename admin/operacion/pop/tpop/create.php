<?php 
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

$id_pop = isset($_GET['id_pop']) ? $_GET['id_pop'] : null; // Obtener ID desde GET

// Inicializar variables vacías para los campos del formulario
$medida_y = $medida_x = $num_control = $num_tarjetas = $num_fuentes = $nombre_modelo_fuente = $proyecto_checkbox = "";
$pixel_x = $pixel_y = $pixel_total = $tipo_estructura = $controladora = $nombre_reciving_control = $rop_checkbox = "";
$modulo_complemento = $fuente_complemento = $reciving_complemento = $nombre_tamano_modulo = $ddi_checkbox = "";
$conexion = $configuracion = $m_cuadrado = $f_control = $control_reciving = $nombre_control = $nombre_estado_tpop = "";
$voltaje = $watts = $amperios = $num_circuitos = $consumo = $nombre_tipo_pitch = $nombre_funcion_control = "";
$estado_tpop = $total_modulos = $t_modulo = $s_modulo = $nombre_tipo_pan = $nombre_serie_modulo = "";
$uso = $tipo_pan = $pitch = $medidas_modulo = $t_fuente = $nombre_uso = $nombre_tipo_modulo = "";

if ($id_pop) {
    // Consultar la tabla 'tpop' para verificar si existe el ID
    $query_tpop = $pdo->prepare("SELECT tp.*,
                                        tup.producto_uso AS nombre_uso,
                                        ttp.tipo_producto21 AS nombre_tipo_pan,
                                        tapi.pitch AS nombre_tipo_pitch,
                                        ttm.tamanos_modulos AS nombre_tamano_modulo,
                                        ttpr.modelo_modulo AS nombre_tipo_modulo,
                                        pmc.referencia AS nombre_serie_modulo,
                                        cct.funcion_control AS nombre_funcion_control,
                                        rfc.referencia AS nombre_control,
                                        rfc1.referencia AS nombre_reciving_control,
                                        rff.modelo_fuente AS nombre_modelo_fuente,
                                        tet.estado_tpop AS nombre_estado_tpop
                                    FROM tpop AS tp
                                    INNER JOIN t_uso_productos AS tup ON tp.uso = tup.id_uso
                                    INNER JOIN t_tipo_producto AS ttp ON tp.tipo_pan = ttp.id
                                    INNER JOIN tabla_pitch AS tapi ON tp.pitch = tapi.id
                                    INNER JOIN tabla_tamanos_modulos AS ttm ON tp.medida_modulo = ttm.id
                                    INNER JOIN t_tipo_producto AS ttpr ON tp.tipo_modulo = ttpr.id
                                    INNER JOIN producto_modulo_creado AS pmc ON tp.serial_modulo = pmc.id
                                    INNER JOIN caracteristicas_control AS cct ON tp.funcion_control = cct.id_car_ctrl
                                    INNER JOIN referencias_control AS rfc ON tp.control = rfc.id_referencia
                                    INNER JOIN referencias_control AS rfc1 ON tp.receiving = rfc1.id_referencia
                                    INNER JOIN referencias_fuente AS rff ON tp.fuente = rff.id_referencias_fuentes
                                    INNER JOIN t_estado AS tet ON tp.estado_tpop = tet.id
                                    WHERE pop_item = ?
                                ");
    $query_tpop->execute([$id_pop]);
    $tpops = $query_tpop->fetch(PDO::FETCH_ASSOC);

    if ($tpops) {
        // Si se encuentra el registro, asignar los valores a las variables
        $id = $tpops['id'];
            $tpop_item = $tpops['tpop_item'];
            $pop_item = $tpops['pop_item'];
            $uso = $tpops['uso'];
            $nombre_uso = $tpops['nombre_uso'];
            $nombre_tipo_pitch = $tpops['nombre_tipo_pitch'];
            $pitch = $tpops['pitch'];
            $tipo_pan = $tpops['tipo_pan'];
            $nombre_tipo_pan = $tpops['nombre_tipo_pan'];
            $medida_x = $tpops['x'];
            $medida_y = $tpops['y'];
            $nombre_tamano_modulo = $tpops['nombre_tamano_modulo'];
            $medidas_modulo = $tpops['medida_modulo'];
            $total_modulos = $tpops['total_modulos'];
            $nombre_reciving_control = $tpops['nombre_reciving_control'];
            $control_reciving = $tpops['receiving'];
            $num_tarjetas = $tpops['cantidad_receiving'];
            $nombre_modelo_fuente = $tpops['nombre_modelo_fuente'];
            $t_fuente = $tpops['fuente'];
            $num_fuentes = $tpops['cantidad_fuente'];
            $pixel_x = $tpops['pixel_x'];
            $pixel_y = $tpops['pixel_y'];
            $pixel_total = $tpops['total_pixel'];
            $nombre_tipo_modulo = $tpops['nombre_tipo_modulo'];
            $t_modulo = $tpops['tipo_modulo'];
            $nombre_serie_modulo = $tpops['nombre_serie_modulo'];
            $s_modulo = $tpops['serial_modulo'];
            $nombre_funcion_control = $tpops['nombre_funcion_control'];
            $f_control = $tpops['funcion_control'];
            $nombre_control = $tpops['nombre_control'];
            $controladora = $tpops['control'];
            $num_control = $tpops['cantidad_control'];
            $modulo_complemento = $tpops['modulo_adic'];
            $fuente_complemento = $tpops['fuente_adic'];
            $reciving_complemento = $tpops['control_adic'];
            $tipo_estructura = $tpops['tipo_estructura'];
            $conexion = $tpops['conexion'];
            $configuracion = $tpops['configuracion'];
            $nombre_estado_tpop = $tpops['nombre_estado_tpop'];
            $estado_tpop = $tpops['estado_tpop'];
            $m_cuadrado = $tpops['m2'];
            $voltaje = $tpops['voltaje'];
            $watts = $tpops['watts'];
            $amperios = $tpops['amperios'];
            $num_circuitos = $tpops['cantidad_circuito'];
            $consumo = $tpops['consumo'];
            $usuario = $tpops['usuario'];
            $proyecto_checkbox = $tpops['proyecto'];
            $ddi_checkbox = $tpops['ddi'];
            $rop_checkbox = $tpops['rop'];
            $fecha_recibido = $tpops['fecha_recepcion'];
        }
}

$id_gral_pop = $_GET['id_pop']; // Obtén el segundo ID
$id_get = $_GET['id_oc'];   // Obtén el ID del ítem

// Capturar el valor de 'pop' desde la URL (si existe)
$pop_value = isset($_GET['pop']) ? $_GET['pop'] : '';
$ppal_pop_value = isset($_GET['pop_ppal']) ? $_GET['pop_ppal'] : '';

// Obtener el id_oc basado en el id_get
$query_get_oc = $pdo->prepare("SELECT id FROM items_pop WHERE id = :id_gral_pop");
$query_get_oc->bindParam(':id_gral_pop', $id_gral_pop);
$query_get_oc->execute();
$id_oc = $query_get_oc->fetchColumn(); // Obtener directamente el id_oc

// Obtener los valores de 'contador' y 'items1' desde la tabla items_pop
$query_get_items_pop = $pdo->prepare("SELECT id_oc, contador, item1 FROM items_pop WHERE item_oc = :id_get");
$query_get_items_pop->bindParam(':id_get', $id_get);
$query_get_items_pop->execute();
$items_pop_data = $query_get_items_pop->fetch(PDO::FETCH_ASSOC);

// Extraer valores de 'id_oc', 'contador' e 'items1' (asegurando que existan)
$oc_value = $items_pop_data['id_oc'] ?? '';
$contador_value = $items_pop_data['contador'] ?? '';
$item1_value = $items_pop_data['item1'] ?? '';

// Concatenar pop_value + contador + "/" + items1
$pop_concatenado = $pop_value. "-" . ($contador_value && $item1_value ? $contador_value . "/" . $item1_value : '');

// Consultar ítems asociados
$query_items = $pdo->prepare("SELECT * FROM items_oc WHERE id_item = :id_get");
$query_items->bindParam(':id_get', $id_get);
$query_items->execute();
$items = $query_items->fetchAll(PDO::FETCH_ASSOC);

// Para cada ítem, obtener su observación desde la tabla 'oc'
foreach ($items as &$oc_item) {
    $query_observacion = $pdo->prepare("SELECT observacion FROM oc WHERE id = :id_oc");
    $query_observacion->bindParam(':id_oc', $oc_item['id_oc']);
    $query_observacion->execute();
    $observacion_data = $query_observacion->fetch(PDO::FETCH_ASSOC);
    
    // Agregar observación al array del ítem (si existe)
    $oc_item['observacion'] = $observacion_data['observacion'] ?? '';
}
unset($oc_item); // Evita problemas con la referencia en foreach

// Consultar fecha de recepción
$query_fecha = $pdo->prepare("SELECT fecha_recibido, cantidad FROM items_pop WHERE id = :id_gral_pop");
$query_fecha->bindParam(':id_gral_pop', $id_gral_pop);
$query_fecha->execute();
$fecha_recibido_data = $query_fecha->fetch(PDO::FETCH_ASSOC);

// Extraer el valor de fecha_recibido y cantidad
$fecha_recib = $fecha_recibido_data['fecha_recibido'] ?? '';
$cantidad = $fecha_recibido_data['cantidad'] ?? '';

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">  
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear TPOP</h1>
                </div>
            </div>

            <div class="card">
                <div class="card-header" style="background-color: #00A000; color: #ffffff">
                    Modifique la información correspondiente
                </div>
                <div class="card-body">
                    <center>
                        <form action="controller_create.php" method="post">
                            <?php foreach ($items as $oc_item): ?>
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="id_pop_<?php echo $oc_item['id_item']; ?>">ID POP</label>
                                            <input type="text" name="id_pop" id="id_pop_<?php echo $oc_item['id_item']; ?>" value="<?php echo htmlspecialchars($pop_concatenado); ?>" class="form-control" readonly>
                                            </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="cantidad_<?php echo $oc_item['id_item']; ?>">Cantidad</label>
                                            <input type="number" name="cantidad" id="cantidad_<?php echo $oc_item['id_item']; ?>" value="<?php echo $oc_item['cantidad']; ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="instalacion_<?php echo $oc_item['id_item']; ?>">Instalación</label>
                                            <input type="text" name="instalacion" id="instalacion_<?php echo $oc_item['id_item']; ?>" value="<?php echo $oc_item['instalacion']; ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="observacion_<?php echo $oc_item['id_item']; ?>">Observaciones</label>
                                            <textarea name="observacion" id="observacion_<?php echo $oc_item['id_item']; ?>" cols="30" rows="1" class="form-control" readonly><?php echo htmlspecialchars($oc_item['observacion']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="descripcion_<?php echo $oc_item['id_item']; ?>">Descripcion</label>
                                            <textarea name="descripcion" id="descripcion_<?php echo $oc_item['id_item']; ?>" cols="30" rows="1" class="form-control" readonly><?php echo $oc_item['descripcion']; ?></textarea>
                                        </div>
                                    </div>
                                    <!-- Campo oculto para el ID del ítem de POP-->
                                    <input type="hidden" name="id_item_oc" id="id_item_pc" value="<?php echo $oc_item['id_item']; ?>">
                                    <input type="hidden" name="id_oc" id="id_oc" value="<?php echo $oc_value; ?>">

                                    <!-- Campo oculto para el ID item de la pop -->
                                    <input type="hidden" name="id_gral_pop" id="id_gral_pop" value="<?php echo $id_gral_pop; ?>">
                                    <input type="hidden" name="ppal_pop_value" id="ppal_pop_value" value="<?php echo $ppal_pop_value; ?>">

                                    <!-- Campo oculto para el ID del usuario -->
                                    <input type="hidden" name="usuario" id="usuario" value="<?php echo $sesion_id_usuario; ?>">
                                    <input type="hidden" name="pop_id" id="pop_id" value="<?php echo $pop_value; ?>">
                                    <input type="hidden" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>">
                                </div>

                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="fecha_recibe">Fecha Recibido</label>
                                            <input type="text" name="fecha_recibe" id="fecha_recibe" value="<?php echo $fecha_recib; ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="fecha_procesa">Fecha Procesado</label>
                                            <input type="text" name="fecha_procesa" id="fecha_procesa" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="modulo_complemento">MÓDULO 1%</label>
                                            <input type="text" name="modulo_complemento" id="modulo_complemento" value="<?php echo $modulo_complemento; ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="fuente_complemento">FUENTE 1%</label>
                                            <input type="text" name="fuente_complemento" id="fuente_complemento" value="<?php echo $fuente_complemento; ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="reciving_complemento">RECEIVING 1%</label>
                                            <input type="text" name="reciving_complemento" id="reciving_complemento" value="<?php echo $reciving_complemento; ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="proyecto_checkbox">Proyecto</label>
                                            <input type="checkbox" name="proyecto_checkbox" id="proyecto_checkbox" value="1" <?php echo ($proyecto_checkbox == 1) ? 'checked' : ''; ?>>
                                            <!-- Si $proyecto tiene valor, el checkbox estará marcado -->
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="ddi_checkbox">DDI</label>
                                            <input type="checkbox" name="ddi_checkbox" id="ddi_checkbox" value="1" <?php echo ($ddi_checkbox == 1) ? 'checked' : ''; ?>>
                                            <!-- Si $ddi tiene valor, el checkbox estará marcado -->
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="rop_checkbox">ROP</label>
                                            <input type="checkbox" name="rop_checkbox" id="rop_checkbox" value="1" <?php echo ($rop_checkbox == 1) ? 'checked' : ''; ?>>
                                            <!-- Si $ddi tiene valor, el checkbox estará marcado -->
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="uso_pan">USO PANTALLA</label>
                                            <select name="uso_pan" id="uso_pan" class="form-control" required>
                                                <option value="<?php echo $uso; ?>" selected>
                                                    <?php echo $nombre_uso; ?>
                                                </option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_admones = $pdo->prepare('SELECT id_uso, producto_uso FROM t_uso_productos WHERE categoria_productos = 1');
                                                    $query_admones->execute();
                                                    $admon = $query_admones->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($admon as $admones) {
                                                        $acuerdo_admon = $admones['producto_uso'];
                                                        $id_admon_loop = $admones['id_uso'];

                                                        // Excluir la opción que ya está seleccionada
                                                        if ($id_admon_loop == $uso) {
                                                            continue; // Salta esta iteración y sigue con la siguiente
                                                        }

                                                ?>
                                                    <option value="<?php echo $id_admon_loop; ?>"><?php echo $acuerdo_admon;?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="tipo_pan">TIPO PANTALLA</label>
                                            <select name="tipo_pan" id="tipo_pan" class="form-control" required>
                                                <option value="<?php echo $tipo_pan; ?>" selected>
                                                    <?php echo $nombre_tipo_pan; ?>
                                                </option>                                            
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="pitch_tpop">PITCH</label>
                                            <select name="pitch_tpop" id="pitch_tpop" class="form-control" required>
                                                <option value="<?php echo $pitch; ?>" selected>
                                                    <?php echo $nombre_tipo_pitch; ?>
                                                </option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_pitches = $pdo->prepare('SELECT DISTINCT tp.pitch AS nombre_pitch,
                                                                                                tp.id AS nombre_id_pitch
                                                                                            FROM alma_principal AS ap
                                                                                            INNER JOIN producto_modulo_creado AS pmc ON ap.producto = pmc.id
                                                                                            INNER JOIN tabla_pitch AS tp ON pmc.pitch = tp.id
                                                                                            WHERE ap.tipo_producto = 1
                                                                                            ORDER BY tp.pitch ASC
                                                                                            ');
                                                    $query_pitches->execute();
                                                    $pitch = $query_pitches->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($pitch as $pitches) {
                                                        $acuerdo_pitch = $pitches['nombre_pitch'];
                                                        $id_pitch = $pitches['nombre_id_pitch'];

                                                        // Excluir la opción que ya está seleccionada
                                                        if ($id_pitch == $pitch) {
                                                            continue; // Salta esta iteración y sigue con la siguiente
                                                        }

                                                ?>
                                                    <option value="<?php echo $id_pitch;?>"><?php echo $acuerdo_pitch;?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="medida_x">MEDIDA X</label>
                                            <input type="text" name="medida_x" id="medida_x" value="<?php echo $medida_x; ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="medida_y">MEDIDA Y</label>
                                            <input type="text" name="medida_y" id="medida_y" value="<?php echo $medida_y; ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="medidas_modulo">MEDIDA MÓDULO</label>
                                            <select name="medidas_modulo" id="medidas_modulo" value="<?php echo $medidas_modulo; ?>" class="form-control" required>
                                                <option value="<?php echo $medidas_modulo; ?>" selected>
                                                    <?php echo $nombre_tamano_modulo; ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="total_modulos">TOTAL MODULOS</label>
                                            <input type="text" name="total_modulos" id="total_modulos" value="<?php echo $total_modulos; ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="t_modulo">TIPO MÓDULO</label>
                                            <select name="t_modulo" id="t_modulo" class="form-control" required>
                                                <option value="<?php echo $t_modulo; ?>" selected>
                                                    <?php echo $nombre_tipo_modulo; ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="s_modulo">SERIAL MÓDULO</label>
                                            <select name="s_modulo" id="s_modulo" class="form-control" required>
                                                <option value="<?php echo $s_modulo; ?>" selected>
                                                    <?php echo $nombre_serie_modulo; ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="cant_dispo">DISPONIBLE</label>
                                            <input type="text" name="cant_dispo" id="cant_dispo" class="form-control" readonly>
                                            <!--<input type="text" name="cant_dispo" id="cant_dispo" value="<?php echo $medida_x; ?>" class="form-control" readonly>-->
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="f_control">FUNCIÓN CONTROL</label>
                                            <select name="f_control" id="f_control" class="form-control" required>
                                                <option value="<?php echo $f_control; ?>" selected>
                                                    <?php echo $nombre_funcion_control; ?>
                                                </option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_seriales = $pdo->prepare('SELECT id_car_ctrl, funcion_control FROM caracteristicas_control WHERE id_car_ctrl <> 1 ORDER BY funcion_control ASC');
                                                    $query_seriales->execute();
                                                    $serial = $query_seriales->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($serial as $seriales) {
                                                        $nombre_serial = $seriales['funcion_control'];
                                                        $id_serial = $seriales['id_car_ctrl'];

                                                ?>
                                                    <option value="<?php echo $id_serial;?>"><?php echo $nombre_serial;?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="controladora">CONTROLADORA</label>
                                            <select name="controladora" id="controladora" class="form-control" required>
                                                <option value="<?php echo $controladora; ?>" selected>
                                                    <?php echo $nombre_control; ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="num_control">CANTIDAD</label>
                                            <input type="text" name="num_control" id="num_control" value="<?php echo $num_control; ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="dispo_control">DISPONIBLE</label>
                                            <input type="text" name="dispo_control" id="dispo_control" value="<?php echo $num_control; ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="control_reciving">RECEIVING CARD</label>
                                            <select name="control_reciving" id="control_reciving" class="form-control" required>
                                                <option value="<?php echo $control_reciving; ?>" selected>
                                                    <?php echo $nombre_reciving_control; ?>
                                                </option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_recibidores = $pdo->prepare('SELECT id_referencia, referencia FROM referencias_control WHERE funcion = 1 ORDER BY referencia ASC');
                                                    $query_recibidores->execute();
                                                    $recibidor = $query_recibidores->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($recibidor as $recibidores) {
                                                        $acuerdo_recibidor = $recibidores['referencia'];
                                                        $id_recibidor = $recibidores['id_referencia'];

                                                ?>
                                                    <option value="<?php echo $id_recibidor;?>"><?php echo $acuerdo_recibidor;?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="num_tarjetas"># TARJETAS</label>
                                            <input type="text" name="num_tarjetas" id="num_tarjetas" value="<?php echo $num_tarjetas; ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="dispo_tarjetas">DISPONIBLE</label>
                                            <input type="text" name="dispo_tarjetas" id="dispo_tarjetas" value="<?php echo $num_tarjetas; ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="t_fuente">TIPO FUENTE</label>
                                            <select name="t_fuente" id="t_fuente" class="form-control" required>
                                                <option value="<?php echo $t_fuente; ?>" selected>
                                                    <?php echo $nombre_modelo_fuente; ?>
                                                </option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_fuentes = $pdo->prepare('SELECT id_referencias_fuentes, modelo_fuente FROM referencias_fuente ORDER BY modelo_fuente ASC');
                                                    $query_fuentes->execute();
                                                    $fuente = $query_fuentes->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($fuente as $fuentes) {
                                                        $acuerdo_fuente = $fuentes['modelo_fuente'];
                                                        $id_fuente = $fuentes['id_referencias_fuentes'];

                                                ?>
                                                    <option value="<?php echo $id_fuente;?>"><?php echo $acuerdo_fuente;?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="num_fuentes"># FUENTES</label>
                                            <input type="text" name="num_fuentes" id="num_fuentes" value="<?php echo $num_fuentes; ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="dispo_fuente">DISPONIBLE</label>
                                            <input type="number" name="dispo_fuente" id="dispo_fuente" value="<?php echo $pixel_x; ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="pixel_x">PIXEL X</label>
                                            <input type="number" name="pixel_x" id="pixel_x" value="<?php echo $pixel_x; ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="pixel_y">PIXEL Y</label>
                                            <input type="number" name="pixel_y" id="pixel_y" value="<?php echo $pixel_y; ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="pixel_total">PIXEL TOTAL</label>
                                            <input type="number" name="pixel_total" id="pixel_total" value="<?php echo $pixel_total; ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            // Obtener referencias a los campos
                                            let pixelX = document.getElementById("pixel_x");
                                            let pixelY = document.getElementById("pixel_y");
                                            let pixelTotal = document.getElementById("pixel_total");

                                            function calcularTotal() {
                                                let x = parseFloat(pixelX.value) || 0; // Si está vacío, toma 0
                                                let y = parseFloat(pixelY.value) || 0; // Si está vacío, toma 0
                                                pixelTotal.value = x * y; // Multiplica y asigna el resultado
                                            }

                                            // Escuchar eventos de entrada en ambos campos
                                            pixelX.addEventListener("input", calcularTotal);
                                            pixelY.addEventListener("input", calcularTotal);
                                        });

                                    </script>

                                </div>

                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label for="tipo_estructura">TIPO ESTRUCTURA</label>
                                            <input type="text" name="tipo_estructura" id="tipo_estructura" value="<?php echo $tipo_estructura; ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="conexion">CONEXION</label>
                                            <input type="text" name="conexion" id="conexion" value="<?php echo $conexion; ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="configuracion">CONFIGURACIÓN</label>
                                            <input type="text" name="configuracion" id="configuracion" value="<?php echo $configuracion; ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="estado_tpop">ESTADO TPOP</label>
                                            <select name="estado_tpop" id="estado_tpop" class="form-control" required>
                                                <option value="<?php echo $estado_tpop; ?>" selected>
                                                    <?php echo $nombre_estado_tpop; ?>
                                                </option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_estados = $pdo->prepare("SELECT id, estado_tpop FROM t_estado WHERE estado_tpop IS NOT NULL AND estado_tpop <> ''");
                                                    $query_estados->execute();
                                                    $estado = $query_estados->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($estado as $estados) {
                                                        $nombre_estados_tpop = $estados['estado_tpop'];
                                                        $id_estados_tpop = $estados['id'];
                                                        
                                                        // Si el ID es 1, marcarlo como seleccionado
                                                        $selected = ($id_estados_tpop == 1) ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $id_estados_tpop; ?>" <?php echo $selected; ?>>
                                                        <?php echo $nombre_estados_tpop; ?>
                                                    </option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                            <input type="hidden" name="id_estado_tpop" id="id_estado_tpop" value="1" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="m_cuadrado">M²</label>
                                            <input type="text" name="m_cuadrado" id="m_cuadrado" value="<?php echo $m_cuadrado; ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="voltaje">VOLTAJE</label>
                                            <input type="text" name="voltaje" id="voltaje" value="<?php echo $voltaje; ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="watts">WATTS</label>
                                            <input type="text" name="watts" id="watts" value="<?php echo $watts; ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="amperios">AMPERIOS</label>
                                            <input type="text" name="amperios" id="amperios" value="<?php echo $amperios; ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="num_circuitos">CIRCUITOS</label>
                                            <input type="text" name="num_circuitos" id="num_circuitos" value="<?php echo $num_circuitos; ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="consumo">CONSUMO</label>
                                            <input type="text" name="consumo" id="consumo" value="<?php echo $consumo; ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <a href="<?php echo $URL."admin/operacion/pop/edit.php?id=".$ppal_pop_value; ?>" class="btn btn-default btn-block">Cancelar</a>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" onclick="return confirm('¿Seguro de haber diligenciado correctamente los datos?')" class="btn btn-success btn-block">CREAR TPOP</button>
                                </div>
                            </div>
                        </form>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../../../../layout/admin/parte2.php'); ?>

<script>
document.getElementById('uso_pan').addEventListener('change', function() {
    var uso_pan_value = this.value;

    if (uso_pan_value !== '') {
        // Hacer la solicitud AJAX para filtrar los valores de tipo_pan
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'obtener_tipo_pan.php?id_uso=' + uso_pan_value, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var tipo_pan_select = document.getElementById('tipo_pan');
                tipo_pan_select.innerHTML = '<option value="">Seleccione un Tipo</option>'; // Limpiar opciones anteriores
                var response = JSON.parse(xhr.responseText);

                response.forEach(function(item) {
                    var option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.tipo_producto21;
                    tipo_pan_select.appendChild(option);
                });
            }
        };
        xhr.send();
    } else {
        // Limpiar el campo tipo_pan si no se selecciona nada
        document.getElementById('tipo_pan').innerHTML = '<option value="">Seleccione un Tipo</option>';
    }
});

document.getElementById('uso_pan').addEventListener('change', function() {
    var uso_pan_value = this.value;

    if (uso_pan_value !== '') {
        // Hacer la solicitud AJAX para filtrar los valores de t_modulo
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'obtener_tipo_modulo.php?id_uso=' + uso_pan_value, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var tipo_modulo_select = document.getElementById('t_modulo');
                tipo_modulo_select.innerHTML = '<option value="">Seleccione un Tipo de Módulo</option>'; // Limpiar opciones anteriores

                var response = JSON.parse(xhr.responseText);

                console.log(response); // Verifica la respuesta del servidor

                response.forEach(function(item) {
                    var option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.modelo_modulo;
                    tipo_modulo_select.appendChild(option);
                });
            }
        };
        xhr.send();
    } else {
        // Limpiar el campo tipo_modulo si no se selecciona un uso_pan
        document.getElementById('t_modulo').innerHTML = '<option value="">Seleccione un Tipo de Módulo</option>';
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var t_modulo = document.getElementById('t_modulo');
    var pitch_tpop = document.getElementById('pitch_tpop'); // Captura el select de pitch
    var id_pitch = ""; // Variable para almacenar el valor del pitch seleccionado

    // Detectar cuando el usuario cambia el select de pitch
    pitch_tpop.addEventListener('change', function () {
        id_pitch = this.value; // Guarda el valor seleccionado en la variable
        console.log('ID Pitch seleccionado:', id_pitch);
    });

    t_modulo.addEventListener('change', function() {
        var t_modulo_value = this.value;

        if (t_modulo_value !== '' && id_pitch !== '') { // Verifica que ambos valores estén seleccionados
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'obtener_s_modulo.php?id_modulo=' + t_modulo_value + '&id_pitch=' + id_pitch, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var s_modulo_select = document.getElementById('s_modulo');
                    s_modulo_select.innerHTML = '<option value="">Seleccione un Serial</option>';

                    var response = JSON.parse(xhr.responseText);
                    console.log(response);  // Verifica la respuesta del servidor
                    response.forEach(function(item) {
                        var option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.referencia;
                        s_modulo_select.appendChild(option);
                    });
                }
            };
            xhr.send();
        } else {
            document.getElementById('s_modulo').innerHTML = '<option value="">Seleccione un Serial</option>';
        }
    });
});

document.getElementById('f_control').addEventListener('change', function() {
    var f_control_value = this.value;
    console.log('Valor de f_control:', f_control_value);  // Verifica el valor

    if (f_control_value !== '') {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'obtener_controladora.php?id_control=' + f_control_value, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var controladora_select = document.getElementById('controladora');
                controladora_select.innerHTML = '<option value="">Seleccione una Controladora</option>';

                var response = JSON.parse(xhr.responseText);
                console.log(response);  // Verifica la respuesta del servidor
                response.forEach(function(item) {
                    var option = document.createElement('option');
                    option.value = item.id_referencia;
                    option.textContent = item.referencia;
                    controladora_select.appendChild(option);
                });
            }
        };
        xhr.send();
    } else {
        document.getElementById('controladora').innerHTML = '<option value="">Seleccione una Controladora</option>';
    }
});


// Filtrar valores de "medidas_modulo"
document.getElementById('pitch_tpop').addEventListener('change', function() {
    var pitchValue = this.value;

    if (pitchValue !== '') {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'obtener_medidas.php?pitch=' + pitchValue, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var medidasSelect = document.getElementById('medidas_modulo');
                medidasSelect.innerHTML = '<option value="">Seleccione una Medida</option>';

                var response = JSON.parse(xhr.responseText);
                var medidasUnicas = [];

                // Filtrar valores únicos basados en "tamano"
                response.forEach(function(item) {
                    if (!medidasUnicas.some(medida => medida.tamano === item.tamano)) {
                        medidasUnicas.push(item);
                    }
                });

                // Agregar opciones al select
                medidasUnicas.forEach(function(item) {
                    var option = document.createElement('option');
                    option.value = item.tamano;
                    option.textContent = item.descripcion; // Mostrar tamaño y descripción
                    medidasSelect.appendChild(option);
                });
            }
        };
        xhr.send();
    }
});


// Cálculo de cantidad de módulos

document.getElementById('medidas_modulo').addEventListener('change', function() {
    var medidaSeleccionada = this.value;
    var medidaX = parseFloat(document.getElementById('medida_x').value);
    var medidaY = parseFloat(document.getElementById('medida_y').value);

    if (medidaSeleccionada !== '' && !isNaN(medidaX) && !isNaN(medidaY)) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'obtener_tamanos.php?medida=' + medidaSeleccionada, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var datos = JSON.parse(xhr.responseText);

                if (datos.tamano_x && datos.tamano_y) {
                    var resultadoX = Math.floor(medidaX / datos.tamano_x);
                    var resultadoY = Math.floor(medidaY / datos.tamano_y);
                    var total = resultadoX + resultadoY;

                    document.getElementById('total_modulos').value = total;
                }
            }
        };
        xhr.send();
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function actualizarTipoEstructura() {
        // Obtener valores VISIBLES en lugar de IDs
        var tipo_pan = document.getElementById('tipo_pan');
        var tipo_pan_text = tipo_pan.options[tipo_pan.selectedIndex].text;

        var pitch_tpop = document.getElementById('pitch_tpop');
        var pitch_tpop_text = pitch_tpop.options[pitch_tpop.selectedIndex].text;

        var medida_x = document.getElementById('medida_x').value; // Valor numérico
        var medida_y = document.getElementById('medida_y').value; // Valor numérico

        var medidas_modulo = document.getElementById('medidas_modulo');
        var medidas_modulo_text = medidas_modulo.options[medidas_modulo.selectedIndex].text;

        // Crear la cadena concatenada con "/"
        var tipo_estructura = [tipo_pan_text, pitch_tpop_text, medida_x, medida_y, medidas_modulo_text]
            .filter(val => val.trim() !== '') // Filtra valores vacíos
            .join('/');

        // Asignar el valor al campo tipo_estructura
        document.getElementById('tipo_estructura').value = tipo_estructura;
    }

    // Agregar eventos a los campos para que llamen a la función cuando cambien
    document.getElementById('tipo_pan').addEventListener('change', actualizarTipoEstructura);
    document.getElementById('pitch_tpop').addEventListener('change', actualizarTipoEstructura);
    document.getElementById('medida_x').addEventListener('input', actualizarTipoEstructura);
    document.getElementById('medida_y').addEventListener('input', actualizarTipoEstructura);
    document.getElementById('medidas_modulo').addEventListener('change', actualizarTipoEstructura);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function actualizarCalculos() {
        var medida_x = parseFloat(document.getElementById('medida_x').value) || 0;
        var medida_y = parseFloat(document.getElementById('medida_y').value) || 0;
        var consumo = parseFloat(document.getElementById('consumo').value) || 0;
        var voltaje = parseFloat(document.getElementById('voltaje').value) || 1; // Evitar división por 0

        // Calcular metros cuadrados (medida_x * medida_y) / 1000
        var m_cuadrado = ((medida_x * medida_y) / 1000000).toFixed(2);
        document.getElementById('m_cuadrado').value = m_cuadrado;

        // Calcular watts (consumo / m_cuadrado)
        var watts = (m_cuadrado > 0) ? (consumo / m_cuadrado).toFixed(2) : 0;
        document.getElementById('watts').value = watts;

        // Calcular amperios (watts / voltaje)
        var amperios = (voltaje > 0) ? (watts / voltaje).toFixed(2) : 0;
        document.getElementById('amperios').value = amperios;

        // Calcular número de circuitos (amperios / 20)
        var num_circuitos = (amperios / 20).toFixed(2);
        document.getElementById('num_circuitos').value = num_circuitos;
    }

    // Agregar eventos a los campos para que llamen a la función cuando cambien
    document.getElementById('medida_x').addEventListener('input', actualizarCalculos);
    document.getElementById('medida_y').addEventListener('input', actualizarCalculos);
    document.getElementById('consumo').addEventListener('input', actualizarCalculos);
    document.getElementById('voltaje').addEventListener('input', actualizarCalculos);
});
</script>

<script>
    // Cantidad Módulos
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('s_modulo').addEventListener('change', function() {
        var idSerial = this.value;

        if (idSerial !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'obtener_cantidad.php?id_serial=' + idSerial, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var respuesta = JSON.parse(xhr.responseText);

                    if (respuesta && respuesta.cantidad_plena) {
                        document.getElementById('cant_dispo').value = respuesta.cantidad_plena;
                    } else {
                        document.getElementById('cant_dispo').value = ''; // Si no hay datos, dejar vacío
                    }
                }
            };
            xhr.send();
        } else {
            document.getElementById('cant_dispo').value = ''; // Si no hay selección, dejar vacío
        }
    });
});

    // Cantidad controladoras
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('controladora').addEventListener('change', function() {
        var idSerialControl = this.value;

        if (idSerialControl !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'obtener_cantidad_control.php?id_serial_control=' + idSerialControl, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var respuesta_control = JSON.parse(xhr.responseText);

                    if (respuesta_control && respuesta_control.cantidad_plena) {
                        document.getElementById('dispo_control').value = respuesta_control.cantidad_plena;
                    } else {
                        document.getElementById('dispo_control').value = ''; // Si no hay datos, dejar vacío
                    }
                }
            };
            xhr.send();
        } else {
            document.getElementById('dispo_control').value = ''; // Si no hay selección, dejar vacío
        }
    });
});

    // Cantidad fuentes
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('t_fuente').addEventListener('change', function() {
        var idSerial_fuente = this.value;

        if (idSerial_fuente !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'obtener_cantidad_fuentes.php?id_serial_fuente=' + idSerial_fuente, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var respuesta_fuente = JSON.parse(xhr.responseText);

                    if (respuesta_fuente && respuesta_fuente.cantidad_plena) {
                        document.getElementById('dispo_fuente').value = respuesta_fuente.cantidad_plena;
                    } else {
                        document.getElementById('dispo_fuente').value = ''; // Si no hay datos, dejar vacío
                    }
                }
            };
            xhr.send();
        } else {
            document.getElementById('dispo_fuente').value = ''; // Si no hay selección, dejar vacío
        }
    });
});

    // Cantidad receiving
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('control_reciving').addEventListener('change', function() {
        var idSerial_reciving = this.value;

        if (idSerial_reciving !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'obtener_cantidad_reciving.php?id_serial_reciving=' + idSerial_reciving, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var respuesta_reciving = JSON.parse(xhr.responseText);

                    if (respuesta_reciving && respuesta_reciving.cantidad_plena) {
                        document.getElementById('dispo_tarjetas').value = respuesta_reciving.cantidad_plena;
                    } else {
                        document.getElementById('dispo_tarjetas').value = ''; // Si no hay datos, dejar vacío
                    }
                }
            };
            xhr.send();
        } else {
            document.getElementById('dispo_tarjetas').value = ''; // Si no hay selección, dejar vacío
        }
    });
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let medidaX = document.getElementById("medida_x");
        let medidaY = document.getElementById("medida_y");
        let pitchSelect = document.getElementById("pitch_tpop");
        let pixelX = document.getElementById("pixel_x");
        let pixelY = document.getElementById("pixel_y");
        let pixelTotal = document.getElementById("pixel_total");

        if (!medidaX || !medidaY || !pitchSelect || !pixelX || !pixelY || !pixelTotal) {
            console.error("Uno o más elementos del formulario no existen.");
            return;
        }

        // ⚠️ PASO IMPORTANTE: Generar JSON correctamente desde PHP
        let pitchValores = <?php 
            $pitchArray = [];
            foreach ($pitch as $pitches) {
                $pitchArray[$pitches['nombre_id_pitch']] = floatval($pitches['nombre_pitch']);
            }
            echo json_encode($pitchArray, JSON_FORCE_OBJECT);
        ?>;

        console.log("Pitch valores cargados:", pitchValores); // Verifica la estructura en la consola

        function redondeoPersonalizado(valor) {
            let parteEntera = Math.floor(valor);
            let decimal = valor - parteEntera;
            return decimal >= 0.5 ? Math.ceil(valor) : Math.floor(valor);
        }

        function calcularPixeles() {
            let mx = parseFloat(medidaX.value) || 0;
            let my = parseFloat(medidaY.value) || 0;
            let pitchId = pitchSelect.value;
            let pitchReal = parseFloat(pitchValores[pitchId]) || 1;

            console.log("Medida X:", mx, "Medida Y:", my, "Pitch seleccionado:", pitchId, "Valor real:", pitchReal);

            if (pitchReal > 0) {
                pixelX.value = redondeoPersonalizado(mx / pitchReal);
                pixelY.value = redondeoPersonalizado(my / pitchReal);
                pixelTotal.value = pixelX.value * pixelY.value;
            }
        }

        medidaX.addEventListener("input", calcularPixeles);
        medidaY.addEventListener("input", calcularPixeles);
        pitchSelect.addEventListener("change", calcularPixeles);

        calcularPixeles();
    });
</script>