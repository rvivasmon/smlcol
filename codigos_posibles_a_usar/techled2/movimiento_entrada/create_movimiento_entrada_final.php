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

    // Obtener el último contador desde la base de datos
    $query = $pdo->prepare('SELECT consecu_entra FROM movimiento_techled ORDER BY consecu_entra DESC LIMIT 1');
    $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado) {
        // Si existe un registro, obtener el último valor del contador e incrementarlo
        $ultimoContador = $resultado['consecu_entra']; 
        $nuevoContador = $ultimoContador + 1;
    } else {
        // Si no existe un registro, iniciar el contador en 1
        $nuevoContador = 1;
    }
    
    // Formatear el contador con ceros a la izquierda (4 dígitos)
    $contadorFormateado = str_pad($nuevoContador, 4, '0', STR_PAD_LEFT);
    
    // Aquí puedes usar $contadorFormateado para insertarlo o procesarlo según sea necesario
    

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        <div class="table-responsive">
            <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                <!-- Tabla con datos del movimiento general -->

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Entrada Stock Almacén TechLed</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue" style="width: 120rem;">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create_final.php" method="POST">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="fecha">Fecha</label>
                                                <input type="date" id="fecha" name="fecha" class="form-control" placeholder="Fecha" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="hora">Hora</label>
                                                <input type="time" id="hora" name="hora" class="form-control" placeholder="Hora" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="contador_entra">Contador de Entrada</label>
                                                <input type="text" id="contador_entra" name="contador_entra" value="<?php echo $contadorFormateado; ?>" class="form-control" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="almacen_estra">Almacén destino</label>
                                                <select name="almacen_estra" id="almacen_estra" class="form-control" required>
                                                    <option value="">Seleccione un Almacen</option>
                                                    <?php
                                                    $query_producto = $pdo->prepare('SELECT id, almacenes FROM almacenes_grupo WHERE almacenes IS NOT NULL AND almacenes != "" AND habilitar = "1" ORDER BY almacenes ASC');
                                                    $query_producto->execute();
                                                    $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($productos as $producto) {
                                                        echo '<option value="' . $producto['id'] . '">' . $producto['almacenes'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="producto">Categoría</label>
                                                <select name="producto" id="producto" class="form-control" required>
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
                                        <div class="col-md-0">
                                            <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                                <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']; ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                                <label for="posicion1">UBICACIÓN</label>
                                                <select name="posicion1" id="posicion1" class="form-control" required>
                                                    <option value="">Posición</option>
                                                    <?php
                                                    $query_posicion = $pdo->prepare('SELECT * FROM distribucion_almacen');
                                                    $query_posicion->execute();
                                                    $posiciones = $query_posicion->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($posiciones as $posicion) {
                                                        echo '<option value="' . $posicion['id'] . '">' . $posicion['posiciones'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                        <!-- MODULO -->

                                    <div class="row">
                                        <div class="col-md-6 campo Modulo">
                                            <div class="form-group">
                                                <label for="pitch">Pitch</label>
                                                <select id="pitch" name="pitch" class="form-control">
                                                    <option value="">Seleccione un pitch</option>
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
                                                    <option value="<?php echo $pitch['pitch']; ?>">
                                                        <?php echo $pitch['pitch_nombre']; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 campo Modulo">
                                            <div class="form-group">
                                                <label for="serie_modulo">Serie</label>
                                                <select id="serie_modulo" name="serie_modulo" class="form-control">
                                                    <option value="">Seleccione una Serie</option>
                                                    <!-- Las opciones se llenarán dinámicamente vía AJAX -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 campo Modulo">
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

                                        <!-- LCD -->

                                    <div class="row">
                                        <div class="col-md-6 campo LCD">
                                            <div class="form-group">
                                                <label for="marca_lcd">Marca</label>
                                                <input type="text" id="marca_lcd" name="marca_lcd" class="form-control" placeholder="Marca">
                                            </div>
                                        </div>
                                        <div class="col-md-6 campo LCD">
                                            <div class="form-group">
                                                <label for="modelo_lcd">Modelo</label>
                                                <input type="text" id="modelo_lcd" name="modelo_lcd" class="form-control" placeholder="Modelo">
                                            </div>
                                        </div>
                                    </div>

                                        <!-- ALMACEN -->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <label for="salida_md">Almacén Origen</label>
                                                            <select name="almacen_salida_md" id="almacen_salida_md" class="form-control" required>
                                                                <option value="">Almacén Origen</option>
                                                                <?php 
                                                                $query_almacen  = $pdo->prepare('SELECT * FROM t_asignar_todos_almacenes WHERE id_asignacion != 3 AND id_asignacion != 4 AND nombre_almacen != "Principal" AND nombre_almacen != "TechLed" ORDER BY nombre_almacen ASC');
                                                                    $query_almacen->execute();
                                                                    $almacenes = $query_almacen->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($almacenes as $almacen) {
                                                                        echo '<option value="' . $almacen['id_asignacion'] . '">' . $almacen['nombre_almacen'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                            <input class="form-control" name="almacen_salida_md_id" id="almacen_salida_md_id" hidden>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="salida_md">Cantidad</label>
                                                            <input type="text" name="salida_md" class="form-control" placeholder="Entrada" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-7" hidden>
                                                        <div class="form-group">
                                                            <label for="entrada_md">Almacén Destino</label>
                                                            <select name="almacen_entrada_md" id="almacen_entrada_md" class="form-control" >
                                                                <option value="">Almacén Destino</option>
                                                            <?php 
                                                            $query_almacen_entra = $pdo->prepare('SELECT * FROM t_asignar_todos_almacenes');
                                                            $query_almacen_entra->execute();
                                                            $almacenes_entras = $query_almacen_entra->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($almacenes_entras as $almacen_entra) {
                                                                $selected = ($almacen_entra['id_asignacion'] == 3) ? 'selected' : '';
                                                                echo '<option value="' . $almacen_entra['id_asignacion'] . '" ' . $selected . '>' . $almacen_entra['nombre_almacen'] . '</option>';
                                                            }
                                                            ?>
                                                            </select>
                                                            <input class="form-control" name="almacen_entrada_md_id" id="almacen_entrada_md_id" hidden>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3" hidden>
                                                        <div class="form-group">
                                                            <label for="entrada_md">Entrada</label>
                                                            <input type="text" name="entrada_md" class="form-control" placeholder="Cantidad Entrada" >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="op_destino">Asignar a:</label>
                                                            <input type="text" name="op_destino" class="form-control" placeholder="Asignar" required>
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
                                    <div class="col-md-12">
                                        <div class="form-group">
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
                        </div>
                    </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <a href="<?php echo $URL."admin/almacen/stock/techled/";?>" class="btn btn-default btn-block">Cancelar</a>
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


    <!-- MODAL ENTRADA MOVIMIENTOS -->
    <div class="modal fade" id="modalMovimiento" tabindex="-1" aria-labelledby="modalMovimientoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMovimientoLabel">Movimientos</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Tipo Producto</th>
                                    <th scope="col">Referencia</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">OP</th>
                                    <th scope="col">Bodega</th>
                                    <th scope="col">Sub Almacén</th>
                                    <th scope="col">Observaciones</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaMovimientos"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
    .modal-xl .modal-content {
        width: 150%;
        max-width: 1400px;
        padding: 20px;
    }

    .modal-xl .modal-body {
        max-height: 80vh;
        overflow-y: auto;
    }

    .table-responsive {
        overflow-x: auto; /* Permite desplazamiento horizontal si es necesario */
    }

    .table td input {
        font-size: 14px;
        padding: 4px;
        text-align: center;
        width: 100%;
        max-width: 140px; /* Limita el tamaño de los inputs */
    }

    .btn-success {
        padding: 5px 10px;
        font-size: 14px;
    }
    </style>


    <!-- MODAL ACTUALIZAR REFERENCIAS-->
    <?php if (!empty($modulosSinReferencia)): ?>
        <div id="modalReferencia" class="modal" tabindex="-1" role="dialog" style="display:block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Actualizar Referencias Faltantes</h5>
                        <button type="button" class="close" aria-label="Close" onclick="cerrarModal()" disabled>
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($modulosSinReferencia as $modulo): ?>
                            <form action="controller_actualizar_referencia.php" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario(this);">
                                <input type="hidden" name="id" value="<?php echo $modulo['id']; ?>">
                                <p>El módulo con serie <strong><?php echo $modulo['serie']; ?></strong> y tamaño <strong><?php echo $modulo['nombre_tamano']?></strong> no tiene referencia.</p>
                                <div class="form-group">
                                    <label for="referencia">Ingrese la referencia:</label>
                                    <input type="text" name="referencia" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="imagen">Subir imagen:</label>
                                    <input type="file" name="archivo_adjunto" id="archivo_adjunto" class="form-control-file" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary">Actualizar Referencia</button>
                            </form>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="cerrarModal()" disabled>Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <style>
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed;
            z-index: 1050;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5); /* Fondo oscuro */
        }
        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
    </style>

    <script>
        function cerrarModal() {
            document.getElementById('modalReferencia').style.display = 'none';
        }
    </script>

    <script>
        function validarFormulario(form) {
            // Obtener los valores de referencia e imagen
            var referencia = form.referencia.value.trim();
            var imagen = form.imagen.value;

            // Validar que ambos campos estén diligenciados
            if (referencia === "" || imagen === "") {
                alert("Por favor, complete todos los campos antes de enviar.");
                return false; // Evita el envío del formulario
            }
            return true; // Permite el envío del formulario
        }

        function cerrarModal() {
            // Ocultar el modal solo si no existen formularios con campos incompletos
            var forms = document.querySelectorAll('#modalReferencia form');
            var completo = true;

            forms.forEach(function(form) {
                if (!validarFormulario(form)) {
                    completo = false;
                }
            });

            if (completo) {
                document.getElementById('modalReferencia').style.display = 'none';
            } else {
                alert("Por favor, complete todas las referencias e imágenes antes de cerrar el modal.");
            }
        }
    </script>

    

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

        // Función para actualizar el campo entrada_md
        function actualizarEntradaMd() {
            entradaMdInput.value = salidaMdInput.value; // Establecer el mismo valor que salida_md
        }

        // Escuchar cambios en el campo salida_md y llamar a la función actualizarEntradaMd
        salidaMdInput.addEventListener('input', actualizarEntradaMd);
    });
    </script>

    <script>
    $(document).ready(function() {
        // Detectar cuando cambie el valor del campo 'producto'
        $('#producto').change(function() {
            limpiarCampos(); // Llama a la función que limpia los campos
        });

        // Función para limpiar todos los campos del formulario, excluyendo el campo 'producto'
        function limpiarCampos() {
            // Limpiar todos los inputs de texto, select y textarea, excepto el campo 'producto'
            $('input[type="text"]').not('#producto, #almacen_entrada_md, #contador_entra').val('');  // Limpiar campos de texto excepto 'producto'
            $('input[type="number"]').val(''); // Limpiar campos numéricos
            $('input[type="file"]').val('');   // Limpiar campo de archivo
            $('select').not('#producto, #almacen_entrada_md').val(''); // Limpiar selects excepto 'producto'
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
$(document).ready(function () {
    // Obtener registros y mostrarlos en el modal solo si hay datos
    $.ajax({
        url: "obtener_movimientos.php",
        method: "GET",
        dataType: "json",
        success: function (data) {
            if (data.length > 0) {  // Si hay registros
                let tabla = "";
                data.forEach((item) => {
                    tabla += `<tr>
                        <td><input type="text" class="form-control form-control-sm" value="${item.fecha}" readonly></td>
                        <td><input type="text" class="form-control form-control-sm" value="${item.nombre_producto}" readonly></td>
                        <td><input type="text" class="form-control form-control-sm" value="${item.nombre_referencia_2}" readonly></td>
                        <td><input type="number" class="form-control form-control-sm cantidad" data-id="${item.id_movimiento_diario}" value="${item.cantidad_entrada}"></td>
                        <td><input type="text" class="form-control form-control-sm" value="${item.op}" readonly></td>
                        <td><input type="text" class="form-control form-control-sm" value="${item.bodega_nombre}" readonly></td>
                        <td><input type="text" class="form-control form-control-sm" value="${item.nombre_sub}" readonly></td>
                        <td><input type="text" class="form-control form-control-sm observaciones" data-id="${item.id_movimiento_diario}" placeholder="Observaciones"></td>
                        <td><button class="btn btn-success btn-sm procesar" data-id="${item.id_movimiento_diario}">Procesar</button></td>
                    </tr>`;
                });

                $("#tablaMovimientos").html(tabla); // Insertar datos en la tabla
                $("#modalMovimiento").modal("show"); // Mostrar modal
            } else {
                alert("No hay movimientos disponibles."); // Mensaje si no hay registros
            }
        },
        error: function () {
            alert("Error al obtener los datos.");
        }
    });

    // Evento para procesar el registro
    $(document).on("click", ".procesar", function () {
    let row = $(this).closest("tr"); // Obtener la fila correspondiente al botón presionado
    let id = $(this).data("id");
    let cantidad = row.find(".cantidad").val().trim();  // Capturar valor actualizado
    let observaciones = row.find(".observaciones").val().trim(); // Capturar valor actualizado

    if (cantidad === "" || cantidad <= 0) {
        alert("Ingrese una cantidad válida.");
        return;
    }

    $.ajax({
        url: "procesar_movimiento.php",
        method: "POST",
        data: { id, cantidad, observaciones },
        success: function (response) {
            alert("Registro procesado correctamente.");
            $("#modalMovimiento").modal("hide");
        },
        error: function (xhr, status, error) {
            console.error("Error en la petición AJAX:", error);
        }
    });
});

});
</script>