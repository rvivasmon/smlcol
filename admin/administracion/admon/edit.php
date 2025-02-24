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
                                                pmc1.serie AS nombre_serie,
                                                pmc2.referencia AS referencia_modulo,
                                                tata.nombre_almacen AS nombre_alma_origen,
                                                tata1.nombre_almacen AS nombre_alma_destino,
                                                refu.modelo_fuente AS nombre_modelo_fuente,
                                                carafu.marca_fuente AS nombre_marca_fuente,
                                                refecon.referencia AS nombre_refe_control,
                                                caracon.marca_control AS nombre_marc_control
                                            FROM
                                                movimiento_diario AS mvd
                                            LEFT JOIN
                                                producto_modulo_creado AS pmc ON mvd.referencia_2 = pmc.id
                                            LEFT JOIN
                                                t_productos AS tp ON mvd.tipo_producto = tp.id_producto
                                            LEFT JOIN
                                                distribucion_almacen AS dal ON mvd.posicion = dal.id
                                            LEFT JOIN
                                                tabla_pitch AS tpi ON pmc.pitch = tpi.id
                                            LEFT JOIN
                                                producto_modulo_creado AS pmc1 ON mvd.referencia_2 = pmc1.id
                                            LEFT JOIN
                                                producto_modulo_creado AS pmc2 ON mvd.referencia_2 = pmc2.id
                                            LEFT JOIN
                                                t_asignar_todos_almacenes AS tata ON mvd.almacen_origen1 = tata.id_asignacion
                                            LEFT JOIN
                                                t_asignar_todos_almacenes AS tata1 ON mvd.almacen_destino1 = tata1.id_asignacion
                                            LEFT JOIN
                                                referencias_fuente AS refu ON mvd.referencia_2 = refu.id_referencias_fuentes
                                            LEFT JOIN
                                                caracteristicas_fuentes AS carafu ON mvd.referencia_2 = carafu.id_car_fuen
                                            LEFT JOIN
                                                caracteristicas_control AS caracon ON mvd.referencia_2 = caracon.id_car_ctrl
                                            LEFT JOIN
                                                referencias_control AS refecon ON mvd.referencia_2 = refecon.id_referencia
                                            WHERE
                                                mvd.id_movimiento_diario = :id_get
                                            ');
    $query_movimiento->bindParam(':id_get', $id_get);
    $query_movimiento->execute();
    
    // Obtener el movimiento diario
    $movimientoDiario = $query_movimiento->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($movimientoDiario as $movimiento){
        $id_movimiento = $movimiento['id_movimiento_diario'];
        $fecha = $movimiento['fecha'];
        $nombre_producto = $movimiento['nombre_producto'];
        $tipo_producto = $movimiento['tipo_producto'];
        $nombre_refe_control = $movimiento['nombre_refe_control'];
        $nombre_marc_control = $movimiento['nombre_marc_control'];
        $fuente = $movimiento['nombre_modelo_fuente'];
        $fuente_marca = $movimiento['nombre_marca_fuente'];
        $observaciones = $movimiento['observaciones'];
        $op = $movimiento['op'];
        $nombre_ubicacion = $movimiento['ubicacion'];
        $nombre_pitch = $movimiento['nombre_pitch'];
        $posicion1 = $movimiento['posicion'];
        $nombre_serie = $movimiento['nombre_serie'];
        $referencia_modulo = $movimiento['referencia_modulo'];
        $almacen_origen = $movimiento['nombre_alma_origen'];
        $almacen_destino = $movimiento['nombre_alma_destino'];
        $id_alma_origen = $movimiento['almacen_origen1'];
        $cantidad = $movimiento['cantidad_entrada'];
    }

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Movimientos Diario General</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-success">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit.php" method="POST">
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
                                    <input type="text" name="producto" id="producto" value="<?php echo $nombre_producto; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-0">
                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                    <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>
                                    <input type="text" name="id_movimiento1" id="id_movimiento1" value="<?php echo $id_get; ?>" hidden>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                    <label for="posicion2">UBICACIÓN</label>
                                    <input type="text" name="posicion2" id="posicion2" value="<?php echo $nombre_ubicacion; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                            <!-- MODULO -->

                        <div class="row">
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="pitch">Pitch</label>
                                    <input type="text" name="pitch" id="pitch" class="form-control" value="<?php echo $nombre_pitch; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 campo Modulo">
                                <div class="form-group">
                                    <label for="serie_modulo11">Serie</label>
                                    <input type="text" name="serie_modulo11" id="serie_modulo11" value="<?php echo $nombre_serie; ?>" class="form-control" readonly>
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
                                    <input type="text" id="marca_control" name="marca_control" value="<?php echo $nombre_marc_control; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2 campo Control">
                                <div class="form-group">
                                    <label for="referencia_control35">Referencia</label>
                                    <input type="text" id="marca_control" name="marca_control" value="<?php echo $nombre_refe_control; ?>" class="form-control" readonly>
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
                                                <label for="almacen_salida_md">Almacén Origen</label>
                                                <input type="text" name="almacen_salida_md" id="almacen_salida_md" value="<?php echo $almacen_origen; ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="salida_md">Cantidad</label>
                                                <input type="text" name="salida_md" id="salida_md" class="form-control" value="<?php echo $cantidad; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="almacen_entrada_md">Almacén Destino</label>
                                                <input class="form-control" name="almacen_entrada_md" id="almacen_entrada_md" value="<?php echo $almacen_destino; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3" hidden>
                                            <div class="form-group">
                                                <label for="entrada_md">Entrada</label>
                                                <input type="text" name="entrada_md" id="entrada_md" class="form-control" placeholder="Cantidad Entrada" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="op_destino">Asignar a:</label>
                                                <input type="text" name="op_destino" id="op_destino" class="form-control" value="<?php echo $op; ?>" required>
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
                                                <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control"><?php echo $observaciones; ?></textarea>
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
                                    <a href="<?php echo $URL."admin/almacen/mv_diario/smartled";?>" class="btn btn-default btn-block">Cancelar</a>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-success btn-block">Editar Movimiento</button>
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