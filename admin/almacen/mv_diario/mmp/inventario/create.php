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
                    <h1 class="m-0">Ingresas Producto Almacén</h1>
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
                                    <label for="fecha">Hora</label>
                                    <input type="time" id="hora" name="hora" class="form-control" placeholder="Hora" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="categoria">Categoría</label>
                                    <select name="categoria" id="categoria" class="form-control" onchange="cargarProductos()">
                                        <option value="">Seleccione una Categoría</option>
                                        <?php 
                                        $query_producto = $pdo->prepare('
                                            SELECT id, tipo_prod_mmp 
                                            FROM t_tipo_producto 
                                            WHERE tipo_prod_mmp IS NOT NULL 
                                            AND tipo_prod_mmp != "" 
                                            AND habilitar_mmp = 1 
                                            ORDER BY tipo_prod_mmp ASC
                                        ');
                                        $query_producto->execute();
                                        $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($productos as $producto) {
                                            echo '<option value="' . $producto['id'] . '">' . $producto['tipo_prod_mmp'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Producto</label>
                                    <select name="producto" id="producto" class="form-control">
                                        <option value="">Seleccione un Modelo</option>
                                        <?php 
                                        $query_modelo = $pdo->prepare('SELECT id_producto, producto FROM t_productos WHERE producto IS NOT NULL AND producto <> "" AND habilitar_mmp = 1 ORDER BY producto ASC');
                                        $query_modelo->execute();
                                        $modelos = $query_modelo->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($modelos as $modelo) {
                                            $id_producto = $modelo['id_producto'];
                                            $t_producto = $modelo['producto'];
                                        ?>
                                            <option value="<?php echo $id_producto;?>"><?php echo $t_producto; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tamano_modulo">Modulo Usado</label>
                                    <select name="tamano_modulo" id="tamano_modulo" class="form-control">
                                        <option value="">Seleccione un Modelo</option>
                                        <?php 
                                        $query_modelo = $pdo->prepare('SELECT id, tamanos_modulos FROM tabla_tamanos_modulos WHERE tamanos_modulos IS NOT NULL AND tamanos_modulos <> "" AND habilitar_tamano = 1 ORDER BY tamanos_modulos ASC');
                                        $query_modelo->execute();
                                        $modelos = $query_modelo->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($modelos as $modelo) {
                                            $id_producto = $modelo['id'];
                                            $t_producto = $modelo['tamanos_modulos'];
                                        ?>
                                            <option value="<?php echo $id_producto;?>"><?php echo $t_producto; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-0">
                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                    <label for=""></label>
                                    <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>                                            
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="movimiento">Tipo de Movimiento</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="entrada" name="movimiento" id="movimiento" value="entrada" required>
                                        <label class="form-check-label" for="entrada">
                                            Entrada
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="salida" name="movimiento" id="movimiento" value="salida">
                                        <label class="form-check-label" for="salida">
                                            Salida
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="ubicacion">Ubicacion</label>
                                    <input type="text" name="ubicacion" id="ubicacion" class="form-control" placeholder="Ubicacion" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 campo Modulo">
                                            <div class="form-group">
                                                <label for="">Observaciones</label>
                                                <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control"></textarea>
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
                                    <a href="<?php echo $URL."admin/almacen/mv_diario/mmp";?>" class="btn btn-default btn-block">Cancelar</a>
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
</script>

<script>
function cargarProductos() {
    const categoriaId = document.getElementById('categoria').value;
    const productoSelect = document.getElementById('producto');

    // Limpiar el select de productos
    productoSelect.innerHTML = '<option value="">Seleccione un Modelo</option>';

    // Verificar que se haya seleccionado una categoría
    if (categoriaId) {
        // Realizar la llamada AJAX
        fetch('get_productos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'categoria_id=' + encodeURIComponent(categoriaId),
        })
        .then(response => response.json())
        .then(data => {
            // Llenar el select con los productos filtrados
            data.forEach(producto => {
                const option = document.createElement('option');
                option.value = producto.id_producto;
                option.textContent = producto.producto;
                productoSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
    }
}
</script>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        const entrada = document.getElementById('entrada').checked;
        const salida = document.getElementById('salida').checked;

        if (!entrada && !salida) {
            event.preventDefault(); // Detener el envío del formulario
            alert('Debe seleccionar una opción: Entrada o Salida.');
        }
    });
</script>