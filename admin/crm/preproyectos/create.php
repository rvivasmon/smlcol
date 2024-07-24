<?php 
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');
include('../../../layout/admin/parte1.php');

// Función para obtener el tipo de proyecto
function obtenerTipoProyecto($pdo, $id) {
    $query = $pdo->prepare('SELECT crm FROM prefijos WHERE id_prefijos = :id');
    $query->execute(['id' => $id]);
    $prefijo = $query->fetch(PDO::FETCH_ASSOC);
    return $prefijo['crm'];
}

// Obtener el año y el mes actuales en formato YYYYMM
$anio_mes = date('Ym');

// Inicializar el contador
$contador_ppc = 1;

// Obtener el último registro de la base de datos ordenado por año_mes de forma descendente
$query_ultimo_registro = $pdo->prepare('SELECT * FROM pre_proyecto ORDER BY anio_mes DESC, contador DESC LIMIT 1');
$query_ultimo_registro->execute();
$ultimo_registro_ppc = $query_ultimo_registro->fetch(PDO::FETCH_ASSOC);

// Verificar si hay un último registro
if ($ultimo_registro_ppc) {
    // Obtener el año y mes del último registro en formato YYYYMM
    $ultimo_anio_mes = date('Ym', strtotime($ultimo_registro_ppc['fecha']));

    // Si el mes y año del último registro son iguales al mes y año actuales, continuar con el contador
    if ($ultimo_anio_mes == $anio_mes) {
        $contador_ppc = $ultimo_registro_ppc['contador'] + 1;
    }
}

// Crear el ID PPC utilizando el año_mes y el contador
$id_ppc = $anio_mes . '-' . sprintf('%03d', $contador_ppc);

// Obtener el tipo de proyecto
$tipo_proyecto = obtenerTipoProyecto($pdo, 2); // Ajustar según necesidad

// Consultar estados para el select de Estado
$query_estado = $pdo->prepare('SELECT * FROM t_estado WHERE estado_ppc IS NOT NULL AND estado_ppc != "" ORDER BY estado_ppc ASC');
$query_estado->execute();
$estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);

// Consultar categorías de productos para el select de Categoría Producto
$query_producto = $pdo->prepare('SELECT * FROM t_categoria_productos WHERE categoria IS NOT NULL AND categoria != "" ORDER BY categoria ASC');
$query_producto->execute();
$productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);

// Consultar usos de productos para el select de Uso
$query_uso = $pdo->prepare('SELECT * FROM t_uso_productos WHERE uso_productos IS NOT NULL AND uso_productos != "" ORDER BY uso_productos ASC');
$query_uso->execute();
$usos = $query_uso->fetchAll(PDO::FETCH_ASSOC);

// Consultar Modelo de modulo para el select de Tipo Módulo
$query_modelmod = $pdo->prepare('SELECT * FROM t_tipo_producto WHERE modelo_modulo IS NOT NULL AND modelo_modulo != "" ORDER BY modelo_modulo ASC');
$query_modelmod->execute();
$modelo_modulo = $query_modelmod->fetchAll(PDO::FETCH_ASSOC);

// Consultar tipos de productos para el select de Tipo Producto
$query_tipo_producto = $pdo->prepare('SELECT * FROM t_tipo_producto WHERE tipo_producto21 IS NOT NULL AND tipo_producto21 != "" ORDER BY tipo_producto21 ASC');
$query_tipo_producto->execute();
$tipos_productos = $query_tipo_producto->fetchAll(PDO::FETCH_ASSOC);

// Consultar pitches para el select de Pitch
$query_pitch = $pdo->prepare('SELECT * FROM caracteristicas_modulos WHERE pitch IS NOT NULL AND pitch != "" ORDER BY pitch ASC');
$query_pitch->execute();
$pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);

// Obtener la fecha y la hora actuales
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Creación Pre Proyecto</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <div class="card card-blue">
        <div class="card-header">
            Introduzca la información correspondiente
        </div>
        <div class="card-body">
            <form action="controller_create.php" method="POST" onsubmit="return validarFormulario()" id="formulario_creacion_ppc">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="fecha" class="d-block mb-0">Fecha</label>
                                    <input type="date" id="fecha" name="fecha" class="form-control" value="<?php echo $fecha_actual; ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="hora" class="d-block mb-0">Hora</label>
                                    <input type="time" id="hora" name="hora" class="form-control" value="<?php echo $hora_actual; ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="tipo_proyecto" class="d-block mb-0">Tipo Proyecto</label>
                                    <select name="tipo_proyecto" id="tipo_proyecto" class="form-control" readonly>
                                        <option value="<?php echo htmlspecialchars($tipo_proyecto); ?>"><?php echo htmlspecialchars($tipo_proyecto); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="id_proyecto" class="d-block mb-0">Id Proyecto</label>
                                    <input type="text" name="id_proyecto" id="id_proyecto" class="form-control" value="<?php echo htmlspecialchars($id_ppc); ?>" readonly>
                                </div>
                                <div class="col-md-5">
                                    <label for="ciudad" class="d-block mb-0">Ciudad</label>
                                    <input type="text" name="ciudad" id="ciudad" class="form-control">
                                </div>
                                <div class="col-md-0">
                                    <input type="hidden" name="idusuario2" value="<?php echo $sesion_usuario['id']; ?>">
                                    <input type="hidden" name="anio_mes" value="<?php echo $anio_mes; ?>">
                                    <input type="hidden" name="contador" value="<?php echo $contador_ppc; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nombre_proyecto" class="d-block mb-0">Proyecto</label>
                                    <input type="text" name="nombre_proyecto" class="form-control" placeholder="Asignar" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="cliente" class="d-block mb-0">Cliente</label>
                                    <input type="text" name="cliente" class="form-control" placeholder="Cliente" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="contacto_cliente" class="d-block mb-0">Contacto</label>
                                    <input type="text" name="contacto_cliente" class="form-control" placeholder="Contacto" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono_contacto" class="d-block mb-0">Teléfono Contacto</label>
                                    <input type="text" name="telefono_contacto" class="form-control" placeholder="Teléfono">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="asesor_encargado" class="d-block mb-0">Asesor Encargado</label>
                                    <input type="text" name="asesor_encargado" class="form-control" value="<?php echo htmlspecialchars($sesion_usuario['nombre']); ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7" style="border: 0.10px solid #808080; padding: 15px;">
                        <div class="form-group cloned-section">
                            <div class="row">
                                <div class="col-md-4 items_pre">
                                    <div class="form-group">
                                        <label for="items" class="d-block mb-0">Items</label>
                                        <input type="text" name="items[]" class="form-control" value="1" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 categoria_producto">
                                    <div class="form-group">
                                        <label for="categoria_producto" class="d-block mb-0">Categoría Producto</label>
                                        <select id="categoria_producto" name="categoria_producto[]" class="form-control" required>
                                            <option value="">Seleccione una categoría</option>
                                            <?php foreach ($productos as $producto) { ?>
                                                <option value="<?php echo htmlspecialchars($producto['id_prod_terminado']); ?>"><?php echo htmlspecialchars($producto['categoria']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 tipo_producto">
                                    <div class="form-group">
                                        <label for="tipo_producto" class="d-block mb-0">Tipo Producto</label>
                                        <select id="tipo_producto" name="tipo_producto[]" class="form-control" required>
                                            <option value="">Seleccione el tipo de producto</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 uso">
                                    <div class="form-group">
                                        <label for="uso" class="d-block mb-0">Uso</label>
                                        <select id="uso" name="uso[]" class="form-control" required>
                                            <option value="">Seleccione el uso</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 tipo_modulo">
                                    <div class="form-group">
                                        <label for="tipo_modulo" class="d-block mb-0">Tipo Módulo</label>
                                        <select id="tipo_modulo" name="tipo_modulo[]" class="form-control" required>
                                            <option value="">Seleccione el tipo de módulo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 pitch">
                                    <div class="form-group">
                                        <label for="pitch" class="d-block mb-0">Pitch</label>
                                        <select id="pitch" name="pitch[]" class="form-control" required>
                                            <option value="">Seleccione el pitch</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="items-container"></div> <!-- Contenedor para los ítems agregados dinámicamente -->

                        <div class="form-group">
                            <button type="button" class="btn btn-success" id="add-item">Añadir Item</button>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="comentarios" class="d-block mb-0">Comentarios</label>
                        <textarea class="form-control" name="comentarios" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="../preproyectos/" class="btn btn-default">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear Pre Proyecto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('add-item').addEventListener('click', function() {
        var originalSection = document.querySelector('.cloned-section');
        var clonedSection = originalSection.cloneNode(true);

        // Limpiar los valores de los campos en la sección clonada
        var inputs = clonedSection.querySelectorAll('input, select');
        inputs.forEach(function(input) {
            if (input.type !== 'hidden') {
                input.value = '';
            }
        });

        // Incrementar el valor del campo 'items'
        var itemsField = clonedSection.querySelector('input[name="items[]"]');
        var currentItemValue = document.querySelectorAll('input[name="items[]"]').length;
        itemsField.value = currentItemValue + 1;

        // Agregar la sección clonada al contenedor de ítems
        document.getElementById('items-container').appendChild(clonedSection);
    });
</script>

<script>
    function validarFormulario() {
        var tipoProyecto = document.getElementById('tipo_proyecto').value;
        var fecha = document.getElementById('fecha').value;
        var hora = document.getElementById('hora').value;
        var ciudad = document.getElementById('ciudad').value;
        var nombreProyecto = document.querySelector('input[name="nombre_proyecto"]').value;
        var cliente = document.querySelector('input[name="cliente"]').value;
        var contactoCliente = document.querySelector('input[name="contacto_cliente"]').value;
        var telefonoContacto = document.querySelector('input[name="telefono_contacto"]').value;

        if (!tipoProyecto || !fecha || !hora || !ciudad || !nombreProyecto || !cliente || !contactoCliente || !telefonoContacto) {
            alert('Por favor, complete todos los campos obligatorios.');
            return false;
        }

        return true;
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('categoria_producto').addEventListener('change', function() {
            var categoriaId = this.value;
            if (categoriaId) {
                fetch('get_tipo_producto.php?id_categoria=' + categoriaId)
                    .then(response => response.json())
                    .then(data => {
                        var tipoProductoSelect = document.getElementById('tipo_producto');
                        tipoProductoSelect.innerHTML = '<option value="">Seleccione el tipo de producto</option>';
                        data.forEach(item => {
                            tipoProductoSelect.innerHTML += '<option value="' + item.id + '">' + item.tipo_producto21 + '</option>';
                        });
                    });
                
                fetch('get_uso.php?id_categoria=' + categoriaId)
                    .then(response => response.json())
                    .then(data => {
                        var usoSelect = document.getElementById('uso');
                        usoSelect.innerHTML = '<option value="">Seleccione el uso</option>';
                        data.forEach(item => {
                            usoSelect.innerHTML += '<option value="' + item.id + '">' + item.uso_productos + '</option>';
                        });
                    });
            } else {
                // Limpia los selects si no hay categoría seleccionada
                document.getElementById('tipo_producto').innerHTML = '<option value="">Seleccione el tipo de producto</option>';
                document.getElementById('uso').innerHTML = '<option value="">Seleccione el uso</option>';
            }
        });

        document.getElementById('uso').addEventListener('change', function() {
            var usoId = this.value;
            if (usoId) {
                fetch('get_tipo_modulo.php?id_uso=' + usoId)
                    .then(response => response.json())
                    .then(data => {
                        var tipoModuloSelect = document.getElementById('tipo_modulo');
                        tipoModuloSelect.innerHTML = '<option value="">Seleccione el tipo de módulo</option>';
                        data.forEach(item => {
                            tipoModuloSelect.innerHTML += '<option value="' + item.id + '">' + item.modelo_modulo + '</option>';
                        });
                    });
            } else {
                // Limpia el select si no hay uso seleccionado
                document.getElementById('tipo_modulo').innerHTML = '<option value="">Seleccione el tipo de módulo</option>';
            }
        });

        document.getElementById('tipo_modulo').addEventListener('change', function() {
            var tipoModuloId = this.value;
            if (tipoModuloId) {
                fetch('get_pitch.php?id_tipo_modulo=' + tipoModuloId)
                    .then(response => response.json())
                    .then(data => {
                        var pitchSelect = document.getElementById('pitch');
                        pitchSelect.innerHTML = '<option value="">Seleccione el pitch</option>';
                        data.forEach(item => {
                            pitchSelect.innerHTML += '<option value="' + item.id_car_mod + '">' + item.pitch + '</option>';
                        });
                    });
            } else {
                // Limpia el select si no hay tipo de módulo seleccionado
                document.getElementById('pitch').innerHTML = '<option value="">Seleccione el pitch</option>';
            }
        });
    });

    
</script>



<?php include('../../../layout/admin/parte2.php'); ?>
