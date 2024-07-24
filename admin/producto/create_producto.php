<?php 
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');
include('../../layout/admin/parte1.php');
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="hora">Hora</label>
                                    <input type="time" id="hora" name="hora" class="form-control" placeholder="Hora" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="producto">Categoría</label>
                                    <select name="producto" id="producto" class="form-control">
                                        <option value="">Seleccione un Producto</option>
                                        <?php
                                        $query_producto = $pdo->prepare('SELECT id_producto, tipo_producto FROM t_productos ORDER BY tipo_producto ASC');
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
                                    <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-4 campo Modulo">
                                            <div class="form-group">
                                                <label for="modelo_modulo1">Modelo</label>
                                                <select id="modelo_modulo1" name="modelo_modulo1" class="form-control">
                                                    <option value="">Seleccione un modelo</option>
                                                    <?php 
                                                    $query_modelo = $pdo->prepare('SELECT id, modelo_modulo FROM t_tipo_producto WHERE modelo_modulo IS NOT NULL AND modelo_modulo != "" ORDER BY modelo_modulo ASC');
                                                    $query_modelo->execute();
                                                    $modelos = $query_modelo->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($modelos as $modelo): ?>
                                                        <option value="<?php echo $modelo['id']; ?>">
                                                            <?php echo $modelo['modelo_modulo']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 campo Modulo">
                                            <div class="form-group">
                                                <label for="pitch">Pitch</label>
                                                <input type="text" id="pitch" name="pitch" class="form-control" placeholder="Pitch">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 campo Modulo">
                                            <div class="form-group">
                                                <label for="medida_x">Tamaño X en mm</label>
                                                <input type="text" id="medida_x" name="medida_x" class="form-control" placeholder="Tamaño X" >
                                            </div>
                                        </div>
                                        <div class="col-md-4 campo Modulo">
                                            <div class="form-group">
                                                <label for="medida_y">Tamaño Y en mm</label>
                                                <input type="text" id="medida_y" name="medida_y" class="form-control" placeholder="Tamaño Y" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 campo Control">
                                            <div class="form-group">
                                                <label for="marca_control1">Marca</label>
                                                <input type="text" id="marca_control1" name="marca_control1" class="form-control" placeholder="Marca" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 campo Control">
                                            <div class="form-group">
                                                <label for="funcion_control">Función</label>
                                                <input type="text" id="funcion_control" name="funcion_control" class="form-control" placeholder="Función" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 campo Fuente">
                                            <div class="form-group">
                                                <label for="marca_fuente">Marca</label>
                                                <input type="text" id="marca_fuente" name="marca_fuente" class="form-control" placeholder="Marca" >
                                            </div>
                                        </div>

                                    </div>

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
                                        <div class="col-md-3 campo LCD">
                                            <div class="form-group">
                                                <label for="tipo_lcd">Tipo</label>
                                                <input type="text" id="tipo_lcd" name="tipo_lcd" class="form-control" placeholder="Tipo">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo LCD">
                                            <div class="form-group">
                                                <label for="voltaje_salida_lcd">Voltaje Salida</label>
                                                <input type="text" id="voltaje_salida_lcd" name="voltaje_salida_lcd" class="form-control" placeholder="Voltaje Salida">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 campo Accesorios">
                                            <div class="form-group">
                                                <label for="marca_accesorios">Marca</label>
                                                <input type="text" id="marca_accesorios" name="marca_accesorios" class="form-control" placeholder="Marca">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Accesorios">
                                            <div class="form-group">
                                                <label for="modelo_accesorios">Modelo</label>
                                                <input type="text" id="modelo_accesorios" name="modelo_accesorios" class="form-control" placeholder="Modelo">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Accesorios">
                                            <div class="form-group">
                                                <label for="tipo_accesorios">Tipo</label>
                                                <input type="text" id="tipo_accesorios" name="tipo_accesorios" class="form-control" placeholder="Tipo">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Accesorios">
                                            <div class="form-group">
                                                <label for="voltaje_salida_accesorios">Voltaje Salida</label>
                                                <input type="text" id="voltaje_salida_accesorios" name="voltaje_salida_accesorios" class="form-control" placeholder="Voltaje Salida">
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

<?php include('../../layout/admin/parte2.php');?>

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
