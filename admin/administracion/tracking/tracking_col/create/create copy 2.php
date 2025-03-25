<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

include('../../../../../layout/admin/parte1.php');

    // Consulta para obtener módulos sin referencia
    $query_referencia = $pdo->prepare('SELECT pmc.*, pmc.id, pmc.serie, ttm.tamanos_modulos as nombre_tamano FROM producto_modulo_creado as pmc LEFT JOIN tabla_tamanos_modulos AS ttm ON pmc.tamano = ttm.id WHERE referencia IS NULL');
    $query_referencia->execute();
    
    // Obtener los módulos sin referencia
    $modulosSinReferencia = $query_referencia->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Solicitud Mercancia a China</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                        <div class="card card-blue w_auto">
                            <div class="card-header">
                                Introduzca la información correspondiente
                            </div>
                        
                            <div class="card-body">
                                <form action="controller_create.php" method="POST" id="formulario_creacion_producto" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="fecha">Fecha</label>
                                                                <input type="date" id="fecha" name="fecha" class="form-control" readonly>
                                                                <input type="hidden" id="ano_mes" name="ano_mes" class="form-control" value="<?= date('Ym'); ?>">
                                                                <input type="hidden" id="id_usuario" name="id_usuario" class="form-control" value="<?= $sesion_usuario['id']; ?>">
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
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="codigo_generado">Contador de Entrada</label>
                                                                <input type="text" id="codigo_generado" name="codigo_generado" class="form-control" required readonly>
                                                                <input type="hidden" id="contador" name="contador" class="form-control" value="<?php ?>">
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

                                        <div class="col-md-7">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group cloned-section">
                                                        <!-- PRODUCTO -->
                                                        <div class="row">
                                                            <div class="col-md-1 items_pre">
                                                                <div class="form-group">
                                                                    <label for="items">Items</label>
                                                                    <input type="text" id="items" name="items[]" class="form-control" value="1" readonly>
                                                                    <input type="hidden" id="item_data" name="item_data">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 items_pre">
                                                                <div class="form-group">
                                                                    <label for="producto1">Producto</label>
                                                                    <select id="producto1" name="producto1[]" class="form-control">
                                                                        <option value="">Seleccina un producto</option>
                                                                            <?php
                                                                            $query_solicitante = $pdo->prepare('SELECT id_producto, tipo_producto FROM t_productos WHERE tipo_producto IS NOT NULL AND tipo_producto != "" AND habilitar = "1" ORDER BY tipo_producto ASC');
                                                                            $query_solicitante->execute();
                                                                        $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach($solicitantes as $solicitud) {
                                                                            echo '<option value="' . $solicitud['id_producto'] . '">' . $solicitud['tipo_producto'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 items_pre">
                                                                <div class="form-group">
                                                                    <label for="cantidad">Cantidad</label>
                                                                    <input type="number" id="cantidad" name="cantidad[]" class="form-control">
                                                                </div>
                                                            </div>
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
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- MODULOS -->
                                                        <div class="row">
                                                            <div class="col-md-2 items_pre campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="x_mm">X mm:</label>
                                                                    <select id="x_mm" name="x_mm[]" class="form-control x_mm">
                                                                        <option value=""></option>
                                                                            <?php
                                                                            $query_solicitante = $pdo->prepare("SELECT DISTINCT
                                                                                                                        tamano_x 
                                                                                                                    FROM
                                                                                                                        tabla_tamanos_modulos 
                                                                                                                    WHERE
                                                                                                                        tamano_x IS NOT NULL 
                                                                                                                    AND
                                                                                                                        tamano_x <> ''
                                                                                                                    AND
                                                                                                                        habilitar_tamano = '1' 
                                                                                                                    ORDER BY
                                                                                                                        tamano_x ASC;
                                                                                                                ");
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
                                                                            $query_solicitante = $pdo->prepare("SELECT DISTINCT
                                                                                                                        tamano_y 
                                                                                                                    FROM
                                                                                                                        tabla_tamanos_modulos 
                                                                                                                    WHERE
                                                                                                                        tamano_y IS NOT NULL 
                                                                                                                    AND
                                                                                                                        tamano_y <> ''
                                                                                                                    AND
                                                                                                                        habilitar_tamano = '1' 
                                                                                                                    ORDER BY
                                                                                                                        tamano_y ASC;
                                                                                                                ");
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
                                                                    <select id="marca_control" name="marca_control[]" class="form-control">
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

                                                        <!-- OBSERVACIÓN -->
                                                        <div class="row">
                                                            <div class="col-md-12 items_pre">
                                                                <div class="form-group">
                                                                    <label for="notas">Notas & Observaciones:</label>
                                                                    <textarea id="notas" name="notas[]" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <!-- BOTÓN -->
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
                                                                <th>Fecha</th>
                                                                <th>Producto</th>
                                                                <th>Marca o Categoría / Modelo o Pitch</th>
                                                                <th>Observaciones</th>
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
                                                <a href="<?php echo $URL."admin/administracion/tracking/tracking_col/";?>" class="btn btn-default btn-block">Cancelar</a>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear Movimiento</button>
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

    <script>
        // Obtener la fecha actual en el formato yyyy-mm-dd
        var today = new Date().toISOString().split('T')[0];
        // Establecer el valor del campo de fecha
        document.getElementById('fecha').value = today;

        document.addEventListener('DOMContentLoaded', function() {
            // Ocultar todos los campos al cargar la página
            var campos = document.querySelectorAll('.campo');
            campos.forEach(function(campo) {
                campo.style.display = 'none';
            });

            // Llamar a la función cuando el campo de producto cambia
            document.getElementById('producto1').addEventListener('change', function() {
                actualizarCampos();
            });

            // Función para mostrar/ocultar campos según el producto seleccionado
            function actualizarCampos() {
                var producto = document.getElementById('producto1').value.toLowerCase().trim();
                var campos = document.querySelectorAll('.campo');
                
                // Ocultar todos los campos
                campos.forEach(function(campo) {
                    campo.style.display = 'none';
                });

                // Mostrar campos según el producto seleccionado
                if (producto === "1") {
                    mostrarCampos('Modulo');
                } else if (producto === "2") {
                    mostrarCampos('Control');
                } else if (producto === "3") {
                    mostrarCampos('Fuente');
                } else if (producto === "4") {
                    mostrarCampos('LCD');
                } else if (producto === "5") {
                    mostrarCampos('Accesorios');
                }
            }

            function mostrarCampos(clase) {
                var campos = document.querySelectorAll('.' + clase);
                campos.forEach(function(campo) {
                    campo.style.display = 'block';
                });
            }
        });
    </script>

    <script>
    $(document).ready(function() {
        // Detectar cuando cambie el valor del campo 'producto'
        $('#producto1').change(function() {
            limpiarCampos(); // Llama a la función que limpia los campos
        });

    // Función para limpiar todos los campos del formulario, excluyendo el campo 'producto' y 'fecha'
    function limpiarCampos() {
        // Guardar el valor del campo 'fecha'
        var fechaValor = $('#fecha').val();

        // Limpiar todos los inputs de texto, número y archivo, excluyendo 'fecha'
        $('input[type="text"], input[type="number"], input[type="file"]').not('#codigo_generado, #items, #contador_entra, #origen, #ano_mes, #solicitante, #fecha_oc').prop('value', '');

        // Limpiar selects, excluyendo 'producto1' y 'solicitante'
        $('select').not('#producto1, #solicitante, #origen_cliente').prop('selectedIndex', 0);

        // Limpiar textareas
        $('textarea').prop('value', '');

        // Limpiar campos ocultos si es necesario
        $('input[type="hidden"]').not('#ano_mes, #id_usuario, #contador').prop('value', '');

        // Limpiar listas específicas
        $('#list').empty(); 
        $('#lista_seriales').not('#items').empty(); 
        seriales = []; // Reiniciar la lista de seriales

        // Restaurar el valor del campo 'fecha' después de limpiar
        $('#fecha').prop('value', fechaValor);
    }

    });

    document.getElementById('pitch').addEventListener('change', function() {
    var pitchId = this.value;

        // Limpiar el campo "campo_referencia" cuando cambie el pitch
        document.getElementById('campo_referencia').value = '';
        console.log("Pitch seleccionado:", pitchId); // <--- Verificar qué ID se está enviando


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

    <script>
        document.getElementById('serie_modulo').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];

            // Obtener el valor de referencia desde el atributo 'data-referencia' del option seleccionado
            var referencia = selectedOption.getAttribute('data-referencia');
            var serie = selectedOption.textContent.split(' / ')[0]; // Extraer solo la parte de la serie, antes del "/"

            // Puedes usar estos valores para actualizar otros campos o realizar otras acciones
            console.log('Serie:', serie);  // El valor de serie
            console.log('Referencia:', referencia);  // El valor de referencia

            // Si deseas enviar ambos valores a través de un campo oculto o similar
            document.getElementById('campo_serie').value = serie;  // Asignar serie a un campo oculto (ejemplo)
            document.getElementById('campo_referencia').value = referencia;  // Asignar referencia a otro campo
        });

    </script>

    <script>
        $(document).ready(function() {
            $('#solicitante').on('change', function() {
                let solicitante = $(this).val();
                let $codigoGenerado = $('#codigo_generado');
                let $contador = $('#contador');

                if (solicitante) {
                    $codigoGenerado.prop('disabled', true).val('Generando...');
                    $contador.prop('disabled', true).val('...');

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
                            } else {
                                $codigoGenerado.val(response.codigo).prop('disabled', false);
                                $contador.val(response.contador).prop('disabled', false);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error en AJAX:", status, error);
                            alert("Error al generar el código.");
                            $codigoGenerado.val('').prop('disabled', false);
                            $contador.val('').prop('disabled', false);
                        }
                    });
                } else {
                    $codigoGenerado.val('');
                    $contador.val('');
                }
            });
        });
    </script>

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


    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const tableBody = document.getElementById("table_body");
        const addItemButton = document.getElementById("add_item");
        const clearButton = document.getElementById("clear_items");

        addItemButton.addEventListener("click", function () {
            agregarFila();
            limpiarCampos();
        });

        function agregarFila() {
    // Obtener la referencia al cuerpo de la tabla
    const tableBody = document.querySelector("#table_body");

    // Función para obtener valores de inputs, permitiendo valores vacíos
    function obtenerValor(selector) {
        const elemento = document.querySelector(selector);
        return elemento ? elemento.value.trim() : "";
    }

    // Función para obtener el texto visible de un select, permitiendo valores vacíos
    function obtenerTextoSelect(selector) {
        const select = document.querySelector(selector);
        return select && select.selectedIndex >= 0 ? select.options[select.selectedIndex].text.trim() : "";
    }

    // Obtener valores de los inputs y selects (sin importar si están vacíos)
    const fecha = obtenerValor('input[name="fecha"]');
    const cantidadEntradaMd = obtenerValor('input[name="cantidad[]"]') || "0";
    const smdEncapsulado = obtenerTextoSelect('select[name="smd_encapsulado[]"]');
    const resolX = obtenerTextoSelect('select[name="resol_x[]"]');
    const resolY = obtenerTextoSelect('select[name="resol_y[]"]');
    const pixelModulo = obtenerTextoSelect('select[name="pixel_modulo[]"]');

    const producto = obtenerTextoSelect('select[name="producto1[]"]');
    const marcaControl = obtenerTextoSelect('select[name="marca_control[]"]');
    const referenciaControl35 = obtenerTextoSelect('select[name="referencia_control35[]"]');
    const marcaFuente = obtenerTextoSelect('select[name="marca_fuente[]"]');
    const modeloFuente35 = obtenerTextoSelect('select[name="modelo_fuente35[]"]');
    const uso = obtenerTextoSelect('select[name="uso[]"]');
    const modelo = obtenerTextoSelect('select[name="modelo[]"]');
    const pitch = obtenerTextoSelect('select[name="pitch[]"]');
    const xMm = obtenerTextoSelect('select[name="x_mm[]"]');
    const yMm = obtenerTextoSelect('select[name="y_mm[]"]');
    const justificacion = obtenerValor('textarea[name="notas[]"]');

    // Determinar el valor de "Modelo/Nombre"
    let modeloNombre = "N/A"; // Valor por defecto
    if (modelo && pitch && modelo !== "Seleccione una Categoría") {
        modeloNombre = `${modelo} / ${pitch}`;
    } else if (marcaControl && referenciaControl35 && marcaControl !== "Seleccione una Categoría") {
        modeloNombre = `${marcaControl} / ${referenciaControl35}`;
    } else if (marcaFuente && modeloFuente35 && marcaFuente !== "Seleccione una Categoría") {
        modeloNombre = `${marcaFuente} / ${modeloFuente35}`;
    }

    // Crear una nueva fila y agregarla a la tabla
    const newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td></td> <!-- Se asignará el número correctamente -->
        <td>${fecha}</td>
        <td>${producto}</td>
        <td>${modeloNombre}</td>
        <td>${justificacion}</td>
        <td>${cantidadEntradaMd}</td>
        <td class="hidden-column">${pitch}<input type="hidden" name="pitch[]" value="${pitch}"></td>
        <td class="hidden-column">${modelo}<input type="hidden" name="modelo[]" value="${modelo}"></td>
        <td class="hidden-column">${marcaControl}<input type="hidden" name="marcaControl[]" value="${marcaControl}"></td>
        <td class="hidden-column">${referenciaControl35}<input type="hidden" name="referenciaControl35[]" value="${referenciaControl35}"></td>
        <td class="hidden-column">${marcaFuente}<input type="hidden" name="marcaFuente[]" value="${marcaFuente}"></td>
        <td class="hidden-column">${modeloFuente35}<input type="hidden" name="modeloFuente35[]" value="${modeloFuente35}"></td>
        <td class="hidden-column">${smdEncapsulado}<input type="hidden" name="smd_encapsulado[]" value="${smdEncapsulado}"></td>
        <td class="hidden-column">${xMm}<input type="hidden" name="xMm[]" value="${xMm}"></td>
        <td class="hidden-column">${yMm}<input type="hidden" name="yMm[]" value="${yMm}"></td>
        <td class="hidden-column">${resolX}<input type="hidden" name="resolX[]" value="${resolX}"></td>
        <td class="hidden-column">${resolY}<input type="hidden" name="resolY[]" value="${resolY}"></td>
        <td class="hidden-column">${pixelModulo}<input type="hidden" name="pixelModulo[]" value="${pixelModulo}"></td>
        <td class="hidden-column">${uso}<input type="hidden" name="uso[]" value="${uso}"></td>
        <td>
            <center>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>
            </center>
        </td>
    `;

    // Agregar la fila a la tabla
    if (tableBody) {
        tableBody.appendChild(newRow);
        actualizarNumeracion();
        limpiarCampos();
    } else {
        console.error("Error: No se encontró el tbody de la tabla.");
    }
}


        function actualizarNumeracion() {
            document.querySelectorAll("#table_body tr").forEach((row, index) => {
                row.cells[0].textContent = index + 1;
            });
        }

        function limpiarCampos() {
            const inputs = document.querySelectorAll('input[name="cantidad[]"], input[name="resol_x[]"], input[name="resol_y[]"], input[name="pixel_modulo[]"], input[name="estandar_magnet[]"], input[name="referencia_cable[]"], input[name="referencia_alimentacion[]"], input[name="consumo_watts[]"], input[name="num_mod_5v60a[]"], input[name="num_mod_5v40a[]"], input[name="corriente_nationstar[]"], input[name="corriente_kinglight[]"], input[name="corriente_shinkong[]"], input[name="nits_brillo[]"], input[name="grupo_datos[]"], input[name="interface_hub[]"], input[name="smd_encapsulado[]"]');
            const selects = document.querySelectorAll('select[name="producto1[]"], select[name="pitch[]"], select[name="modelo[]"], select[name="marca_control[]"], select[name="referencia_control35[]"], select[name="marca_fuente[]"], select[name="modelo_fuente35[]"], select[name="x_mm[]"], select[name="uso[]"], select[name="y_mm[]"]');
            const textarea = document.querySelector('textarea[name="notas[]"]');

            inputs.forEach(input => input.value = '');
            selects.forEach(select => select.selectedIndex = 0);
            if (textarea) textarea.value = '';
        }

        window.eliminarFila = function (btn) {
            btn.closest("tr").remove();
            actualizarNumeracion();
        };

        // Guardar datos antes de enviar el formulario
        document.getElementById('formulario_creacion_producto').addEventListener('submit', function () {
            const rows = document.querySelectorAll('#table_body tr');
            const itemData = [];

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowData = {
                    item: cells[0].innerText,
                    fecha: cells[1].innerText,
                    producto: cells[2].innerText,
                    modelo_nombre: cells[3].innerText,
                    justificacion: cells[4].innerText,
                    cantidad_entrada_md: cells[5].innerText,
                    pitch: row.querySelector('input[name="pitch[]"]').value,
                    modelo: row.querySelector('input[name="modelo[]"]').value,
                    marcaControl: row.querySelector('input[name="marcaControl[]"]').value,
                    referenciaControl35: row.querySelector('input[name="referenciaControl35[]"]').value,
                    marcaFuente: row.querySelector('input[name="marcaFuente[]"]').value,
                    modeloFuente35: row.querySelector('input[name="modeloFuente35[]"]').value,
                    smd_encapsulado: row.querySelector('input[name="smd_encapsulado[]"]').value,
                    xMm: row.querySelector('input[name="xMm[]"]').value,
                    yMm: row.querySelector('input[name="yMm[]"]').value,
                    resolX: row.querySelector('input[name="resolX[]"]').value,
                    resolY: row.querySelector('input[name="resolY[]"]').value,
                    pixelModulo: row.querySelector('input[name="pixelModulo[]"]').value,
                    uso: row.querySelector('input[name="uso[]"]').value
                };

                itemData.push(rowData);
            });

            document.getElementById('item_data').value = JSON.stringify(itemData);
        });

        // Limpiar tabla con botón "clear_items"
        if (clearButton) {
            clearButton.addEventListener("click", function () {
                tableBody.innerHTML = ""; // Borra todas las filas
                actualizarNumeracion(); // Se asegura de que el conteo de filas reinicie
            });
        }
    });
    </script>

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