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
                <div class="table-responsive">
                    <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                        <!-- Tabla con datos del movimiento general -->
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
                                <form action="controller_create_tracking.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="fecha">Fecha</label>
                                                                <input type="date" id="fecha" name="fecha" class="form-control" placeholder="Fecha" readonly>
                                                                <input type="hidden" id="ano_mes" name="ano_mes" class="form-control" value="<?= date('Ym'); ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="solicitante">Solicitante</label>
                                                                <select name="solicitante" id="solicitante" class="form-control" required>
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

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="codigo_generado">Contador de Entrada</label>
                                                                <input type="text" id="codigo_generado" name="codigo_generado" class="form-control" required readonly>
                                                                <input type="hidden" id="contador" name="contador" class="form-control" value="<?php ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="origen">Origen Solicitud</label>
                                                                <input type="text" id="origen" name="origen" class="form-control" placeholder="Origen" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="producto1">Tipo Producto</label>
                                                                <select name="producto1" id="producto1" class="form-control" required>
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

                                                        <div class="col-md-6 campo Modulo">
                                                            <div class="form-group">
                                                                <label for="uso">Uso</label>
                                                                <select name="uso" id="uso" class="form-control" required>
                                                                    <option value="">Seleccione un Producto</option>
                                                                    <?php
                                                                    $query_uso = $pdo->prepare('SELECT id_uso, producto_uso FROM t_uso_productos WHERE producto_uso IS NOT NULL AND producto_uso != "" AND categoria_productos = "1" ORDER BY producto_uso ASC');
                                                                    $query_uso->execute();
                                                                    $usos = $query_uso->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($usos as $uso) {
                                                                        echo '<option value="' . $uso['id_uso'] . '">' . $uso['producto_uso'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-0">
                                                            <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                                                <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']; ?>" hidden>
                                                            </div>
                                                        </div>
                                                    </div>

                                                        <!-- MODULO -->

                                                    <div class="row">
                                                        <div class="col-md-6 campo Modulo">
                                                            <div class="form-group">
                                                                <label for="modelo">Modelo Modulo</label>
                                                                <select id="modelo" name="modelo" class="form-control">
                                                                    <option value="">Seleccione un modelo</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 campo Modulo">
                                                            <div class="form-group">
                                                                <label for="pitch">Pitch</label>
                                                                <select id="pitch" name="pitch" class="form-control">
                                                                    <option value="">Seleccione un pitch</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 campo Modulo">
                                                            <div class="form-group">
                                                                <label for="serie_modulo">Serie</label>
                                                                <select id="serie_modulo" name="serie_modulo" class="form-control">
                                                                    <option value="">Seleccione una Serie</option>
                                                                    <!-- Las opciones se llenarán dinámicamente vía AJAX -->
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 campo Modulo">
                                                            <div class="form-group">
                                                                <label for="referencia_modulo">Referencia</label>
                                                                    <input type="text" id="referencia_modulo" name="referencia_modulo" class="form-control" readonly>
                                                                    <!-- Campos ocultos para almacenar los valores de serie y referencia -->
                                                                    <input type="hidden" id="campo_serie" name="serie">
                                                            </div>
                                                        </div>
                                                    </div>

                                                        <!-- CONTROLADORA -->

                                                    <div class="row">
                                                        <div class="col-md-6 campo Control">
                                                            <div class="form-group">
                                                                <label for="marca_control">Marca</label>
                                                                <select id="marca_control" name="marca_control" class="form-control" >
                                                                    <option value="">Seleccione una marca</option>
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

                                                        <div class="col-md-6 campo Control">
                                                            <div class="form-group">
                                                                <label for="referencia_control35">Referencia</label>
                                                                <select id="referencia_control35" name="referencia_control35" class="form-control" >
                                                                    <option value="">Seleccione una Referencia</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-0">
                                                        </div>
                                                    </div>

                                                        <!-- FUENTE -->

                                                    <div class="row">
                                                        <div class="col-md-6 campo Fuente">
                                                            <div class="form-group">
                                                                <label for="marca_fuente">Marca</label>
                                                                <select name="marca_fuente" id="marca_fuente" class="form-control">
                                                                    <option value="">Seleccione una Marca</option>
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

                                                        <div class="col-md-6 campo Fuente">
                                                            <div class="form-group">
                                                                <label for="modelo_fuente35">Modelo</label>
                                                                <select name="modelo_fuente35" id="modelo_fuente35" class="form-control">
                                                                    <option value="">Seleccione un Modelo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                        <!-- ALMACEN -->

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="cantidad">Cantidad</label>
                                                                            <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="Entrada" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="observacion">Observaciones</label>
                                                                <textarea name="observacion" id="observacion" cols="30" rows="11" class="form-control" placeholder="Observaciones"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <a href="<?php echo $URL."admin/administracion/tracking/tracking_col/index_tracking.php";?>" class="btn btn-default btn-block">Cancelar</a>
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
                    </table>
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

        // Función para limpiar todos los campos del formulario, excluyendo el campo 'producto'
        function limpiarCampos() {
            // Limpiar todos los inputs de texto, select y textarea, excepto el campo 'producto'
            $('input[type="text"]').not('#producto1, #codigo_generado, #contador_entra, #origen, #ano_mes').val('');  // Limpiar campos de texto excepto 'producto'
            $('input[type="number"]').val(''); // Limpiar campos numéricos
            $('input[type="file"]').val('');   // Limpiar campo de archivo
            $('select').not('#producto1, #solicitante').val(''); // Limpiar selects excepto 'producto'
            $('textarea').val('');             // Limpiar textareas

            // También puedes vaciar los campos ocultos, si es necesario
            $('input[type="hidden"]').val('');

            // Si tienes algún campo específico que necesitas manejar aparte, puedes hacerlo aquí.
            $('#list').empty(); // Vaciar la lista de imágenes si es necesario
            $('#lista_seriales').empty(); // Vaciar la tabla de seriales
            seriales = []; // Reiniciar la lista de seriales (si usas esa variable)
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
        $('#solicitante').change(function() {
            var solicitante = $(this).val(); // Obtener el solicitante seleccionado

            if (solicitante !== "") {
                $.ajax({
                    url: 'generar_codigo.php',  // Archivo PHP que genera el código
                    type: 'POST',
                    data: { solicitante: solicitante },
                    success: function(response) {
                        $('#codigo_generado').val(response); // Mostrar código en el input
                    },
                    error: function() {
                        alert("Error al generar el código.");
                    }
                });
            } else {
                $('#codigo_generado').val(''); // Limpiar si no hay solicitante seleccionado
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
                    $('#pitch').html('<option value="">Seleccione un pitch</option>'); // Limpiar pitch
                },
                error: function() {
                    alert("Error al obtener modelos.");
                }
            });
        } else {
            $('#modelo').html('<option value="">Seleccione un modelo</option>');
            $('#pitch').html('<option value="">Seleccione un pitch</option>');
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
            $('#pitch').html('<option value="">Seleccione un pitch</option>');
        }
    });
});
</script>
