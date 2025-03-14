<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

    // Consulta movimiento diario
    $query_movimiento = $pdo->prepare('SELECT
                                                mvd.*,
                                                tp.tipo_producto AS nombre_producto,
                                                dal.posiciones AS ubicacion,
                                                tpi.pitch AS nombre_pitch,
                                                pmc.serie AS nombre_serie,
                                                pmc1.referencia AS referencia_modulo,
                                                tata.nombre_almacen AS nombre_alma_origen,
                                                refu.modelo_fuente AS nombre_modelo_fuente,
                                                carafu.marca_fuente AS nombre_marca_fuente,
                                                refecon.referencia AS nombre_refe_control,
                                                caracon.marca_control AS nombre_marc_control
                                            FROM
                                                movimiento_techled AS mvd
                                            LEFT JOIN
                                                t_productos AS tp ON mvd.tipo_producto = tp.id_producto
                                            LEFT JOIN
                                                distribucion_almacen AS dal ON mvd.posicion = dal.id
                                            LEFT JOIN
                                                tabla_pitch AS tpi ON mvd.pitch_modulo = tpi.id
                                            LEFT JOIN
                                                producto_modulo_creado AS pmc ON mvd.serie_modulo = pmc.id
                                            LEFT JOIN
                                                producto_modulo_creado AS pmc1 ON mvd.serie_modulo = pmc1.id
                                            LEFT JOIN
                                                t_asignar_todos_almacenes AS tata ON mvd.almacen_origen1 = tata.id_asignacion
                                            LEFT JOIN
                                                referencias_fuente AS refu ON mvd.modelo_fuente = refu.id_referencias_fuentes
                                            LEFT JOIN
                                                caracteristicas_fuentes AS carafu ON mvd.marc_fuente1 = carafu.id_car_fuen
                                            LEFT JOIN
                                                caracteristicas_control AS caracon ON mvd.marca_control = caracon.id_car_ctrl
                                            LEFT JOIN
                                                referencias_control AS refecon ON mvd.referencia_control = refecon.id_referencia
                                            WHERE
                                                mvd.id_movimiento_diario = :id_get
                                            ');
    $query_movimiento->bindParam(':id_get', $id_get, PDO::PARAM_INT);
    $query_movimiento->execute();
    
    // Obtener el movimiento diario
    $movimientoDiario = $query_movimiento->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($movimientoDiario as $movimiento){
        $id_movimiento = $movimiento['id_movimiento_techled'];
        $fecha = $movimiento['fecha'];
        $nombre_producto = $movimiento['nombre_producto'];
        $tipo_producto = $movimiento['tipo_producto'];
        $modulo = $movimiento['serie_modulo'];
        $control = $movimiento['referencia_control'];
        $nombre_refe_control = $movimiento['nombre_refe_control'];
        $nombre_marc_control = $movimiento['nombre_marc_control'];
        $id_marca_control =$movimiento['marca_control'];
        $id_referencia_control = $movimiento['referencia_control'];
        $fuente = $movimiento['nombre_modelo_fuente'];
        $fuente_marca = $movimiento['nombre_marca_fuente'];
        $id_marca_fuente = $movimiento['marc_fuente1'];
        $id_modelo_fuente = $movimiento['modelo_fuente'];
        $observaciones = $movimiento['observaciones'];
        $op = $movimiento['op'];
        $nombre_ubicacion = $movimiento['ubicacion'];
        $id_pitch = $movimiento['pitch_modulo'];
        $nombre_pitch = $movimiento['nombre_pitch'];
        $posicion1 = $movimiento['posicion'];
        $nombre_serie = $movimiento['nombre_serie'];
        $referencia_modulo = $movimiento['referencia_modulo'];
        $almacen_origen = $movimiento['nombre_alma_origen'];
        $id_alma_origen = $movimiento['almacen_origen1'];
        $cantidad = $movimiento['cantidad_entrada'];


    }

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Visor de Movimientos Diario</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-info">
                <div class="card-header">
                    Visor Detalles
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
                            <div class="col-md-12">
                                <center><h1 class="m-0">Validar Producto</h1></center>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="producto">Categoría</label>
                                    <select name="producto" id="producto" class="form-control" required onchange="updateIdProducto()" disabled>
                                        <!-- Opción por defecto -->
                                        <option value="<?php echo $tipo_producto; ?>" selected><?php echo $nombre_producto?></option>
                                        <!-- Opciones dinámicas -->
                                        <?php
                                        $query_producto = $pdo->prepare('SELECT id_producto, tipo_producto FROM t_productos WHERE habilitar = "1" ORDER BY tipo_producto ASC');
                                        $query_producto->execute();
                                        $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);

                                        foreach($productos as $producto) {
                                            $id_tipo_producto = $producto['id_producto'];
                                            $nombre_tipo_producto = $producto['tipo_producto'];

                                            // Excluir la opción por defecto
                                            if ($id_tipo_producto != $tipo_producto) {
                                                echo "<option value='$id_tipo_producto'>$nombre_tipo_producto</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    <!-- Campo oculto que almacena dinámicamente el ID seleccionado -->
                                    <input type="hidden" name="id_producto_tipo" id="id_producto_tipo" value="<?php echo $tipo_producto; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-0">
                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                    <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                    <label for="posicion2">UBICACIÓN</label>
                                    <select name="posicion2" id="posicion2" class="form-control" required onchange = "updateIdUbicacion()" disabled>
                                        <option value="<?php echo $posicion1; ?>" selected><?php echo $nombre_ubicacion; ?></option>
                                        <?php
                                        $query_posicion = $pdo->prepare('SELECT id, posiciones FROM distribucion_almacen');
                                        $query_posicion->execute();
                                        $posiciones = $query_posicion->fetchAll(PDO::FETCH_ASSOC);

                                        foreach($posiciones as $posicion) {
                                            $id_ubicacion = $posicion['id'];
                                            $nombre_ubicacion = $posicion['posiciones'];

                                            // Excluir la opción por defecto
                                            if ($id_ubicacion != $posicion1){
                                                echo "<option value='$id_ubicacion'>$nombre_ubicacion</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" name="posicion_id" id="posicion_id" value="<?php echo $posicion1; ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                            <!-- MODULO -->

                        <div class="row">
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="pitch">Pitch</label>
                                    <select id="pitch" name="pitch" class="form-control" onchange = "updatedIdPitch()" disabled>
                                        <option value="<?php echo $id_pitch; ?>" selected><?php echo $nombre_pitch; ?></option>
                                        <?php 
                                        $query_pitch = $pdo->prepare('SELECT id, pitch FROM tabla_pitch ORDER BY pitch ASC');
                                        $query_pitch->execute();
                                        $pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($pitches as $pitch){
                                            $pitch_id = $pitch['id'];
                                            $pitch_nombre = $pitch['pitch'];

                                            // Excluir la opción por defecto
                                            if ($pitch_id != $id_pitch){
                                                echo "<option value='$pitch_id'>$pitch_nombre</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    <!-- Campo oculto que almacena dinámicamente el ID seleccionado -->
                                    <input type="hidden" name="id_pitch12" id="id_pitch12" value="<?php echo $id_pitch; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3 campo Modulo">
                                <div class="form-group">
                                    <label for="serie_modulo11">Serie</label>
                                    <select id="serie_modulo11" name="serie_modulo11" class="form-control" onchange="updatedIdSerie()" disabled>
                                        <option value="<?php echo $modulo; ?>" selected><?php echo $nombre_serie; ?></option>
                                        <!-- Las opciones se llenarán dinámicamente vía AJAX -->

                                        <?php
                                            // Consulta para obtener las series y las referencias filtradas por ID
                                            $query = $pdo->prepare('SELECT id, serie FROM producto_modulo_creado ORDER BY serie ASC');
                                            $query->execute();
                                            $series = $query->fetchAll(PDO::FETCH_ASSOC);

                                            // Generar las opciones del select
                                            foreach ($series as $serie) {
                                                $serie_id = $serie['id'];
                                                $serie_nombre = $serie['serie'];

                                                // Excluir la opción que ya está seleccionada por defecto
                                                if ($serie_id!= $modulo){
                                                    echo "<option value='$serie_id'>$serie_nombre</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <!-- Campo oculto que almacena dinámicamente el ID seleccionado -->
                                    <input type="hidden" name="id_serie12" id="id_serie12" value="<?php echo $modulo; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="referencia_modulo">Referencia</label>
                                    <input type="text" id="campo_referencia" name="referencia" value="<?php echo $referencia_modulo; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                            <!-- CONTROLADORA -->

                        <div class="row">
                            <div class="col-md-2 campo Control">
                                <div class="form-group">
                                    <label for="marca_control">Marca</label>
                                    <select id="marca_control" name="marca_control" class="form-control" disabled>
                                        <option value="<?php echo $id_marca_control ; ?>"><?php echo $nombre_marc_control ; ?></option>
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
                            <div class="col-md-2 campo Control">
                                <div class="form-group">
                                    <label for="referencia_control35">Referencia</label>
                                    <select id="referencia_control35" name="referencia_control35" class="form-control" disabled>
                                        <option value="<?php echo $control; ?>"><?php echo $nombre_refe_control; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-0">
                            </div>
                        </div>

                            <!-- FUENTE -->

                        <div class="row">
                            <div class="col-md-2 campo Fuente">
                                <div class="form-group">
                                    <label for="marca_fuente">Marca</label>
                                    <select name="marca_fuente" id="marca_fuente" class="form-control" disabled>
                                        <option value="<?php echo $id_marca_fuente; ?>"><?php echo $fuente_marca; ?></option>
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
                            <div class="col-md-2 campo Fuente">
                                <div class="form-group">
                                    <label for="modelo_fuente35">Modelo</label>
                                    <select name="modelo_fuente35" id="modelo_fuente35" class="form-control" disabled>
                                        <option value="<?php echo $id_modelo_fuente; ?>"><?php echo $fuente; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                            <!-- LCD -->

                        <div class="row">
                            <div class="col-md-3 campo LCD">
                                <div class="form-group">
                                    <label for="marca_lcd">Marca</label>
                                    <input type="text" id="marca_lcd" name="marca_lcd" class="form-control" placeholder="Marca">
                                </div>
                            </div>
                            <div class="col-md-3 campo LCD">
                                <div class="form-group">
                                    <label for="modelo_lcd">Modelo</label>
                                    <input type="text" id="modelo_lcd" name="modelo_lcd" class="form-control" placeholder="Modelo">
                                </div>
                            </div>
                        </div>

                            <!-- ALMACEN -->

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="salida_md">Almacén Origen</label>
                                                <select name="almacen_salida_md" id="almacen_salida_md" class="form-control" disabled
                                                >
                                                    <option value="<?php echo $id_alma_origen; ?>" selected><?php echo $almacen_origen; ?></option>
                                                    <?php 
                                                    $query_almacen  = $pdo->prepare('SELECT * FROM t_asignar_todos_almacenes WHERE id_asignacion != 4 AND nombre_almacen != "Techled"');
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
                                                <input type="text" name="salida_md" class="form-control" value="<?php echo $cantidad; ?>" readonly>
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
                                                    $selected = ($almacen_entra['id_asignacion'] == 4) ? 'selected' : '';
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
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="op_destino">Asignar a:</label>
                                                <input type="text" name="op_destino" class="form-control" value="<?php echo $op; ?>" readonly>
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
                                                <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control" readonly><?php echo $observaciones; ?></textarea>
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
                                    <a href="<?php echo $URL."admin/almacen/mv_diario/techled";?>" class="btn btn-default btn-block">Volver</a>
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

            // Llamar a la función al cargar la página par aque se muestre los campos correctos desde el inicio
            window.addEventListener('load', function() {
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