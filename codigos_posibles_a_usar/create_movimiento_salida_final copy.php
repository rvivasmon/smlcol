<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Movimientos de Salida Almacén Principal</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create_final.php" method="POST">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" id="fecha" name="fecha" class="form-control" placeholder="Fecha" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="hora">Hora</label>
                                    <input type="time" id="hora" name="hora" class="form-control" placeholder="Hora" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="producto">Categoría</label>
                                    <select name="producto" id="producto" class="form-control" required>
                                        <option value="">Seleccione un Producto</option>
                                        <?php
                                        $query_producto = $pdo->prepare('SELECT id_producto, tipo_producto FROM t_productos WHERE habilitar = "1" ORDER BY tipo_producto ASC');
                                        $query_producto->execute();
                                        $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($productos as $producto) {
                                            echo '<option value="' . htmlspecialchars($producto['id_producto']) . '">' . htmlspecialchars($producto['tipo_producto']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-0">
                                <div class="form-group"> <!-- Se coloca aquí el id producto -->
                                    <input  class="form-control" id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h1 class="m-0">Validar Producto</h1>
                            </div>
                            <div class="col-md-0">
                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                    <input type="hidden" id="id_producto_categoria" name="id_producto_categoria">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                        <!-- MODULO -->

                                    <div class="row">
                                        <div class="col-md-11 campo Modulo">
                                            <div class="form-group">
                                                <label for="pitch">Pitch</label>
                                                <select id="pitch" name="pitch" class="form-control">
                                                    <option value="">Seleccione un pitch</option>
                                                    <?php 
                                                    $query_pitch = $pdo->prepare('SELECT DISTINCT pmc.pitch, tp.pitch AS pitch_nombre FROM producto_modulo_creado AS pmc INNER JOIN tabla_pitch AS tp ON pmc.pitch = tp.id ORDER BY tp.pitch ASC');
                                                    $query_pitch->execute();
                                                    $pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($pitches as $pitch): ?>
                                                    <option value="<?php echo $pitch['pitch']; ?>">
                                                        <?php echo $pitch['pitch_nombre']; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-11 campo Modulo">
                                            <div class="form-group">
                                                <label for="serie_modulo">Serie</label>
                                                <select id="serie_modulo" name="serie_modulo" class="form-control">
                                                    <option value="">Seleccione una Serie</option>
                                                    <!-- Las opciones se llenarán dinámicamente vía AJAX -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-0">
                                            <div class="form-group"> <!-- Se coloca aquí el id producto -->
                                                <input type="hidden" id="id_serie_modulo" name="id_serie_modulo">
                                            </div>
                                        </div>
                                        <div class="col-md-11 campo Modulo">
                                            <div class="form-group">
                                                <label for="referencia_modulo">Referencia</label>
                                                    <input type="text" id="campo_referencia" name="referencia" class="form-control" readonly>
                                                    <!-- Campos ocultos para almacenar los valores de serie y referencia -->
                                                    <input type="hidden" id="campo_serie" name="serie">
                                            </div>
                                        </div>
                                    </div>

                                        <!-- CONTROLADORA -->

                                    <div class="row">
                                        <div class="col-md-11 campo Control">
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
                                    </div>

                                    <div class="row">
                                        <div class="col-md-11 campo Control">
                                            <div class="form-group">
                                                <label for="referencia_control35">Referencia</label>
                                                <select id="referencia_control35" name="referencia_control35" class="form-control" >
                                                    <option value="">Seleccione una Referencia</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-0">
                                            <div class="form-group"> <!-- Se coloca aquí el id producto -->
                                                <input type="hidden" id="id_referencia_control" name="id_referencia_control">
                                            </div>
                                        </div>
                                    </div>

                                        <!-- FUENTE -->

                                    <div class="row">
                                        <div class="col-md-11 campo Fuente">
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
                                    </div>

                                    <div class="row">
                                        <div class="col-md-11 campo Fuente">
                                            <div class="form-group">
                                                <label for="modelo_fuente35">Modelo</label>
                                                <select name="modelo_fuente35" id="modelo_fuente35" class="form-control">
                                                    <option value="">Seleccione un Modelo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-0">
                                            <div class="form-group"> <!-- Se coloca aquí el id producto -->
                                                <input type="hidden" id="id_modelo_fuente" name="id_modelo_fuente">
                                            </div>
                                        </div>
                                    </div>

                                        <!-- LCD -->

                                    <div class="row">
                                        <div class="col-md-11 campo LCD">
                                            <div class="form-group">
                                                <label for="marca_lcd">Marca</label>
                                                <input type="text" id="marca_lcd" name="marca_lcd" class="form-control" placeholder="Marca">
                                            </div>
                                        </div>
                                        <div class="col-md-11 campo LCD">
                                            <div class="form-group">
                                                <label for="modelo_lcd">Modelo</label>
                                                <input type="text" id="modelo_lcd" name="modelo_lcd" class="form-control" placeholder="Modelo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ubicacion">Ubicación</label>
                                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="existencia">Existencia</label>
                                                <input type="text" class="form-control" id="existencia" name="existencia" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <!-- ALMACEN -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="entrada_md">Almacén Destino</label>
                                                <select name="almacen_entrada_md" id="almacen_entrada_md" class="form-control" required>
                                                    <option value="">Almacén Destino</option>
                                                    <?php
                                                    $query_almacen_entra = $pdo->prepare('SELECT * FROM t_asignar_todos_almacenes WHERE id_asignacion != 3 AND nombre_almacen != "Principal"');
                                                    $query_almacen_entra->execute();
                                                    $almacenes_entras = $query_almacen_entra->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($almacenes_entras as $almacen_entra) {
                                                        echo '<option value="' . $almacen_entra['id_asignacion'] . '">' . $almacen_entra['nombre_almacen'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input class="form-control" name="almacen_entrada_md_id" id="almacen_entrada_md_id" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="entrada_md">Cantidad de Salida</label>
                                                <input type="text" name="entrada_md" id="entrada_md" class="form-control" placeholder="Cantidad Entrada" required>
                                                <small id="errorEntrada" class="text-danger" style="display:none;">La Cantidad de Salida no puede superar la existencia</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7" hidden>
                                            <div class="form-group">
                                                <label for="salida_md">Almacén Salida</label>
                                                <select name="almacen_salida_md" id="almacen_salida_md" class="form-control" >
                                                    <option value="">Almacén Origen</option>
                                                    <?php 
                                                    $query_almacen  = $pdo->prepare('SELECT * FROM t_asignar_todos_almacenes');
                                                    $query_almacen->execute();
                                                    $almacenes = $query_almacen->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($almacenes as $almacen) {
                                                        $selected = ($almacen['id_asignacion'] == 3) ? 'selected' : '';
                                                        echo '<option value="' . $almacen['id_asignacion'] . '" ' . $selected . '>' . $almacen['nombre_almacen'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input class="form-control" name="almacen_salida_md_id" id="almacen_salida_md_id" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-3" hidden>
                                            <div class="form-group">
                                                <label for="salida_md">Salida</label>
                                                <input type="text" name="salida_md" class="form-control" placeholder="Cantidad Salida">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="op_destino">Asignar a:</label>
                                                <input type="text" name="op_destino" class="form-control" placeholder="Asignar" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="observacion">Observaciones</label>
                                                <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control" placeholder="Observaciones"></textarea>
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
                                    <a href="<?php echo $URL."admin/almacen/mv_diario/";?>" class="btn btn-default btn-block">Cancelar</a>
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

<?php include('../../../../layout/admin/parte2.php');?>

<script>
    // Obtener la fecha actual en el formato yyyy-mm-dd
    var today = new Date().toISOString().split('T')[0];
    // Establecer el valor del campo de fecha
    document.getElementById('fecha').value = today;

    // Obtener la hora actual en el formato hh:mm
    var now = new Date();
    var hours = String(now.getHours()).padStart(2, '0');
    var minutes = String(now.getMinutes()).padStart(2, '0');
    var currentTime = hours + ':' + minutes;
    document.getElementById('hora').value = currentTime;

    document.addEventListener('DOMContentLoaded', function() {
        // Ocultar todos los campos al cargar la página
        var campos = document.querySelectorAll('.campo');
        campos.forEach(function(campo) {
            campo.style.display = 'none';
        });

        // Llamar a la función cuando el campo de producto cambia
        document.getElementById('producto').addEventListener('change', function() {
            actualizarCampos();
        });

        // Función para mostrar/ocultar campos según el producto seleccionado
        function actualizarCampos() {
            var producto = document.getElementById('producto').value.toLowerCase().trim();
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

//visualizar los id de almacen
document.addEventListener('DOMContentLoaded', function() {
    const selectSalida = document.getElementById('almacen_salida_md');
    const salidaID = document.getElementById('almacen_salida_md_id');
    const selectEntrada = document.getElementById('almacen_entrada_md');
    const entradaID = document.getElementById('almacen_entrada_md_id');

    selectSalida.addEventListener('change', function() {
        salidaID.value = selectSalida.value;
    });

    selectEntrada.addEventListener('change', function() {
        entradaID.value = selectEntrada.value;
    });
});

document.addEventListener('DOMContentLoaded', function() {

    // Agregar funcionalidad para verificar si Almacén Origen y Almacén Destino son iguales
    const selectSalida = document.getElementById('almacen_salida_md');
    const selectEntrada = document.getElementById('almacen_entrada_md');

    function verificarAlmacenes() {
        if (selectSalida.value && selectEntrada.value && selectSalida.value === selectEntrada.value) {
            alert("El Almacén Origen y el Almacén Destino no pueden ser iguales. Por favor, seleccione almacenes diferentes.");
            selectEntrada.value = ''; // Vaciar el campo de Almacén Destino para obligar a seleccionar uno diferente
        }
    }

    selectSalida.addEventListener('change', verificarAlmacenes);
    selectEntrada.addEventListener('change', verificarAlmacenes);
});

document.addEventListener('DOMContentLoaded', function() {
    // Obtener referencias a los campos de entrada y salida
    const salidaMdInput = document.getElementsByName('salida_md')[0];
    const entradaMdInput = document.getElementsByName('entrada_md')[0];

    // Función para actualizar el campo salida_md
    function actualizarSalidaMd() {
        salidaMdInput.value = entradaMdInput.value; // Establecer el mismo valor que entrada_md
    }

    // Escuchar cambios en el campo entrada_md y llamar a la función actualizarSalidaMd
    entradaMdInput.addEventListener('input', actualizarSalidaMd);
});
</script>

<script>
$(document).ready(function() {
    // Limpiar campos cuando cambie el campo 'producto'
    $('#producto').change(function() {
        limpiarCampos(); // Llama a la función que limpia los campos
    });

    // Función para limpiar todos los campos del formulario, excluyendo el campo 'producto'
    function limpiarCampos() {
        $('input[type="text"]').not('#producto, #almacen_salida_md, #id_producto_categoria').val('');
        $('input[type="number"]').val('');
        $('input[type="file"]').val('');
        $('select').not('#producto, #almacen_salida_md').val('');
        $('textarea').val('');
        $('input[type="hidden"]').val('');
        $('#list').empty(); // Vaciar la lista de imágenes si es necesario
        $('#lista_seriales').empty(); // Vaciar la tabla de seriales
        seriales = []; // Reiniciar la lista de seriales
    }

    // Función común para manejar las solicitudes AJAX y actualizar selects
    function actualizarSelect(url, data, selectId, optionText) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                var selectElement = document.getElementById(selectId);
                selectElement.innerHTML = `<option value="">Seleccione ${optionText}</option>` + xhr.responseText;
            }
        };
        xhr.send(data);
    }

    // Detectar cambios en los campos de selección y actualizar los campos correspondientes
    $('#pitch').change(function() {
        var pitchValue = this.value;

        // Limpiar el campo "campo_referencia" cuando cambie el pitch
        document.getElementById('campo_referencia').value = '';

        actualizarSelect('get_serie_modulo.php', 'pitch=' + pitchValue, 'serie_modulo', 'una serie');
    });

    $('#marca_control').change(function() {
        var marcaControlValue = this.value;
        actualizarSelect('get_referencia_control.php', 'marca_control=' + encodeURIComponent(marcaControlValue), 'referencia_control35', 'una referencia');
    });

    $('#marca_fuente').change(function() {
        var marcaFuenteValue = this.value;
        actualizarSelect('get_modelo_fuente.php', 'marca_fuente=' + encodeURIComponent(marcaFuenteValue), 'modelo_fuente35', 'un modelo');
    });

    // Detectar cuando cambian los valores en los selects y asignar el valor al campo correspondiente
    function asignarValor(selectId, inputId) {
        document.getElementById(selectId).addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var selectedId = selectedOption.value;
            document.getElementById(inputId).value = selectedId;
        });
    }

    // Asignar valores a los campos 'id_serie_modulo', 'id_referencia_control', 'id_modelo_fuente'
    asignarValor('serie_modulo', 'id_serie_modulo');
    asignarValor('referencia_control35', 'id_referencia_control');
    asignarValor('modelo_fuente35', 'id_modelo_fuente');

    // Actualizar 'id_producto_categoria' cuando cambie 'producto'
    $('#producto').change(function() {
        var selectedOption = this.options[this.selectedIndex];
        var selectedId = selectedOption.value;
        console.log('ID seleccionado:', selectedId);
        $('#id_producto_categoria').val(selectedId);
    });
});
</script>

<script>
   $(document).ready(function () {
    // Escuchar cambios en los selects después de seleccionar el id_producto_categoria
    $('#serie_modulo, #referencia_control35, #modelo_fuente35').change(function () {
        var idProductoCategoria = $('#id_producto_categoria').val(); // Obtener id_producto_categoria
        var valorCampo = $(this).val(); // Obtener el valor del campo seleccionado
        var selectId = $(this).attr('id'); // Identificar cuál select se utilizó

        // Enviar la solicitud AJAX con los datos
        $.ajax({
            url: 'obtener_datos_alma_smartled.php', // Archivo PHP para procesar la solicitud
            method: 'POST',
            data: {
                id_producto_categoria: idProductoCategoria,
                valor_campo: valorCampo,
                select_id: selectId
            },
            success: function (response) {
                // Parsear la respuesta JSON
                var data = JSON.parse(response);

                if (data.error) {
                    alert(data.error); // Mostrar error si existe
                } else {
                    // Actualizar los campos del formulario
                    $('#ubicacion').val(data.posicion);
                    $('#existencia').val(data.cantidad_plena);
                }
            }
        });
    });
});
</script>

<script>
    document.getElementById('serie_modulo').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];

        // Limpiar el campo "campo_referencia" cuando cambie el pitch
        document.getElementById('ubicacion').value = '';
        document.getElementById('existencia').value = '';

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
    const entradaMd = document.getElementById('entrada_md');
    const existencia = document.getElementById('existencia');
    const errorEntrada = document.getElementById('errorEntrada');

    entradaMd.addEventListener('input', function() {
        if (parseInt(this.value) > parseInt(existencia.value)) {
            errorEntrada.style.display = 'block';
            this.value = ''; // Borra el valor si es inválido
        } else {
            errorEntrada.style.display = 'none';
        }
    });
</script>