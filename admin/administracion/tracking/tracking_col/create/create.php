<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

include('../../../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Solicitud Mercancia a China</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue" style="width: 120rem;">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create.php" method="POST" id="formulario_creacion_producto">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fecha">Fecha</label>
                                                    <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control" placeholder="Fecha" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="solicitante">Solicitante</label>
                                                    <select id="solicitante" name="solicitante" class="form-control" required>
                                                        <option value="">Seleccione un Solicitante</option>
                                                            <?php
                                                            $query_solicitante = $pdo->prepare('SELECT id, siglas FROM almacenes_grupo WHERE siglas IS NOT NULL AND siglas != "" AND habilitar = "1" ORDER BY siglas ASC');
                                                            $query_solicitante->execute();
                                                        $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($solicitantes as $solicitud) {
                                                            echo '<option value="' . $solicitud['id'] . '">' . $solicitud['siglas'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" id="ano_mes" name="ano_mes" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="codigo_generado">Contador de Entrada</label>
                                                    <input type="text" id="codigo_generado" name="codigo_generado" class="form-control" required readonly>
                                                    <input type="hidden" id="contador" name="contador" class="form-control" value="<?php ?>">
                                                    <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $sesion_usuario['id']; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fecha_oc">FECHA OC</label>
                                                    <input type="date" id="fecha_oc" name="fecha_oc" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="origen">OC</label>
                                                    <input type="text" id="origen" name="origen" class="form-control" placeholder="OC" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="origen_cliente">CLIENTE</label>
                                                    <select id="origen_cliente" name="origen_cliente" class="form-control" required>
                                                        <option value="">Seleccione un Cliente</option>
                                                            <?php
                                                            $query_solicitante = $pdo->prepare('SELECT id, nombre_comercial FROM clientes WHERE nombre_comercial IS NOT NULL AND nombre_comercial != "" ORDER BY nombre_comercial ASC');
                                                            $query_solicitante->execute();
                                                        $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($solicitantes as $solicitud) {
                                                            echo '<option value="' . $solicitud['id'] . '">' . $solicitud['nombre_comercial'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-7">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group cloned-section">
                                            <div class="row">
                                                <div class="col-md-1 items_pre">
                                                    <div class="form-group">
                                                        <label for="items" class="d-block mb-0">Items</label>
                                                        <input type="text" id="items" name="items[]" class="form-control" value="1" readonly>
                                                        <input type="hidden" id="item_data" name="item_data">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="producto" class="d-block mb-0">Producto</label>
                                                        <select id="producto" name="producto[]" class="form-control">
                                                            <option value="">Seleccione un Producto</option>
                                                            <?php
                                                            $query_producto = $pdo->prepare('SELECT id_producto, tipo_producto FROM t_productos WHERE tipo_producto IS NOT NULL AND tipo_producto != "" AND habilitar = "1" ORDER BY tipo_producto ASC');
                                                            $query_producto->execute();
                                                            $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($productos as $producto) {
                                                                echo '<option value="' . $producto['id_producto'] . '">' . $producto['tipo_producto'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="entrada_md" class="d-block mb-0">Cantidad</label>
                                                        <input type="number" id="entrada_md" name="entrada_md[]" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- MODULO -->

                                            <div class="row">                                               
                                                <div class="col-md-2 items_pre campo Modulo">
                                                    <div class="form-group">
                                                        <label for="uso">USO</label>
                                                        <select id="uso" name="uso[]" class="form-control">
                                                            <option value=""></option>
                                                                <?php
                                                                $query_solicitante = $pdo->prepare('SELECT id_uso, producto_uso FROM t_uso_productos WHERE producto_uso IS NOT NULL AND producto_uso != "" AND categoria_productos = "1" ORDER BY producto_uso ASC');
                                                                $query_solicitante->execute();
                                                            $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($solicitantes as $solicitud) {
                                                                echo '<option value="' . $solicitud['id_uso'] . '">' . $solicitud['producto_uso'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 items_pre campo Modulo">
                                                    <div class="form-group">
                                                        <label for="modelo">Categoría:</label>
                                                        <select id="modelo" name="modelo[]" class="form-control">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>                                                        
                                                </div>
                                                <div class="col-md-2 items_pre campo Modulo">
                                                    <div class="form-group">
                                                        <label for="pitch">Pitch</label>
                                                        <select id="pitch" name="pitch[]" class="form-control pitch">
                                                            <option value=""></option>
                                                            <?php 
                                                            $query_pitch = $pdo->prepare('SELECT DISTINCT
                                                                                                        pmc.pitch, 
                                                                                                        tp.pitch AS pitch_nombre
                                                                                                    FROM
                                                                                                        producto_modulo_creado AS pmc
                                                                                                    INNER JOIN
                                                                                                        tabla_pitch AS tp ON pmc.pitch = tp.id
                                                                                                    ORDER BY
                                                                                                        tp.pitch ASC
                                                                                                    ');
                                                            $query_pitch->execute();
                                                            $pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($pitches as $pitch): ?>
                                                            <option value="<?php echo $pitch['id']; ?>">
                                                                <?php echo $pitch['pitch']; ?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2 items_pre campo Modulo">
                                                    <div class="form-group">
                                                        <label for="x_mm">X mm:</label>
                                                        <select id="x_mm" name="x_mm[]" class="form-control x_mm">
                                                            <option value=""></option>
                                                                <?php
                                                                $query_solicitante = $pdo->prepare("SELECT DISTINCT tamano_x FROM tabla_tamanos_modulos WHERE tamano_x IS NOT NULL AND tamano_x <> '' AND habilitar_tamano = '1' ORDER BY tamano_x ASC;");
                                                                $query_solicitante->execute();
                                                            $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($solicitantes as $solicitud) {
                                                                echo '<option value="' . $solicitud['id'] . '">' . $solicitud['tamano_x'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>                                                            
                                                </div>
                                                <div class="col-md-2 items_pre campo Modulo">
                                                    <div class="form-group">
                                                        <label for="y_mm">Y mm:</label>
                                                        <select id="y_mm" name="y_mm[]" class="form-control y_mm">
                                                        <option value=""></option>
                                                            <?php
                                                            $query_solicitante = $pdo->prepare("SELECT DISTINCT tamano_y FROM tabla_tamanos_modulos WHERE tamano_y IS NOT NULL AND tamano_y <> '' AND habilitar_tamano = '1' ORDER BY tamano_y ASC;");
                                                            $query_solicitante->execute();
                                                            $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($solicitantes as $solicitud) {
                                                                echo '<option value="' . $solicitud['id'] . '">' . $solicitud['tamano_y'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 items_pre campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="resol_x">Resol. X:</label>
                                                                    <input type="text" id="resol_x" name="resol_x[]" class="form-control resol_x" readonly>
                                                                </div>                                                        
                                                </div>
                                                <div class="col-md-3 items_pre campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="resol_y">Resol. Y:</label>
                                                                    <input type="text" id="resol_y" name="resol_y[]" class="form-control resol_y" readonly>
                                                                </div>
                                                </div>
                                                <div class="col-md-2 items_pre campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="pixel_modulo">Pixel Módulo:</label>
                                                                    <input type="text" id="pixel_modulo" name="pixel_modulo[]" class="form-control pixel_modulo" readonly>
                                                                </div>
                                                </div>
                                            </div>

                                            <!-- CONTROLADORA -->

                                            <div class="row">
                                                <div class="col-md-6 items_pre campo Control">
                                                    <div class="form-group">
                                                        <label for="marca_control" class="d-block mb-0">Marca</label>
                                                        <select id="marca_control" name="marca_control[]" class="form-control" >
                                                            <option value=""></option>
                                                            <?php 
                                                            $query_marca_control = $pdo->prepare('SELECT id_car_ctrl, marca_control FROM caracteristicas_control WHERE marca_control IS NOT NULL AND marca_control != "" ORDER BY marca_control ASC');
                                                            $query_marca_control->execute();
                                                            $marcas_controles = $query_marca_control->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($marcas_controles as $marca_control): ?>
                                                            <option value="<?php echo $marca_control['id_car_ctrl']; ?>">
                                                                <?php echo $marca_control['marca_control']; ?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 items_pre campo Control">
                                                    <div class="form-group">
                                                        <label for="referencia_control35" class="d-block mb-0">Referencia</label>
                                                        <select id="referencia_control35" name="referencia_control35[]" class="form-control" >
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- FUENTE -->

                                            <div class="row">
                                                <div class="col-md-6 items_pre campo Fuente">
                                                        <div class="form-group">
                                                            <label for="marca_fuente" class="d-block mb-0">Marca</label>
                                                            <select id="marca_fuente" name="marca_fuente[]" class="form-control">
                                                                <option value=""></option>
                                                                <?php 
                                                                $query_modelo_fuente = $pdo->prepare('SELECT id_car_fuen, marca_fuente FROM caracteristicas_fuentes WHERE marca_fuente IS NOT NULL AND marca_fuente != ""  ORDER BY marca_fuente ASC');
                                                                $query_modelo_fuente->execute();
                                                                $modelos_fuentes = $query_modelo_fuente->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach ($modelos_fuentes as $modelo_fuente): ?>
                                                                <option value="<?php echo $modelo_fuente['id_car_fuen']; ?>">
                                                                    <?php echo $modelo_fuente['marca_fuente']; ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col-md-6 items_pre campo Fuente">
                                                        <div class="form-group">
                                                            <label for="modelo_fuente35" class="d-block mb-0">Modelo</label>
                                                            <select id="modelo_fuente35" name="modelo_fuente35[]" class="form-control">
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>

                                            <!-- LCD -->

                                            <div class="row">
                                                    <div class="col-md-6 items_pre campo LCD">
                                                        <div class="form-group">
                                                            <label for="marca_lcd" class="d-block mb-0">Marca</label>
                                                            <input type="text" id="marca_lcd" name="marca_lcd" class="form-control" placeholder="Marca">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 items_pre campo LCD">
                                                        <div class="form-group">
                                                            <label for="modelo_lcd" class="d-block mb-0">Modelo</label>
                                                            <input type="text" id="modelo_lcd" name="modelo_lcd" class="form-control" placeholder="Modelo">
                                                        </div>
                                                    </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 items_pre">
                                                    <div class="form-group">
                                                        <label for="justificacion" class="d-block mb-0">Observaciones</label>
                                                        <textarea id="justificacion" name="justificacion[]" class="form-control" rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- Botón para añadir item -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary btn-block" id="add_item">Añadir Item</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!-- Tabla donde se mostrarán los items añadidos -->
                                    <div class="table-responsive">
                                        <table id="table_items" class="table table-striped table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Categoría</th>
                                                    <th>Marca - Modelo / Referencia - Pitch</th>
                                                    <th>Pitch</th>                                                    
                                                    <th>Marca</th>
                                                    <th>Referencia</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Justificaión</th>
                                                    <th>Cantidad</th>
                                                    <th><center>Acciones</center></th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_body">
                                                <!-- Los items añadidos se mostrarán aquí -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <a href="<?php echo $URL."admin/administracion/tracking/tracking_col";?>" class="btn btn-default btn-block">Cancelar</a>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear Solicitud</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>

    <?php include('../../../../../layout/admin/parte2.php');?>


    <!-- Script para actualizar los campos según el producto seleccionado -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener y establecer la fecha actual (yyyy-mm-dd)
        var fechaInput = document.getElementById('fecha_ingreso');
        if (fechaInput) {
            fechaInput.value = new Date().toISOString().split('T')[0];
        }

        // Obtener y establecer la hora actual (hh:mm)
        var horaInput = document.getElementById('hora');
        if (horaInput) {
            var now = new Date();
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            horaInput.value = hours + ':' + minutes;
        }

        // Ocultar todos los campos al cargar la página
        var campos = document.querySelectorAll('.campo');
        campos.forEach(function(campo) {
            campo.style.display = 'none';
        });

        // Evento cuando cambia el producto
        var productoSelect = document.getElementById('producto');
        if (productoSelect) {
            productoSelect.addEventListener('change', actualizarCampos);
        }

        // Función para mostrar/ocultar campos según el producto seleccionado
        function actualizarCampos() {
            var producto = productoSelect.value.trim(); // No es necesario toLowerCase() si son números

            // Ocultar todos los campos
            campos.forEach(campo => campo.style.display = 'none');

            // Determinar qué mostrar usando switch
            switch (producto) {
                case "1":
                    mostrarCampos('Modulo');
                    break;
                case "2":
                    mostrarCampos('Control');
                    break;
                case "3":
                    mostrarCampos('Fuente');
                    break;
                case "4":
                    mostrarCampos('LCD');
                    break;
                case "5":
                    mostrarCampos('Accesorios');
                    break;
            }
        }

        function mostrarCampos(clase) {
            document.querySelectorAll('.' + clase).forEach(campo => {
                campo.style.display = 'block';
            });
        }
    });
    </script>

    <!-- Script para limpiar los campos del formulario -->
    <script>
    $(document).ready(function() {
        // Detectar cuando cambie el valor del campo 'producto'
        $('#producto').change(function() {
            limpiarCampos(); // Llama a la función que limpia los campos
        });

        // Función para limpiar todos los campos del formulario, excluyendo el campo 'producto'
        function limpiarCampos() {
            // Limpiar todos los inputs de texto, select y textarea, excepto el campo 'producto'
            $('input[type="text"]').not('#idUsuario, #items, #contador, #ano_mes, #codigo_generado, #fecha_oc, #origen').val('');  // Limpiar campos de texto excepto 'producto'
            $('input[type="number"]').val(''); // Limpiar campos numéricos
            $('input[type="file"]').val(''); // Limpiar campo de archivo
            $('select').not('#solicitante, #origen_cliente, #producto').val(''); // Limpiar selects excepto 'producto'
            $('textarea').val(''); // Limpiar textareas

            // También puedes vaciar los campos ocultos, si es necesario
            $('input[type="hidden"]').not('#contador, #idUsuario, #ano_mes').val('');

            // Si tienes algún campo específico que necesitas manejar aparte, puedes hacerlo aquí.
            $('#list').empty(); // Vaciar la lista de imágenes si es necesario
            $('#lista_seriales').not('#items').empty(); // Vaciar la tabla de seriales
            seriales = []; // Reiniciar la lista de seriales (si usas esa variable)
        }
    });

    document.getElementById('pitch').addEventListener('change', function() {
    var pitchId = this.value;

        // Limpiar el campo "campo_referencia" cuando cambie el pitch
        document.getElementById('campo_referencia').value = '';

    // Hacer una solicitud AJAX para obtener los registros filtrados
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get_serie_modulo.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Actualizar el contenido del campo serie_modulo
            document.getElementById('serie_modulo').innerHTML = xhr.responseText;

            // Agregar un evento para detectar cuando cambie la selección
            document.getElementById('serie_modulo').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var selectedId = selectedOption.value; // Obtiene el "id" de la serie seleccionada

                // Asignar el valor del "id" al campo id_serie_modulo
                document.getElementById('id_serie_modulo').value = selectedId;
            });
        }
    };
    xhr.send('pitch_id=' + pitchId);
    });


    document.getElementById('marca_control').addEventListener('change', function() {
        var marcaControlValue = this.value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_referencia_control.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('referencia_control35').innerHTML = xhr.responseText;
            }
        };
        xhr.send('marca_control=' + marcaControlValue);
    });

    document.getElementById('marca_fuente').addEventListener('change', function() {
        var marcaFuenteValue = this.value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_modelo_fuente.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('modelo_fuente35').innerHTML = xhr.responseText;
            }
        };
        xhr.send('marca_fuente=' + marcaFuenteValue);
    });
    </script>

    <!-- Función para generar Contador de Entrada -->
    <script>
        $(document).ready(function() {
            $('#solicitante').on('change', function() {
                let solicitante = $(this).val();
                let $codigoGenerado = $('#codigo_generado');
                let $contador = $('#contador');
                let $anoMes = $('#ano_mes'); // Nuevo campo para ano_mes

                if (solicitante) {
                    $codigoGenerado.prop('disabled', true).val('Generando...');
                    $contador.prop('disabled', true).val('...');
                    $anoMes.prop('disabled', true).val('...'); // Bloquear y mostrar mensaje temporal

                    $.ajax({
                        url: 'generar_codigo.php',
                        type: 'POST',
                        data: { solicitante: solicitante },
                        dataType: 'json', // Esperar respuesta en JSON
                        success: function(response) {
                            if (response.error) {
                                alert(response.error);
                                $codigoGenerado.val('').prop('disabled', false);
                                $contador.val('').prop('disabled', false);
                                $anoMes.val('').prop('disabled', false);
                            } else {
                                $codigoGenerado.val(response.codigo).prop('disabled', false);
                                $contador.val(response.contador).prop('disabled', false);
                                $anoMes.val(response.ano_mes).prop('disabled', false); // Mostrar el ano_mes
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error en AJAX:", status, error);
                            alert("Error al generar el código.");
                            $codigoGenerado.val('').prop('disabled', false);
                            $contador.val('').prop('disabled', false);
                            $anoMes.val('').prop('disabled', false);
                        }
                    });
                } else {
                    $codigoGenerado.val('');
                    $contador.val('');
                    $anoMes.val('');
                }
            });
        });
    </script>

    <!-- Función para obtener modelos Módulos -->
    <script> 
    $(document).ready(function() {
        // Cuando cambia el campo "uso", carga los modelos filtrados
        $('#uso').change(function() {
            var uso = $(this).val();
            console.log("Uso seleccionado:", uso); // <-- Verificar qué se está enviando

            if (uso !== "") {
                $.ajax({
                    url: 'get_modelos.php',  // Archivo PHP que obtiene los modelos
                    type: 'POST',
                    data: { uso: uso },
                    success: function(response) {
                        $('#modelo').html(response);
                        $('#pitch').html('<option value=""></option>'); // Limpiar pitch
                    },
                    error: function() {
                        alert("Error al obtener modelos.");
                    }
                });
            } else {
                $('#modelo').html('<option value=""></option>');
                $('#pitch').html('<option value=""></option>');
            }
        });

        // Cuando cambia el campo "modelo", carga los pitch filtrados
        $('#modelo').change(function() {
            var modelo = $(this).val();

            if (modelo !== "") {
                $.ajax({
                    url: 'get_pitch.php',  // Archivo PHP que obtiene los pitch
                    type: 'POST',
                    data: { modelo: modelo },
                    success: function(response) {
                        $('#pitch').html(response);
                    },
                    error: function() {
                        alert("Error al obtener pitch.");
                    }
                });
            } else {
                $('#pitch').html('<option value=""></option>');
            }
        });
    });
    </script>

    <!-- Función para calcular Pixeles -->
    <script>
        $(document).ready(function () {
            function calcularResolucion() {
                console.log("Ejecutando cálculo...");

                // Obtener valores correctos desde el texto del option seleccionado
                let pitch = parseFloat($(".pitch option:selected").text()) || 0;
                let x_mm = parseFloat($(".x_mm option:selected").text()) || 0;
                let y_mm = parseFloat($(".y_mm option:selected").text()) || 0;

                console.log("Pitch:", pitch, "X mm:", x_mm, "Y mm:", y_mm);

                if (pitch > 0 && x_mm > 0 && y_mm > 0) {
                    let resol_x = x_mm / pitch;
                    let resol_y = y_mm / pitch;
                    let pixel_modulo = Math.round(resol_x * resol_y); // 🔹 Redondear aquí

                    $(".resol_x").val(resol_x.toFixed(2));
                    $(".resol_y").val(resol_y.toFixed(2));
                    $(".pixel_modulo").val(pixel_modulo); // 🔹 Mostrar sin decimales

                    console.log("Resol. X:", resol_x, "Resol. Y:", resol_y, "Pixel Módulo (redondeado):", pixel_modulo);
                } else {
                    $(".resol_x, .resol_y, .pixel_modulo").val("");
                    console.log("Datos incompletos, limpiando campos...");
                }
            }

            // Detectar cambios en los selects dinámicos
            $(document).on("change", ".pitch, .x_mm, .y_mm", calcularResolucion);
        });

    </script>

    <!-- Script para añadir y eliminar items en la tabla -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var tableBody = document.getElementById("table_body");
        var addItemButton = document.getElementById("add_item");
        var clearButton = document.getElementById("clear_items");
        var itemField = document.getElementById("items"); // CORREGIDO: Selección por ID
        var itemNumber = 1;

        if (addItemButton) {
            addItemButton.addEventListener("click", function () {
                agregarFila();
                limpiarCampos();
            });
        }

        if (clearButton) {
            clearButton.addEventListener("click", function () {
                tableBody.innerHTML = ""; 
                itemNumber = 1;
                actualizarItemField();
            });
        }

        function agregarFila() {
            // Obtener nombres de los inputs y selects, asegurando que si están vacíos, sean ""
            const cantidadEntradaMd = document.querySelector('input[name="entrada_md[]"]').value || "";
            const producto = document.querySelector('select[name="producto[]"] option:checked')?.text || "";
            const uso = document.querySelector('select[name="uso[]"] option:checked')?.text || "";
            const modelo = document.querySelector('select[name="modelo[]"] option:checked')?.text || "";
            const pitch = document.querySelector('select[name="pitch[]"] option:checked')?.text || "";
            const x_mm = document.querySelector('select[name="x_mm[]"] option:checked')?.text || "";
            const y_mm = document.querySelector('select[name="y_mm[]"] option:checked')?.text || "";
            const marcaControl = document.querySelector('select[name="marca_control[]"] option:checked')?.text || "";
            const referenciaControl35 = document.querySelector('select[name="referencia_control35[]"] option:checked')?.text || "";
            const marcaFuente = document.querySelector('select[name="marca_fuente[]"] option:checked')?.text || "";
            const modeloFuente35 = document.querySelector('select[name="modelo_fuente35[]"] option:checked')?.text || "";
            const justificacion = document.querySelector('textarea[name="justificacion[]"]').value || "";

            // Obtener id de los inputs y selects, asegurando que si están vacíos, sean ""
            const productoId = document.querySelector('select[name="producto[]"] option:checked')?.value || "";
            const usoId = document.querySelector('select[name="uso[]"] option:checked')?.value || "";
            const modeloId = document.querySelector('select[name="modelo[]"] option:checked')?.value || "";
            const pitchId = document.querySelector('select[name="pitch[]"] option:checked')?.value || "";
            const x_mmId = document.querySelector('select[name="x_mm[]"] option:checked')?.value || "";
            const y_mmId = document.querySelector('select[name="y_mm[]"] option:checked')?.value || "";
            const resol_xId = document.querySelector('input[name="resol_x[]"]')?.value || "";
            const resol_yId = document.querySelector('input[name="resol_y[]"]')?.value || "";
            const pixel_moduloId = document.querySelector('input[name="pixel_modulo[]"]')?.value || "";
            const marcaControlId = document.querySelector('select[name="marca_control[]"] option:checked')?.value || "";
            const referenciaControl35Id = document.querySelector('select[name="referencia_control35[]"] option:checked')?.value || "";
            const marcaFuenteId = document.querySelector('select[name="marca_fuente[]"] option:checked')?.value || "";
            const modeloFuente35Id = document.querySelector('select[name="modelo_fuente35[]"] option:checked')?.value || "";

            // Determinar el valor de "Modelo/Nombre"
            let modeloNombre = "N/A"; // Valor por defecto
            if (modelo && pitch && modelo !== "Seleccione una Categoría") {
                modeloNombre = `${modelo} / ${pitch}`;
            } else if (marcaControl && referenciaControl35 && marcaControl !== "Seleccione una Categoría") {
                modeloNombre = `${marcaControl} / ${referenciaControl35}`;
            } else if (marcaFuente && modeloFuente35 && marcaFuente !== "Seleccione una Categoría") {
                modeloNombre = `${marcaFuente} / ${modeloFuente35}`;
            }

            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>${itemNumber}</td>  
                <td>${producto}</td>
                <td>${modeloNombre}</td>
                <td>${pitch}</td>            
                <td>${marcaControl}</td>
                <td>${referenciaControl35}</td>
                <td>${marcaFuente}</td>
                <td>${modeloFuente35}</td>
                <td>${justificacion}</td>
                <td>${cantidadEntradaMd}</td>
                <td>
                    <input type="hidden" name="uso_id[]" value="${usoId}">
                    <input type="hidden" name="modelo_id[]" value="${modeloId}">
                    <input type="hidden" name="pitch_id[]" value="${pitchId}">
                    <input type="hidden" name="x_mm_id[]" value="${x_mmId}">
                    <input type="hidden" name="y_mm_id[]" value="${y_mmId}">
                    <input type="hidden" name="resol_x_id[]" value="${resol_xId}">
                    <input type="hidden" name="resol_y_id[]" value="${resol_yId}">
                    <input type="hidden" name="pixel_modulo_id[]" value="${pixel_moduloId}">
                    <input type="hidden" name="marca_control_id[]" value="${marcaControlId}">
                    <input type="hidden" name="referencia_control35_id[]" value="${referenciaControl35Id}">
                    <input type="hidden" name="marca_fuente_id[]" value="${marcaFuenteId}">
                    <input type="hidden" name="modelo_fuente35_id[]" value="${modeloFuente35Id}">
                    <input type="hidden" name="cantidad_entrada_md[]" value="${cantidadEntradaMd}">
                    <input type="hidden" name="justificacion[]" value="${justificacion}">
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>
                </td>
            `;
            tableBody.appendChild(newRow);
            itemNumber++;
            actualizarItemField();
        }

        function limpiarCampos() {
    document.querySelectorAll('input:not(#idUsuario, #items, #contador, #ano_mes, #codigo_generado, #fecha_oc, #origen, #fecha_ingreso), select:not(#solicitante, #origen_cliente), textarea:not(#textarea_excluido)').forEach(el => el.value = '');
}


        window.eliminarFila = function (btn) {
            btn.closest("tr").remove();
            actualizarNumeracion();
        };

        function actualizarNumeracion() {
            let count = 1;
            document.querySelectorAll("#table_body tr").forEach((row) => {
                row.cells[0].textContent = count++;
            });
            itemNumber = count;
            actualizarItemField();
        }

        function actualizarItemField() {
            if (itemField) {
                itemField.value = itemNumber; // Se actualiza con la cantidad de ítems en la tabla
            }
        }

    document.getElementById('formulario_creacion_producto').addEventListener('submit', function () {
    const rows = document.querySelectorAll('#table_body tr');
    const itemData = [];

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const rowData = {
            item: cells[0].innerText,
            producto: cells[1].innerText,
            modeloNombre: cells[2].innerText,
            pitch: cells[3].innerText,
            marca_control: cells[4].innerText,
            referencia_control35: cells[5].innerText,
            marca_fuente: cells[6].innerText,
            modelo_fuente35: cells[7].innerText,
            justificacion: cells[8].innerText,
            cantidad_entrada_md: cells[9].innerText,
            uso_id: row.querySelector('input[name="uso_id[]"]').value,
            modelo_id: row.querySelector('input[name="modelo_id[]"]').value,
            x_mm_id: row.querySelector('input[name="x_mm_id[]"]').value,
            y_mm_id: row.querySelector('input[name="y_mm_id[]"]').value,
            resol_x_id: row.querySelector('input[name="resol_x_id[]"]').value,
            resol_y_id: row.querySelector('input[name="resol_y_id[]"]').value,
            pixel_modulo_id: row.querySelector('input[name="pixel_modulo_id[]"]').value,
            marca_control_id: row.querySelector('input[name="marca_control_id[]"]').value,
            referencia_control35_id: row.querySelector('input[name="referencia_control35_id[]"]').value,
            marca_fuente_id: row.querySelector('input[name="marca_fuente_id[]"]').value,
            modelo_fuente35_id: row.querySelector('input[name="modelo_fuente35_id[]"]').value
        };
        itemData.push(rowData);
    });

    document.getElementById('item_data').value = JSON.stringify(itemData);
});

    });
    </script>