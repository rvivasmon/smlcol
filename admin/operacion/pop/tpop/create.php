<?php 
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

$id_gral_pop = $_GET['id_pop'];           // Obtén el segundo ID
$id_get = $_GET['id_oc'];      // Obtén el ID del ítem

// Capturar el valor de 'pop' desde la URL (si existe)
$pop_value = isset($_GET['pop']) ? $_GET['pop'] : '';
$ppal_pop_value = isset($_GET['pop_ppal']) ? $_GET['pop_ppal'] : '';

// Obtener el id_oc basado en el id_get
$query_get_oc = $pdo->prepare("SELECT id FROM items_pop WHERE id = :id_gral_pop");
$query_get_oc->bindParam(':id_gral_pop', $id_gral_pop);
$query_get_oc->execute();
$id_oc = $query_get_oc->fetchColumn(); // Obtener directamente el id_oc

// Obtener los valores de 'contador' y 'items1' desde la tabla items_pop
$query_get_items_pop = $pdo->prepare("SELECT contador, item1 FROM items_pop WHERE item_oc = :id_get");
$query_get_items_pop->bindParam(':id_get', $id_get);
$query_get_items_pop->execute();
$items_pop_data = $query_get_items_pop->fetch(PDO::FETCH_ASSOC);

// Extraer valores de 'contador' y 'items1' (asegurando que existan)
$contador_value = $items_pop_data['contador'] ?? '';
$item1_value = $items_pop_data['item1'] ?? '';

// Concatenar pop_value + contador + "/" + items1
$pop_concatenado = $pop_value. "-" . ($contador_value && $item1_value ? $contador_value . "/" . $item1_value : '');

// Consultar ítems asociados
$query_items = $pdo->prepare("SELECT * FROM items_oc WHERE id_item = :id_get");
$query_items->bindParam(':id_get', $id_get);
$query_items->execute();
$items = $query_items->fetchAll(PDO::FETCH_ASSOC);

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
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="descripcion_<?php echo $oc_item['id_item']; ?>">Descripcion</label>
                                        <textarea name="descripcion" id="descripcion_<?php echo $oc_item['id_item']; ?>" cols="30" rows="1" class="form-control" readonly><?php echo $oc_item['descripcion']; ?></textarea>
                                    </div>
                                </div>
                                <!-- Campo oculto para el ID del ítem de POP-->
                                <input type="hidden" name="id_item_oc" id="id_item_pc" value="<?php echo $oc_item['id_item']; ?>">

                                <!-- Campo oculto para el ID item de la pop -->
                                <input type="hidden" name="id_gral_pop" id="id_gral_pop" value="<?php echo $id_gral_pop; ?>">
                                <input type="hidden" name="ppal_pop_value" id="ppal_pop_value" value="<?php echo $ppal_pop_value; ?>">

                                <!-- Campo oculto para el ID del usuario -->
                                <input type="hidden" name="usuario" id="usuario" value="<?php echo $sesion_id_usuario; ?>">
                                <input type="hidden" name="pop_id" id="pop_id" value="<?php echo $pop_value; ?>">
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="uso_pan">USO PANTALLA</label>
                                        <select name="uso_pan" id="uso_pan" class="form-control" required>
                                            <option value="">Seleccione un Tipo de Uso</option>
                                            <?php
                                                // Consulta los estados de la base de datos
                                                $query_admones = $pdo->prepare('SELECT id_uso, producto_uso FROM t_uso_productos WHERE categoria_productos = 1');
                                                $query_admones->execute();
                                                $admon = $query_admones->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($admon as $admones) {
                                                    $acuerdo_admon = $admones['producto_uso'];
                                                    $id_admon_loop = $admones['id_uso'];

                                            ?>
                                                <option value="<?php echo $id_admon_loop;?>"><?php echo $acuerdo_admon;?></option>
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
                                            <option value="">Seleccione un Tipo</option>                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="pitch_tpop">PITCH</label>
                                        <select name="pitch_tpop" id="pitch_tpop" class="form-control" required>
                                            <option value="">Seleccione un Tipo de Pitch</option>
                                            <?php
                                                // Consulta los estados de la base de datos
                                                $query_pitches = $pdo->prepare('SELECT DISTINCT tp.pitch AS nombre_pitch,
                                                                                            tp.id AS nombre_id_pitch
                                                                                        FROM alma_principal AS ap
                                                                                        INNER JOIN producto_modulo_creado AS pmc ON ap.producto = pmc.id
                                                                                        INNER JOIN tabla_pitch AS tp ON pmc.pitch = tp.id
                                                                                        WHERE ap.tipo_producto = 1
                                                                                        ');
                                                $query_pitches->execute();
                                                $pitch = $query_pitches->fetchAll(PDO::FETCH_ASSOC);

                                                foreach ($pitch as $pitches) {
                                                    $acuerdo_pitch = $pitches['nombre_pitch'];
                                                    $id_pitch = $pitches['nombre_id_pitch'];

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
                                        <input type="text" name="medida_x" id="medida_x" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="medida_y">MEDIDA Y</label>
                                        <input type="text" name="medida_y" id="medida_y" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="medidas_modulo">MEDIDA MÓDULO</label>
                                        <select name="medidas_modulo" id="medidas_modulo" class="form-control" required>
                                            <option value="">Seleccione una Medida</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="total_modulos">TOTAL MODULOS</label>
                                        <input type="text" name="total_modulos" id="total_modulos" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="t_modulo">TIPO MÓDULO</label>
                                        <select name="t_modulo" id="t_modulo" class="form-control" required>
                                            <option value="">Seleccione un Tipo de Módulo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_modulo">SERIAL MÓDULO</label>
                                        <select name="s_modulo" id="s_modulo" class="form-control" required>
                                            <option value="">Seleccione un Serial</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="f_control">FUNCIÓN CONTROL</label>
                                        <select name="f_control" id="f_control" class="form-control" required>
                                            <option value="">Seleccione una Función</option>
                                            <?php
                                                // Consulta los estados de la base de datos
                                                $query_seriales = $pdo->prepare('SELECT id_car_ctrl, funcion_control FROM caracteristicas_control ORDER BY funcion_control ASC');
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
                                            <option value="">Seleccione una Controladora</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="num_control"># CONTROLADORAS</label>
                                        <input type="text" name="num_control" id="num_control" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="control_reciving">RECEIVING CARD</label>
                                        <select name="control_reciving" id="control_reciving" class="form-control" required>
                                            <option value="">Seleccione un Tipo de Pitch</option>
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
                                        <input type="text" name="num_tarjetas" id="num_tarjetas" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="t_fuente">TIPO FUENTE</label>
                                        <select name="t_fuente" id="t_fuente" class="form-control" required>
                                            <option value="">Seleccione un Tipo de Pitch</option>
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
                                        <input type="text" name="num_fuentes" id="num_fuentes" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="pixel_x">PIXEL X</label>
                                        <input type="text" name="pixel_x" id="pixel_x" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="pixel_y">PIXEL Y</label>
                                        <input type="text" name="pixel_y" id="pixel_y" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="pixel_total">PIXEL TOTAL</label>
                                        <input type="text" name="pixel_total" id="pixel_total" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label for="tipo_estructura">TIPO ESTRUCTURA</label>
                                        <input type="text" name="tipo_estructura" id="tipo_estructura" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="modulo_complemento">MÓDULO 1%</label>
                                        <input type="text" name="modulo_complemento" id="modulo_complemento" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="fuente_complemento">FUENTE 1%</label>
                                        <input type="text" name="fuente_complemento" id="fuente_complemento" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="reciving_complemento">RECEIVING 1%</label>
                                        <input type="text" name="reciving_complemento" id="reciving_complemento" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="proyecto_checkbox">Proyecto</label>
                                        <input type="checkbox" name="proyecto_checkbox" id="proyecto_checkbox" value="0"> 
                                        <!-- Si $proyecto tiene valor, el checkbox estará marcado -->
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ddi_checkbox">DDI</label>
                                        <input type="checkbox" name="ddi_checkbox" id="ddi_checkbox" value="0"> 
                                        <!-- Si $ddi tiene valor, el checkbox estará marcado -->
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="conexion">CONEXION</label>
                                        <input type="text" name="conexion" id="conexion" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="configuracion">CONFIGURACIÓN</label>
                                        <input type="text" name="configuracion" id="configuracion" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="estado_tpop">ESTADO TPOP</label>
                                        <input type="text" name="estado_tpop" id="estado_tpop" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="m_cuadrado">M²</label>
                                        <input type="text" name="m_cuadrado" id="m_cuadrado" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="voltaje">VOLTAJE</label>
                                        <input type="text" name="voltaje" id="voltaje" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="watts">WATTS</label>
                                        <input type="text" name="watts" id="watts" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="amperios">AMPERIOS</label>
                                        <input type="text" name="amperios" id="amperios" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="num_circuitos">CIRCUITOS</label>
                                        <input type="text" name="num_circuitos" id="num_circuitos" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="consumo">CONSUMO</label>
                                        <input type="text" name="consumo" id="consumo" class="form-control">
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