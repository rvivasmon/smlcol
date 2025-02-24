<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

include('../../../../../layout/admin/parte1.php');


// Obtener el último contador desde la base de datos
$query = $pdo->prepare('SELECT consecu_sale FROM movimiento_diario ORDER BY consecu_sale DESC LIMIT 1');
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $ultimoContador = $resultado['consecu_sale']; // Obtén el último valor del contador
} else {
    $ultimoContador = 0; // Si no existe, inicialízalo en 0
}

// Incrementar el contador en 1
$nuevoContador = $ultimoContador + 1;

// Formatear el contador con ceros a la izquierda (4 dígitos)
$contadorFormateado = str_pad($nuevoContador, 4, '0', STR_PAD_LEFT);

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Movimientos de Salida Almacén Principal</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
                <div class="card card-blue" style="width: 90rem;">
                    <div class="card-header">
                        Introduzca la información correspondiente
                    </div>
                    <div class="card-body">
                        <form action="controller_create_final.php" method="POST">

                            <!-- HORA, FECHA, CATEGORÍA ... -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <!-- FECHA Y HORA -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fecha">Fecha</label>
                                                    <input type="date" id="fecha" name="fecha" class="form-control" placeholder="Fecha" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="hora">Hora</label>
                                                    <input type="time" id="hora" name="hora" class="form-control" placeholder="Hora" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="contador_sale">Contador de Salida</label>
                                                    <input type="text" id="contador_sale" name="contador_sale" value="<?php echo $contadorFormateado; ?>" class="form-control" required readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- CATEGORÍA Y UBICACIONES -->
                                        <div class="row">                                    
                                        <!-- CATEGORÍAS -->
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="producto">Categoría</label>
                                                    <select name="producto" id="producto" class="form-control">
                                                        <option value="">Seleccione un Producto</option>
                                                        <?php
                                                        $query_producto = $pdo->prepare('SELECT id_producto, tipo_producto FROM t_productos WHERE tipo_producto IS NOT NULL AND tipo_producto != "" AND habilitar = "1" ORDER BY tipo_producto ASC');
                                                        $query_producto->execute();
                                                        $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($productos as $producto) {
                                                            $id_producto = $producto['id_producto'];
                                                            $nombre_producto = $producto['tipo_producto'];
                                                            ?>
                                                            <option value="<?php echo $id_producto; ?>" data_nombre="<?php echo $nombre_producto; ?>">
                                                                <?php echo $nombre_producto; ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <!-- MODULO -->
                                                <div class="row">
                                                    <div class="col-md-12 campo Modulo">
                                                        <div class="form-group">
                                                            <label for="pitch">Pitch</label>
                                                            <select id="pitch" name="pitch" class="form-control">
                                                                <option value="">Seleccione un pitch</option>
                                                                <?php 
                                                                $query_pitch = $pdo->prepare('SELECT DISTINCT pmc.pitch, tp.pitch AS pitch_nombre FROM producto_modulo_creado AS pmc INNER JOIN tabla_pitch AS tp ON pmc.pitch = tp.id ORDER BY tp.pitch ASC');
                                                                $query_pitch->execute();
                                                                $pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach ($pitches as $pitch) {
                                                                    $id_pitch = $pitch['pitch'];
                                                                    $nombre_pitch = $pitch['pitch_nombre'];
                                                                    ?>
                                                                    <option value="<?php echo $id_pitch;?>" data-pitch="<?php echo $nombre_pitch?>">
                                                                        <?php echo $nombre_pitch;?>
                                                                    </option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- CONTROLADORA -->
                                                <div class="row">
                                                    <div class="col-md-12 campo Control">
                                                        <div class="form-group">
                                                            <label for="marca_control">Marca</label>
                                                            <select id="marca_control" name="marca_control" class="form-control" >
                                                                <option value="">Seleccione una marca</option>
                                                                <?php 
                                                                $query_marca_control = $pdo->prepare('SELECT id_car_ctrl, marca_control FROM caracteristicas_control WHERE marca_control IS NOT NULL AND marca_control != "" ORDER BY marca_control ASC');
                                                                $query_marca_control->execute();
                                                                $marcas_controles = $query_marca_control->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach ($marcas_controles as $marca_control) {
                                                                    $id_marca_control = $marca_control['id_car_ctrl'];
                                                                    $nombre_marca_control = $marca_control['marca_control'];
                                                                    ?>
                                                                    <option value="<?php echo $id_marca_control;?>" data-control="<?php echo $nombre_marca_control?>">
                                                                        <?php echo $nombre_marca_control;?>
                                                                    </option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- FUENTE -->
                                                <div class="row">
                                                    <div class="col-md-12 campo Fuente">
                                                        <div class="form-group">
                                                            <label for="marca_fuente">Marca</label>
                                                            <select name="marca_fuente" id="marca_fuente" class="form-control">
                                                                <option value="">Seleccione una Marca</option>
                                                                <?php 
                                                                $query_modelo_fuente = $pdo->prepare('SELECT id_car_fuen, marca_fuente FROM caracteristicas_fuentes WHERE marca_fuente IS NOT NULL AND marca_fuente != ""  ORDER BY marca_fuente ASC');
                                                                $query_modelo_fuente->execute();
                                                                $modelos_fuentes = $query_modelo_fuente->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach ($modelos_fuentes as $modelo_fuente){
                                                                    $id_modelo_fuente = $modelo_fuente['id_car_fuen'];
                                                                    $nombre_modelo_fuente = $modelo_fuente['marca_fuente'];
                                                                    ?>
                                                                    <option value="<?php echo $id_modelo_fuente;?>" data-modeloFuente="<?php echo $nombre_modelo_fuente?>">
                                                                        <?php echo $nombre_modelo_fuente;?>
                                                                    </option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-0">
                                                <div class="form-group"> <!-- Se coloca aquí el id producto -->
                                                    <input  class="form-control" id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>
                                                </div>
                                            </div>
                                            <div class="col-md-0">
                                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                                    <input type="hidden" id="id_producto_categoria" name="id_producto_categoria">
                                                </div>
                                            </div>
                                            <!-- UBICACIONES Y EXISTENCIAS -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="ubicacion">Ubicación</label>
                                                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="existencia">Existencia</label>
                                                                <input type="text" class="form-control" id="existencia" name="existencia" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- PRODUCTOS -->
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                        
                                                    <!-- MODULO -->
                                                    <div class="row">
                                                        <div class="col-md-12 campo Modulo">
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
                                                        <div class="col-md-12 campo Modulo">
                                                            <div class="form-group">
                                                                <label for="campo_referencia">Referencia</label>
                                                                <input type="text" id="campo_referencia" name="campo_referencia" class="form-control" readonly>
                                                                <!-- Campos ocultos para almacenar los valores de serie y referencia -->
                                                                <input type="hidden" id="campo_serie" name="campo_serie">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- CONTROLADORA -->
                                                    <div class="row">
                                                        <div class="col-md-12 campo Control">
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
                                                        <div class="col-md-12 campo Fuente">
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

                                        </div>

                                        <!-- ALMACEN -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="entrada_md">Almacén Destino</label>
                                                                <select name="almacen_entrada_md" id="almacen_entrada_md" class="form-control" required>
                                                                    <option value="">Almacén Destino</option>
                                                                    <?php
                                                                    $query_almacen_entra = $pdo->prepare('SELECT * FROM t_asignar_todos_almacenes WHERE id_asignacion != 3 AND nombre_almacen != "Principal" ORDER BY nombre_almacen ASC');
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
                                                                <input type="text" name="entrada_md" id="entrada_md" class="form-control" placeholder="Cantidad Entrada">
                                                                <small id="errorEntrada" class="text-danger" style="display:none;">La Cantidad de Salida no puede superar la existencia</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="op_destino">Asignar a:</label>
                                                                <input type="text" name="op_destino" id="op_destino" class="form-control" placeholder="Asignar" required>
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
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="observacion">Observaciones</label>
                                                                <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control" placeholder="Observaciones"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TABLA -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Artículos para la Salida</label>
                                                    <table class="table table-bordered" id="tabla-articulos">
                                                        <thead>
                                                            <tr>
                                                                <th>Separar</th>
                                                                <th>Cantidad</th>
                                                                <th>Producto</th>
                                                                <th>Referencia</th>
                                                                <th>Observación</th>
                                                                <th>Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                    <button type="button" class="btn btn-primary" id="btnAgregarArticulo">Agregar Artículo</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Material Separado-->
                            <div class="modal fade" id="modalValidarMaterial" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title" id="modalLabel">Material Separado</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="contenidoTablaMaterial">
                                        <!-- Aquí se cargará dinámicamente la tabla con los registros -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="button" id="btnGenerarPdfModal" class="btn btn-info">Generar PDF</button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <a href="<?php echo $URL."admin/almacen/mv_diario/smartled";?>" class="btn btn-default btn-block">Cancelar</a>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button id="generarPdf" class="btn btn-primary">Separar o Procesar Salida</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="button" id="btnValidarMaterial" class="btn btn-info" data-toggle="modal" data-target="#modalValidarMaterial">Material Separado</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
    // Limpiar todos los campos de texto, excluyendo los campos de la tabla
    $('input[type="text"]').not('#producto, #almacen_salida_md, #id_producto_categoria, #cantidad1, #producto1, #referencia2, #contador_sale, .observacion2, #op_destino, .cantidad1, #producto_id12, #referencia_id12, .producto1, .referencia2').val('');
    $('input[type="number"]').val('');
    $('input[type="file"]').val('');
    $('select').not('#producto, #almacen_salida_md, #almacen_entrada_md').val('');
    $('textarea').val('');

    $('#list').empty(); // Vaciar la lista de imágenes si es necesario
    $('#lista_seriales').empty(); // Vaciar la tabla de seriales

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
            url: 'obtener_datos_alma_alma_smartled.php', // Archivo PHP para procesar la solicitud
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

<style>
    
    /* Estilo para el checkbox */
    .checkbox {
        width: 20px;
        height: 20px;
        margin-left: auto; /* Centra el checkbox horizontalmente */
        margin-right: auto; /* Centra el checkbox horizontalmente */
        display: block; /* Asegura que el checkbox ocupe su propio espacio */
        position: relative;
        top: 10%; /* Centra el checkbox verticalmente */
        transform: translateY(-5%); /* Ajusta el desplazamiento vertical para un centrado perfecto */
    }

    .articuloSeleccionado {
        width: 80px; /* Ajustar el ancho */
        height: 30px; /* Ajustar la altura */
        padding: 10px; /* Controlar el espacio interno */
    }
    .producto1 {
        width: 240px;
        height: 30px;
    }
    .referencia2 {
        width: 240px;
        height: 30px;
    }
    .observacion2 {
        width: 360px;
        height: 30px; /* Diferente altura para este campo */
        padding: 10px; /* Espacio interno más amplio */
    }

    /* Ajustar el input dentro del contenedor */
    .contenedor input {
        width: 100%; /* Ajustar el ancho al del contenedor */
        height: 100%; /* Ajustar la altura al del contenedor */
        box-sizing: border-box; /* Incluir padding y border en el tamaño total */
    }

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnAgregarArticulo = document.getElementById('btnAgregarArticulo');
    const tablaArticulos = document.getElementById('tabla-articulos').getElementsByTagName('tbody')[0];

    btnAgregarArticulo.addEventListener('click', function () {
        // Obtener los valores de los campos
        const cantidad = document.getElementsByName('entrada_md')[0].value;  // Cantidad
        const productoID = document.getElementById('producto').value;       // ID del producto
        const productoTexto = document.getElementById('producto').options[document.getElementById('producto').selectedIndex].text;  // Nombre del producto
        const observacion = document.getElementsByName('observacion')[0].value;

        // Obtener valores de referencia
        const pitch = document.getElementById('pitch').value;  // ID del pitch
        const pitchTexto = document.getElementById('pitch').options[document.getElementById('pitch').selectedIndex]?.text || '';
        const campoReferencia = document.getElementById('serie_modulo').value;  // ID de serie_modulo
        const referenciaTexto = document.getElementById('serie_modulo').options[document.getElementById('serie_modulo').selectedIndex]?.text || '';
        const referenciaControl35 = document.getElementById('referencia_control35').value;  // ID referencia_control35
        const referenciaControl35Texto = document.getElementById('referencia_control35').options[document.getElementById('referencia_control35').selectedIndex]?.text || '';
        const campoModeloFuente = document.getElementById('modelo_fuente35').value;  // ID modelo_fuente35
        const modeloFuenteTexto = document.getElementById('modelo_fuente35').options[document.getElementById('modelo_fuente35').selectedIndex]?.text || '';

        // Determinar la referencia y su ID
        let referencia = '';
        let referenciaID = '';

        if (pitch && campoReferencia) {
            referencia = "P" + pitchTexto + "/" + referenciaTexto;
            referenciaID = campoReferencia; // Guardar el ID
        } else if (referenciaControl35) {
            referencia = referenciaControl35Texto;
            referenciaID = referenciaControl35;
        } else if (campoModeloFuente) {
            referencia = modeloFuenteTexto;
            referenciaID = campoModeloFuente;
        }

        // Crear una nueva fila
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td>
                <!-- Campo oculto con valor "1", solo se enviará si el checkbox no está marcado -->
                <input type="hidden" name="articuloSeleccionado[]" id="articuloSeleccionado" value="0">

                <!-- Checkbox para marcar -->
                <input type="checkbox" class="checkbox form-check-input" id="articuloSeleccionado" name="articuloSeleccionado[]" value="1">
            </td>
            <td>
                <input type="text" class="form-control cantidad1" id="cantidad1" name="cantidad1[]" value="${cantidad}" readonly>
            </td>
            <td>
                <input type="text" class="form-control producto1" id="producto1" name="producto1[]" value="${productoTexto}" readonly>
                <input type="hidden" id="producto_id12" name="producto_id12[]" value="${productoID}">
            </td>
            <td>
                <input type="text" class="form-control referencia2" id="referencia2" name="referencia2[]" value="${referencia}" readonly>
                <input type="hidden" id="referencia_id12" name="referencia_id12[]" value="${referenciaID}">
            </td>
            <td>
                <input type="text" class="form-control observacion2" id="observacion2" name="observacion2[]" value="${observacion}" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-danger btnEliminarArticulo">Eliminar</button>
            </td>
        `;

        // Agregar fila a la tabla
        tablaArticulos.appendChild(nuevaFila);

        // Evento para eliminar la fila
        nuevaFila.querySelector('.btnEliminarArticulo').addEventListener('click', function () {
            nuevaFila.remove();
        });

        // Limpiar campos del formulario
        document.getElementsByName('entrada_md')[0].value = '';
        document.getElementById('producto').value = '';
        document.getElementsByName('observacion')[0].value = '';
        document.getElementById('pitch').value = '';
        document.getElementById('serie_modulo').value = '';
        document.getElementById('referencia_control35').value = '';
        document.getElementById('modelo_fuente35').value = '';
        document.getElementById('campo_referencia').value = '';
        document.getElementById('marca_control').value = '';
        document.getElementById('marca_fuente').value = '';        
    });
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

<script> //GENERAR PDF DE SALIDA DE ARTICULOS
    document.getElementById('generarPdf').addEventListener('click', function () {


        // Obtener el valor del checkbox (asegúrate de que el id de tu checkbox sea correcto)
        const checkbox = document.getElementById('articuloSeleccionado'); // Cambia 'checkbox_id' por el id de tu checkbox
        const isChecked = checkbox.checked ? "1" : "0"; // Si está marcado, es "1", si no, es "0"

        // Validar si el checkbox está marcado (si es "1", no generamos el PDF)
        if (isChecked === "1") {
            alert("No se puede generar el PDF porque el checkbox está marcado.");
            return; // Detener el proceso de generación del PDF
        }

        // Crea una nueva instancia de jsPDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait', // Establece la orientación horizontal
            unit: 'mm', // Unidad de medida
            format: [210, 297] // Formato de la hoja
        });

        // Datos adicionales
        const fecha = new Date().toLocaleDateString();
        const contadorSalida = document.getElementById('contador_sale').value || "N/A";
        const almacenDestino = document.getElementById('almacen_entrada_md').options[document.getElementById('almacen_entrada_md').selectedIndex].text || "N/A";
        const asignarA = document.getElementById('op_destino').value || "N/A";

        // Encabezado de la empresa
        const pageWidth = 210; // Ancho total de la hoja en mm

        doc.setFontSize(14);
        doc.text('SMARTLED COLOMBIA', pageWidth / 2, 10, { align: 'center' });

        doc.setFontSize(12);
        doc.text('Salida de Artículos del Almacén', pageWidth / 2, 18, { align: 'center' });

        // Información adicional
        doc.setFontSize(10);
        doc.text(`Fecha: ${fecha}`, 10, 30);
        doc.text(`# Documento: ${contadorSalida}`, 10, 35);
        doc.text(`Almacén destino: ${almacenDestino}`, 10, 40);
        doc.text(`Asignar a: ${asignarA}`, 10, 45);

        // Crear los datos para la tabla
        const tablaArticulos = document.getElementById('tabla-articulos').getElementsByTagName('tbody')[0];
        const datosTabla = []; // Aquí almacenaremos las filas de datos

        for (let i = 0; i < tablaArticulos.rows.length; i++) {
            const fila = tablaArticulos.rows[i];

            // Extraer valores de los inputs en las celdas
            const cantidad = fila.querySelector('.cantidad1').value || "";
            const producto = fila.querySelector('.producto1').value || "";
            const referencia = fila.querySelector('.referencia2').value || "";
            const observacion = fila.querySelector('.observacion2').value || "";

            // Agregar la fila de datos como un array
            datosTabla.push([cantidad, producto, referencia, observacion]);
        }

        // Usar autoTable para crear la tabla
        doc.autoTable({
            head: [['Cantidad', 'Producto', 'Referencia', 'Observación']], // Encabezados
            body: datosTabla, // Datos de la tabla
            startY: 55, // Posición inicial
            styles: { fontSize: 8 }, // Tamaño de fuente
            columnStyles: {
            0: { cellWidth: 20 },  // Cantidad
            1: { cellWidth: 50 },  // Producto
            2: { cellWidth: 50 },  // Referencia
            3: { cellWidth: 60 }   // Observación
        },
            theme: 'grid', // Tema con bordes para la tabla
            margin: { left: 10, right: 10 } // Márgenes laterales
        });

        // Agregar líneas para firma
        const finalY = doc.lastAutoTable.finalY + 15; // Obtener la posición final de la tabla y dar espacio

        // Dibujar líneas horizontales
        doc.line(20, finalY, 70, finalY); // Línea para "Entrega"
        doc.line(100, finalY, 150, finalY); // Línea para "Recibe"

        // Agregar textos debajo de las líneas
        doc.setFontSize(10);
        doc.text("Entrega", 35, finalY + 5); // Texto debajo de la línea de "Entrega"
        doc.text("Recibe", 115, finalY + 5); // Texto debajo de la línea de "Recibe"

        // Guardar el PDF con un nombre específico
        doc.save('reporte_articulos.pdf');
    });
</script>

<script> // GENERAR EL PDF DE MATERIAL SEPARADO DEL ALMACEN
    document.getElementById('btnValidarMaterial').addEventListener('click', function () {
        fetch('validar_registros.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: 'validar_material' })
})
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta del servidor:', data);  // Verifica la respuesta completa
        if (data.success) {
            console.log('Registros obtenidos:', data.registros);  // Verifica los registros obtenidos
            let contenidoTabla = `<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Separar</th>
                                <th>Producto</th>
                                <th>Referencia</th>
                                <th>Cantidad</th>
                                <th>Observaciones</th>
                                <th>Asignado a:</th>
                                <th>N° Movimiento</th>
                                <th>Almacen Destino</th>
                            </tr>
                        </thead>
                        <tbody>`;

data.registros.forEach(registro => {
    contenidoTabla += `<tr>
                        <td>
                            <input type="checkbox" class="checkbox-material" data-id="${registro.id_movimiento_diario}">
                        </td>
                        <td>${registro.nombre_producto}</td>
                        <td>${registro.nombre_referencia_2}</td>
                        <td>${registro.cantidad_entrada}</td>
                        <td>${registro.observaciones}</td>
                        <td>${registro.op}</td>
                        <td>${registro.consecu_sale}</td>
                        <td>${registro.almacen_destino}</td>
                        </tr>`;
});

contenidoTabla += `</tbody></table>`;
document.getElementById('contenidoTablaMaterial').innerHTML = contenidoTabla;

        } else {
            alert('No se encontraron registros.');
        }
    })
    .catch(error => console.error('Error:', error));

    });

    document.getElementById('btnGenerarPdfModal').addEventListener('click', function () {
    const checkboxes = document.querySelectorAll('.checkbox-material:checked');
    const registrosSeleccionados = [];
    const idsActualizar = [];

    // Inicializa variables para los datos adicionales
    let fecha = new Date().toLocaleDateString();
    let contadorSalida = "N/A";
    let almacenDestino = "N/A";
    let asignarA = "N/A";

    checkboxes.forEach(checkbox => {
        const fila = checkbox.closest('tr');
        const columnas = Array.from(fila.querySelectorAll('td'));

        // Asignar manualmente los valores que deseas extraer
        const cantidad = columnas[3]?.textContent || "N/A"; // Cantidad
        const producto = columnas[1]?.textContent || "N/A"; // Producto
        const referencia = columnas[2]?.textContent || "N/A"; // Referencia
        const observacion = columnas[4]?.textContent || "N/A"; // Observación

         // Solo toma los datos adicionales del primer registro (si son comunes a todos)
        if (!contadorSalida || contadorSalida === "N/A") contadorSalida = columnas[6]?.textContent || "N/A";
        if (!almacenDestino || almacenDestino === "N/A") almacenDestino = columnas[7]?.textContent || "N/A";
        if (!asignarA || asignarA === "N/A") asignarA = columnas[5]?.textContent || "N/A";

        registrosSeleccionados.push([cantidad, producto, referencia, observacion]);

        // También puedes asignar columnas específicas directamente a variables globales, si es necesario
        idsActualizar.push(checkbox.dataset.id); // Almacenar el ID seleccionado
    });

    if (registrosSeleccionados.length === 0) {
        alert('Por favor, selecciona al menos un registro.');
        return;
    }

    // Generar el PDF con los datos seleccionados
    generarPDF(registrosSeleccionados, fecha, contadorSalida, almacenDestino, asignarA);

    // Llamar a la función para actualizar registros en la base de datos
    actualizarRegistros(idsActualizar);
});

// Función para generar el PDF con los datos
function generarPDF(registrosSeleccionados, fecha, contadorSalida, almacenDestino, asignarA) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'portrait', // Orientación horizontal
        unit: 'mm', // Unidad de medida
        format: [210, 297] // Media carta (ancho x alto)
    });

    // Encabezado de la empresa
    const pageWidth = 210; // Ancho total de la hoja en mm

    doc.setFontSize(14);
    doc.text('SMARTLED COLOMBIA', pageWidth / 2, 10, { align: 'center' });

    doc.setFontSize(12);
    doc.text('Salida de Artículos del Almacén', pageWidth / 2, 18, { align: 'center' });

    // Información adicional
    doc.setFontSize(10);
    doc.text(`Fecha: ${fecha}`, 10, 30);
    doc.text(`# Documento: ${contadorSalida}`, 10, 35);
    doc.text(`Almacén destino: ${almacenDestino}`, 10, 40);
    doc.text(`Asignar a: ${asignarA}`, 10, 45);

    // Crear la tabla con autoTable
    doc.autoTable({
        head: [['Cantidad', 'Producto', 'Referencia', 'Observación']], // Encabezados
        body: registrosSeleccionados, // Datos de la tabla
        startY: 55, // Posición inicial
        styles: { fontSize: 8 }, // Tamaño de fuente
        columnStyles: {
            0: { cellWidth: 20 },  // Cantidad
            1: { cellWidth: 50 },  // Producto
            2: { cellWidth: 50 },  // Referencia
            3: { cellWidth: 60 }   // Observación
        },
        theme: 'grid',
        margin: { left: 10, right: 10 } // Márgenes laterales
    });

    // Agregar líneas para firmas
    const finalY = doc.lastAutoTable.finalY + 15; // Posición después de la tabla

    doc.line(20, finalY, 70, finalY); // Línea para "Entrega"
    doc.line(100, finalY, 150, finalY); // Línea para "Recibe"

    // Agregar textos para firmas
    doc.setFontSize(10);
    doc.text("Entrega", 35, finalY + 5); // Texto debajo de la línea de "Entrega"
    doc.text("Recibe", 115, finalY + 5); // Texto debajo de la línea de "Recibe"

    // Guardar el PDF
    doc.save('material_validado.pdf');
}

function actualizarRegistros(ids) {
    console.log('IDs enviados al servidor:', ids); // Verifica los IDs enviados
    fetch('actualizar_registros.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ids: ids })
    })
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data); // Verifica la respuesta del servidor
            if (data.success) {
                alert('Los registros se han actualizado correctamente.');
            } else {
                alert('Hubo un problema al actualizar los registros: ' + (data.message || 'Error desconocido.'));
            }
        })
        .catch(error => console.error('Error:', error));
}
</script>