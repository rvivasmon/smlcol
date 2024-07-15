<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

// Función para obtener el tipo de proyecto
function obtenerTipoProyecto($pdo, $id)
{
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
$query_estado = $pdo->prepare('SELECT * FROM estado WHERE estado_ppc IS NOT NULL AND estado_ppc != "" ORDER BY estado_ppc ASC');
$query_estado->execute();
$estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);

// Consultar categorías de productos para el select de Categoría Producto
$query_producto = $pdo->prepare('SELECT * FROM productos_terminados WHERE categoria IS NOT NULL AND categoria != "" ORDER BY categoria ASC');
$query_producto->execute();
$productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);

// Consultar usos de productos para el select de Uso
$query_uso = $pdo->prepare('SELECT * FROM productos_terminados WHERE uso_leds IS NOT NULL AND uso_leds != "" ORDER BY uso_leds ASC');
$query_uso->execute();
$usos = $query_uso->fetchAll(PDO::FETCH_ASSOC);

// Consultar tipos de productos para el select de Tipo Producto
$query_tipo_producto = $pdo->prepare('SELECT * FROM productos_terminados WHERE tipo_producto IS NOT NULL AND tipo_producto != "" ORDER BY tipo_producto ASC');
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
                                <div class="col-md-6">
                                    <label for="id_proyecto" class="d-block mb-0">Id Proyecto</label>
                                    <input type="text" name="id_proyecto" id="id_proyecto" class="form-control" value="<?php echo htmlspecialchars($id_ppc); ?>" readonly>
                                </div>
                                <div class="col-md-0">
                                    <input type="hidden" name="idusuario2" value="<?php echo $sesion_usuario['id']; ?>">
                                </div>
                                <div class="col-md-0">
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
                                <div class="col-md-6">
                                    <label for="buscador" class="d-block mb-0">Búsqueda por PPC</label>
                                    <select name="buscador_ppc" id="buscador_ppc" class="form-control">
                                        <!-- Opciones cargadas dinámicamente con JavaScript -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7" style="border: 0.10px solid #808080; padding: 15px;">
                        <div class="form-group  cloned-section">
                            <div class="row">
                                <div class="col-md-3 items_pre">
                                    <label for="items" class="d-block mb-0">Items</label>
                                    <input type="text" name="items[]" class="form-control" value="1" readonly>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="pantallas" class="d-block mb-0">Cantidad de Pantallas</label>
                                    <input type="number" name="pantallas[]" class="form-control" required>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="estado" class="d-block mb-0">Estado</label>
                                    <select name="estado[]" class="form-control">
                                        <option value="">Seleccione Estado</option>
                                        <?php foreach ($estados as $estado) : ?>
                                            <option value="<?php echo htmlspecialchars($estado['estado_ppc']); ?>"><?php echo htmlspecialchars($estado['estado_ppc']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="categoria_producto" class="d-block mb-0">Categoría Producto</label>
                                    <select name="categoria_producto[]" class="form-control">
                                        <option value="">Seleccione Categoría</option>
                                        <?php foreach ($productos as $producto) : ?>
                                            <option value="<?php echo htmlspecialchars($producto['categoria']); ?>"><?php echo htmlspecialchars($producto['categoria']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="uso" class="d-block mb-0">Uso</label>
                                    <select name="uso[]" class="form-control">
                                        <option value="">Seleccione Uso</option>
                                        <?php foreach ($usos as $uso) : ?>
                                            <option value="<?php echo htmlspecialchars($uso['uso_leds']); ?>"><?php echo htmlspecialchars($uso['uso_leds']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="tipo_producto" class="d-block mb-0">Tipo Producto</label>
                                    <select name="tipo_producto[]" class="form-control">
                                        <option value="">Seleccione Tipo</option>
                                        <?php foreach ($tipos_productos as $tipo_producto) : ?>
                                            <option value="<?php echo htmlspecialchars($tipo_producto['tipo_producto']); ?>"><?php echo htmlspecialchars($tipo_producto['tipo_producto']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="pitch" class="d-block mb-0">Pitch</label>
                                    <select name="pitch[]" class="form-control">
                                        <option value="">Seleccione Pitch</option>
                                        <?php foreach ($pitches as $pitch) : ?>
                                            <option value="<?php echo htmlspecialchars($pitch['pitch']); ?>"><?php echo htmlspecialchars($pitch['pitch']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="x_disponible" class="d-block mb-0">X Disponible</label>
                                    <input type="number" name="x_disponible[]" class="form-control" required>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="y_disponible" class="d-block mb-0">Y Disponible</label>
                                    <input type="number" name="y_disponible[]" class="form-control" required>
                                </div>
                                <div class="col-md-9 items_pre">
                                    <label for="justificacion" class="d-block mb-0">Justificación</label>
                                    <textarea name="justificacion[]" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" id="add_item" class="btn btn-primary">Añadir Item</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="<?php echo $URL."admin/crm/preproyectos";?>" class="btn btn-default btn-block">Cancelar</a>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear Pre-Proyecto</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

                        <div style="display: none;" id="item-template">
                            <hr>
                            <div class="row">
                                <div class="col-md-3 items_pre">
                                    <label for="items" class="d-block mb-0">Items</label>
                                    <input type="text" name="items[]" class="form-control" value="1" readonly>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="pantallas" class="d-block mb-0">Cantidad de Pantallas</label>
                                    <input type="number" name="pantallas[]" class="form-control" required>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="estado" class="d-block mb-0">Estado</label>
                                    <select name="estado[]" class="form-control">
                                        <option value="">Seleccione Estado</option>
                                        <?php foreach ($estados as $estado) : ?>
                                            <option value="<?php echo htmlspecialchars($estado['estado_ppc']); ?>"><?php echo htmlspecialchars($estado['estado_ppc']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="categoria_producto" class="d-block mb-0">Categoría Producto</label>
                                    <select name="categoria_producto[]" class="form-control">
                                        <option value="">Seleccione Categoría</option>
                                        <?php foreach ($productos as $producto) : ?>
                                            <option value="<?php echo htmlspecialchars($producto['categoria']); ?>"><?php echo htmlspecialchars($producto['categoria']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="uso" class="d-block mb-0">Uso</label>
                                    <select name="uso[]" class="form-control">
                                        <option value="">Seleccione Uso</option>
                                        <?php foreach ($usos as $uso) : ?>
                                            <option value="<?php echo htmlspecialchars($uso['uso_leds']); ?>"><?php echo htmlspecialchars($uso['uso_leds']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="tipo_producto" class="d-block mb-0">Tipo Producto</label>
                                    <select name="tipo_producto[]" class="form-control">
                                        <option value="">Seleccione Tipo</option>
                                        <?php foreach ($tipos_productos as $tipo_producto) : ?>
                                            <option value="<?php echo htmlspecialchars($tipo_producto['tipo_producto']); ?>"><?php echo htmlspecialchars($tipo_producto['tipo_producto']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="pitch" class="d-block mb-0">Pitch</label>
                                    <select name="pitch[]" class="form-control">
                                        <option value="">Seleccione Pitch</option>
                                        <?php foreach ($pitches as $pitch) : ?>
                                            <option value="<?php echo htmlspecialchars($pitch['pitch']); ?>"><?php echo htmlspecialchars($pitch['pitch']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="x_disponible" class="d-block mb-0">X Disponible</label>
                                    <input type="number" name="x_disponible[]" class="form-control" required>
                                </div>
                                <div class="col-md-3 items_pre">
                                    <label for="y_disponible" class="d-block mb-0">Y Disponible</label>
                                    <input type="number" name="y_disponible[]" class="form-control" required>
                                </div>
                                <div class="col-md-9 items_pre">
                                    <label for="justificacion" class="d-block mb-0">Justificación</label>
                                    <textarea name="justificacion[]" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemCount = 1;
        const itemTemplate = document.getElementById('item-template');

        // Función para agregar un nuevo item
        document.getElementById('add_item').addEventListener('click', function() {
            const newSection = itemTemplate.cloneNode(true);
            newSection.style.display = 'block'; // Mostrar la sección clonada

            // Actualizar el valor del nuevo item
            itemCount++;
            const itemInputs = newSection.querySelectorAll('input[name="items[]"]');
            itemInputs.forEach(input => {
                input.value = itemCount;
            });

            // Insertar la nueva sección antes del botón "Añadir Item"
            const addBtn = document.getElementById('add_item');
            addBtn.parentNode.insertBefore(newSection, addBtn);
        });

        // Reiniciar el contador de items cuando cambie el ID del proyecto
        document.getElementById('id_proyecto').addEventListener('change', function() {
            itemCount = 1;
            const itemInputs = document.querySelectorAll('input[name="items[]"]');
            itemInputs.forEach((input, index) => {
                input.value = index + 1;
            });
        });
    });
</script>

<?php include('../../../layout/admin/parte2.php'); ?>