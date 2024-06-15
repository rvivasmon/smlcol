<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nuevo Producto</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create.php" method="POST">
                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" id="fecha" name="fecha" class="form-control" placeholder="Fecha" readonly>
                                </div>
                            </div>

                            <script>
                                // Obtener la fecha actual en el formato yyyy-mm-dd
                                var today = new Date().toISOString().split('T')[0];
                                
                                // Establecer el valor del campo de fecha
                                document.getElementById('fecha').value = today;
                            </script>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="producto">Producto</label>
                                    <select name="producto" id="producto" class="form-control">
                                        <option value="">Seleccione un Producto</option>
                                        <?php 
                                        $query_productos = $pdo->prepare('SELECT id_producto, tipo_producto FROM productos ORDER BY tipo_producto ASC');
                                        $query_productos->execute();
                                        $productos = $query_productos->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($productos as $producto) {
                                            echo '<option value="' . $producto['id_producto'] . '">' . $producto['tipo_producto'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-2 campo Modulo">
                                            <div class="form-group">
                                                <label for="">Pitch</label>
                                                <select name="pitch" id="pitch" class="form-control">
                                                    <option value="">Seleccione un Pitch</option>
                                                    <?php 
                                                    $query_pitch = $pdo->prepare('SELECT DISTINCT pitch_modulo FROM caracteristicas_piezas WHERE pitch_modulo IS NOT NULL AND pitch_modulo <> "" ORDER BY pitch_modulo ASC');
                                                    $query_pitch->execute();
                                                    $pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($pitches as $pitch) {
                                                        echo '<option value="' . $pitch['pitch_modulo'] . '">' . $pitch['pitch_modulo'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 campo Modulo">
                                            <div class="form-group">
                                                <label for="">Serie</label>
                                                <input type="text" name="serie_modulo" class="form-control" placeholder="Serie">
                                            </div>
                                        </div>
                                        <div class="col-md-4 campo Modulo">
                                            <div class="form-group">
                                                <label for="">Referencia</label>
                                                <input type="text" name="referencia_modulo" class="form-control" placeholder="Referencia">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 campo Modulo">
                                            <div class="form-group">
                                                <label for="">Modelo</label>
                                                <select name="modelo_modulo" id="modelo_modulo" class="form-control">
                                                    <option value="">Seleccione un Modelo</option>
                                                    <?php 
                                                    $query_modelo = $pdo->prepare('SELECT DISTINCT modelo_modulo FROM caracteristicas_piezas WHERE modelo_modulo IS NOT NULL AND modelo_modulo <> "" ORDER BY modelo_modulo ASC');
                                                    $query_modelo->execute();
                                                    $modelos = $query_modelo->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($modelos as $modelo) {
                                                        echo '<option value="' . $modelo['modelo_modulo'] . '">' . $modelo['modelo_modulo'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 campo Modulo">
                                            <div class="form-group">
                                                <label for="">Medida X</label>
                                                <input type="text" name="medida_x" class="form-control" placeholder="Medida X">
                                            </div>
                                        </div>
                                        <div class="col-md-4 campo Modulo">
                                            <div class="form-group">
                                                <label for="">Medida Y</label>
                                                <input type="text" name="medida_y" class="form-control" placeholder="Medida Y">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 campo Control">
                                            <div class="form-group">
                                                <label for="">Marca</label>
                                                <select name="marca_control" id="marca_control" class="form-control">
                                                    <option value="">Seleccione una Marca</option>
                                                    <?php 
                                                    $query_marca_control = $pdo->prepare('SELECT DISTINCT marca_control FROM caracteristicas_piezas WHERE marca_control IS NOT NULL AND marca_control <> "" ORDER BY marca_control ASC');
                                                    $query_marca_control->execute();
                                                    $marcas_control = $query_marca_control->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($marcas_control as $marca) {
                                                        echo '<option value="' . $marca['marca_control'] . '">' . $marca['marca_control'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Control">
                                            <div class="form-group">
                                                <label for="">Serie</label>
                                                <input type="text" name="serie_control" class="form-control" placeholder="Serie">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Control">
                                            <div class="form-group">
                                                <label for="">Función</label>
                                                <select name="funcion_control" id="funcion_control" class="form-control">
                                                    <option value="">Seleccione una Función</option>
                                                    <?php 
                                                    $query_funcion_control = $pdo->prepare('SELECT DISTINCT funcion_control FROM caracteristicas_piezas WHERE funcion_control IS NOT NULL AND funcion_control <> "" ORDER BY funcion_control ASC');
                                                    $query_funcion_control->execute();
                                                    $funciones_control = $query_funcion_control->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($funciones_control as $funcion) {
                                                        echo '<option value="' . $funcion['funcion_control'] . '">' . $funcion['funcion_control'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 campo Fuente">
                                            <div class="form-group">
                                                <label for="">Marca</label>
                                                <select name="marca_fuente" id="marca_fuente" class="form-control">
                                                    <option value="">Seleccione una Marca</option>
                                                    <?php 
                                                    $query_marca_fuente = $pdo->prepare('SELECT DISTINCT marca_fuente FROM caracteristicas_piezas WHERE marca_fuente IS NOT NULL AND marca_fuente <> "" ORDER BY marca_fuente ASC');
                                                    $query_marca_fuente->execute();
                                                    $marcas_fuente = $query_marca_fuente->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($marcas_fuente as $marca) {
                                                        echo '<option value="' . $marca['marca_fuente'] . '">' . $marca['marca_fuente'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 campo Fuente">
                                            <div class="form-group">
                                                <label for="">Modelo</label>
                                                <input type="text" name="modelo_fuente" class="form-control" placeholder="Serie">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Fuente">
                                            <div class="form-group">
                                                <label for="">Tipo</label>
                                                <select name="tipo_fuente" id="tipo_fuente" class="form-control">
                                                    <option value="">Seleccione un Tipo</option>
                                                    <?php 
                                                    $query_tipo_fuente = $pdo->prepare('SELECT DISTINCT tipo_fuente FROM caracteristicas_piezas WHERE tipo_fuente IS NOT NULL AND tipo_fuente <> "" ORDER BY tipo_fuente ASC');
                                                    $query_tipo_fuente->execute();
                                                    $tipos_fuente = $query_tipo_fuente->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($tipos_fuente as $tipo) {
                                                        echo '<option value="' . $tipo['tipo_fuente'] . '">' . $tipo['tipo_fuente'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Fuente">
                                            <div class="form-group">
                                                <label for="">Voltaje Salida</label>
                                                <input type="text" name="voltaje_salida" class="form-control" placeholder="Modelo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 campo LCD">
                                            <div class="form-group">
                                                <label for="">Marca</label>
                                                <input type="text" name="marca" class="form-control" placeholder="Marca">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo LCD">
                                            <div class="form-group">
                                                <label for="">Modelo</label>
                                                <input type="text" name="serie" class="form-control" placeholder="Serie">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo LCD">
                                            <div class="form-group">
                                                <label for="">Tipo</label>
                                                <input type="text" name="referencia" class="form-control" placeholder="Referencia">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo LCD">
                                            <div class="form-group">
                                                <label for="">Voltaje Salida</label>
                                                <input type="text" name="modelo" class="form-control" placeholder="Modelo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 campo Accesorios">
                                            <div class="form-group">
                                                <label for="">Marca</label>
                                                <input type="text" name="marca" class="form-control" placeholder="Marca">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Accesorios">
                                            <div class="form-group">
                                                <label for="">Modelo</label>
                                                <input type="text" name="serie" class="form-control" placeholder="Serie">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Accesorios">
                                            <div class="form-group">
                                                <label for="">Tipo</label>
                                                <input type="text" name="referencia" class="form-control" placeholder="Referencia">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Accesorios">
                                            <div class="form-group">
                                                <label for="">Voltaje Salida</label>
                                                <input type="text" name="modelo" class="form-control" placeholder="Modelo">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">

                                </div>
                            </div>
                        </div>

                        <!-- Este es el campo oculto del ID del cliente seleccionado aquí -->
                        <input type="hidden" id="id_cliente" name="id_cliente">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Ubicación Almacén</label>
                                    <select name="ubicación_almacen" id="ubicación_almacen" class="form-control" >
                                        <?php 

                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <a href="<?php echo $URL."admin/almacen/inventario/";?>" class="btn btn-default btn-block">Cancelar</a>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear Producto</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../../../layout/admin/parte2.php');?>

<script>
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

