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
$query_estado = $pdo->prepare('SELECT * FROM t_estado WHERE estado_ppc IS NOT NULL AND estado_ppc != "" ORDER BY estado_ppc ASC');
$query_estado->execute();
$estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);

// Consultar categorías de productos para el select de Categoría Producto
$query_producto = $pdo->prepare('SELECT * FROM t_categoria_productos WHERE categoria IS NOT NULL AND categoria != "" ORDER BY categoria ASC');
$query_producto->execute();
$productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);

// Consultar usos de productos para el select de Uso
$query_uso = $pdo->prepare('SELECT * FROM t_uso_productos WHERE producto_uso IS NOT NULL AND producto_uso != "" ORDER BY producto_uso ASC');
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
                    <h1 class="m-0">Información Pre - Proyecto</h1>
                </div>
            </div>

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create.php" method="POST" id="formulario_creacion_ppc">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group head-section">
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
                                            <input type="text" name="ciudad" id="ciudad" class="form-control" required>
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

                            <div class="col-md-7">
                                <div class="form-group">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group cloned-section">
                                                <div class="row">
                                                    <div class="col-md-4 items_pre">
                                                        <div class="form-group">
                                                            <label for="items" class="d-block mb-0">Items</label>
                                                            <input type="text" name="items[]" class="form-control" value="1" readonly>
                                                            <input type="hidden" id="item_data" name="item_data">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 items_pre">
                                                        <div class="form-group">
                                                            <label for="pantallas" class="d-block mb-0">Cantidad de Pantallas</label>
                                                            <input type="text" name="pantallas[]" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 items_pre">
                                                        <label for="estado" class="d-block mb-0">Estado</label>
                                                        <select name="estado[]" class="form-control">
                                                            <option value="1">Nuevo</option>
                                                            <?php foreach ($estados as $estado) : ?>
                                                                <option value="<?php echo htmlspecialchars($estado['id']); ?>" <?php echo ($estado['id'] == 1) ? 'selected' : ''; ?>>
                                                                    <?php echo htmlspecialchars($estado['estado_ppc']); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 items_pre">
                                                        <div class="form-group">
                                                            <label for="categoria_producto" class="d-block mb-0">Categoría Producto</label>
                                                            <select name="categoria_producto[]" id="categoria_producto_<?php echo $contador_ppc; ?>" class="form-control" onchange="cargarDatosRelacionados(this.value, <?php echo $contador_ppc; ?>)">
                                                                <option value="">Seleccione Categoría</option>
                                                                <?php foreach ($productos as $producto) : ?>
                                                                    <?php if ($producto['id_prod_terminado'] != 5) : // Excluye el registro con id 5 ?>
                                                                        <option value="<?php echo htmlspecialchars($producto['id_prod_terminado']); ?>"><?php echo htmlspecialchars($producto['categoria']); ?></option>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 items_pre">
                                                        <div class="form-group">
                                                            <label for="uso" class="d-block mb-0">Uso</label>
                                                            <select name="uso[]" id="uso_<?php echo $contador_ppc; ?>" class="form-control">
                                                                <option value="">Seleccione Uso</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 items_pre">
                                                        <div class="form-group">
                                                            <label for="tipo_producto" class="d-block mb-0">Tipo Producto</label>
                                                            <select name="tipo_producto[]" id="tipo_producto_<?php echo $contador_ppc; ?>" class="form-control">
                                                                <option value="">Seleccione Tipo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 items_pre" hidden>
                                                        <div class="form-group">
                                                            <label for="tipo_modulo" class="d-block mb-0">Tipo Módulo</label>
                                                            <select name="tipo_modulo[]" id="tipo_modulo_<?php echo $contador_ppc; ?>" class="form-control">
                                                                <option value="">Seleccione Tipo de Módulo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 items_pre" hidden>
                                                        <div class="form-group">
                                                            <label for="pitch" class="d-block mb-0">Pitch</label>
                                                            <select name="pitch[]" id="pitch_<?php echo $contador_ppc; ?>" class="form-control">
                                                                <option value="">Seleccione Pitch</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre">
                                                        <div class="form-group">
                                                            <label for="x_disponible" class="d-block mb-0">X Dispo en mts</label>
                                                            <input type="text" name="x_dispo_mts[]" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre">
                                                        <div class="form-group">
                                                            <label for="y_disponible" class="d-block mb-0">Y Dispo en mts</label>
                                                            <input type="text" name="y_dispo_mts[]" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre">
                                                        <div class="form-group">
                                                            <label for="x_disponible" class="d-block mb-0">X Dispo en mm</label>
                                                            <input type="text" name="x_disponible[]" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre">
                                                        <div class="form-group">
                                                            <label for="y_disponible" class="d-block mb-0">Y Dispo en mm</label>
                                                            <input type="text" name="y_disponible[]" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 items_pre">
                                                        <div class="form-group">
                                                            <label for="justificacion" class="d-block mb-0">Observaciones</label>
                                                            <textarea name="justificacion[]" class="form-control" rows="2"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <!-- Botón para añadir item -->
                                            <div class="form-group">
                                                <button type="button" id="btn_add_item" class="btn btn-primary">Añadir Item</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!-- Tabla donde se mostrarán los items añadidos -->
                                    <div class="table-responsive">
                                        <table id="table_items" class="table table-striped table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th># Pantallas</th>
                                                    <th>Estado</th>
                                                    <th>Categoría</th>
                                                    <th>Uso</th>
                                                    <th>T. Producto</th>
                                                    <th hidden>T. Modelo Módulo</th>
                                                    <th hidden>Pitch</th>
                                                    <th>X Disponible</th>
                                                    <th>Y Disponible</th>
                                                    <th>Justificación</th>
                                                    <th><center>Acciones</center></th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_body">
                                                <!-- Los items añadidos se mostrarán aquí -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

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
        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../../../layout/admin/parte2.php'); ?>

<script>
    document.getElementById('anadirItem').addEventListener('click', function() {
    // Selecciona el campo "estado" y establece su valor en "1" (o "Nuevo")
    document.getElementById('estado').value = '1';
    
    // Aquí puedes agregar el código para manejar el añadir ítem
});
</script>

<script>
document.getElementById('btn_add_item').addEventListener('click', function() {
    // Obtener los valores de los campos
    const cantidadPantallas = document.querySelector('input[name="pantallas[]"]').value;
    const estado = document.querySelector('select[name="estado[]"]').value;
    const categoria = document.querySelector('select[name="categoria_producto[]"]').value;
    const uso = document.querySelector('select[name="uso[]"]').value;
    const tipoProducto = document.querySelector('select[name="tipo_producto[]"]').value;
    const tipoModulo = document.querySelector('select[name="tipo_modulo[]"]').value;
    const pitch = document.querySelector('select[name="pitch[]"]').value;
    const xDisponible = document.querySelector('input[name="x_disponible[]"]').value;
    const yDisponible = document.querySelector('input[name="y_disponible[]"]').value;
    const justificacion = document.querySelector('textarea[name="justificacion[]"]').value;

    // Validar que los campos obligatorios no estén vacíos
    if (!cantidadPantallas || !estado || !categoria || !uso || !xDisponible || !yDisponible) {
    alert("Por favor, complete todos los campos obligatorios antes de añadir un ítem.");
    return; // Detener la ejecución si hay campos vacíos
    }

    // Crear una nueva fila en la tabla
    const tableBody = document.getElementById('table_body');
    const rowCount = tableBody.rows.length;
    const newRow = tableBody.insertRow(rowCount);

    newRow.innerHTML = `
        <td>${rowCount + 1}</td>
        <td>${cantidadPantallas}</td>
        <td>${estado}</td>
        <td>${categoria}</td>
        <td>${uso}</td>
        <td>${tipoProducto}</td>
        <td hidden>${tipoModulo}</td>
        <td hidden>${pitch}</td>
        <td>${xDisponible}</td>
        <td>${yDisponible}</td>
        <td>${justificacion}</td>
        <td>
            <center>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>
            </center>
        </td>
    `;

    // Limpiar los campos del formulario
    document.querySelector('input[name="pantallas[]"]').value = '';
    document.querySelector('select[name="estado[]"]').selectedIndex = 0;
    document.querySelector('select[name="categoria_producto[]"]').selectedIndex = 0;
    document.querySelector('select[name="uso[]"]').selectedIndex = 0;
    document.querySelector('select[name="tipo_producto[]"]').selectedIndex = 0;
    document.querySelector('select[name="tipo_modulo[]"]').selectedIndex = 0;
    document.querySelector('select[name="pitch[]"]').selectedIndex = 0;
    document.querySelector('input[name="x_disponible[]"]').value = '';
    document.querySelector('input[name="y_disponible[]"]').value = '';
    document.querySelector('textarea[name="justificacion[]"]').value = '';
});

function eliminarFila(btn) {
    const row = btn.closest('tr');
    row.remove();
}


// Añadir el siguiente código para guardar los datos de la tabla en el campo oculto
document.getElementById('formulario_creacion_ppc').addEventListener('submit', function() {
    const rows = document.querySelectorAll('#table_body tr');
    const itemData = [];

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const rowData = {
            item: cells[0].innerText,
            pantallas: cells[1].innerText,
            estado: cells[2].innerText,
            categoria_producto: cells[3].innerText,
            uso: cells[4].innerText,
            tipo_producto: cells[5].innerText,
            tipo_modulo: cells[6].innerText,
            pitch: cells[7].innerText,
            x_disponible: cells[8].innerText,
            y_disponible: cells[9].innerText,
            justificacion: cells[10].innerText
        };
        itemData.push(rowData);
    });

    document.getElementById('item_data').value = JSON.stringify(itemData);
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Función para cargar los datos relacionados
    function cargarDatosRelacionados(categoria, tipo) {

        // Cargar usos basados en la categoría
        if (categoria) {
            fetch(`filter_data.php?categoria=${categoria}&tipo=uso`)
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Verifica la estructura de los datos recibidos
                    let usoSelect = document.querySelector(`#uso_${tipo}`);
                    usoSelect.innerHTML = '<option value="">Seleccione Uso</option>';
                    data.forEach(uso => {
                        usoSelect.innerHTML += `<option value="${uso.id_uso}">${uso.producto_uso}</option>`;
                    });
                });
        } else {
            document.querySelector(`#uso_${tipo}`).innerHTML = '<option value="">Seleccione Uso</option>';
        }

        // Cargar tipo producto basado en la categoría
        if (categoria) {
            fetch(`filter_data.php?categoria=${categoria}&tipo=producto`)
                .then(response => response.json())
                .then(data => {
                    let tipoProductoSelect = document.querySelector(`#tipo_producto_${tipo}`);
                    tipoProductoSelect.innerHTML = '<option value="">Seleccione Tipo</option>';
                    data.forEach(tipoProducto => {
                        tipoProductoSelect.innerHTML += `<option value="${tipoProducto.id}">${tipoProducto.tipo_producto21}</option>`;
                    });
                });
        } else {
            document.querySelector(`#tipo_producto_${tipo}`).innerHTML = '<option value="">Seleccione Tipo</option>';
        }
    }

    // Función para cargar el tipo de módulo basado en el uso
    function cargarTipoModulo(uso, tipo) {
        if (uso) {
            fetch(`filter_data.php?uso=${uso}`)
                .then(response => response.json())
                .then(data => {
                    let tipoModuloSelect = document.querySelector(`#tipo_modulo_${tipo}`);
                    tipoModuloSelect.innerHTML = '<option value="">Seleccione Tipo de Módulo</option>';
                    data.forEach(tipoModulo => {
                        tipoModuloSelect.innerHTML += `<option value="${tipoModulo.id}">${tipoModulo.modelo_modulo}</option>`;
                    });
                });
        } else {
            document.querySelector(`#tipo_modulo_${tipo}`).innerHTML = '<option value="">Seleccione Tipo de Módulo</option>';
        }
    }

    // Función para cargar el pitch basado en el tipo de módulo
    function cargarPitch(tipoModulo, tipo) {
        if (tipoModulo) {
            fetch(`filter_data.php?tipo_modulo=${tipoModulo}`)
                .then(response => response.json())
                .then(data => {
                    let pitchSelect = document.querySelector(`#pitch_${tipo}`);
                    pitchSelect.innerHTML = '<option value="">Seleccione Pitch</option>';
                    data.forEach(pitch => {
                        pitchSelect.innerHTML += `<option value="${pitch.id_car_mod}">${pitch.pitch}</option>`;
                    });
                });
        } else {
            document.querySelector(`#pitch_${tipo}`).innerHTML = '<option value="">Seleccione Pitch</option>';
        }
    }

    // Agregar event listeners a los campos
    document.addEventListener('change', function(event) {
        if (event.target.name === 'categoria_producto[]') {
            let tipo = event.target.id.split('_').pop();
            let categoria = event.target.value;
            cargarDatosRelacionados(categoria, tipo);
        }

        if (event.target.name === 'uso[]') {
            let tipo = event.target.id.split('_').pop();
            let uso = event.target.value;
            cargarTipoModulo(uso, tipo);
        }

        if (event.target.name === 'tipo_modulo[]') {
            let tipo = event.target.id.split('_').pop();
            let tipoModulo = event.target.value;
            cargarPitch(tipoModulo, tipo);
        }
    });
});

</script>

<script>

document.addEventListener('DOMContentLoaded', function() {
  const categoriaProducto = document.getElementById('categoria_producto');
  const uso = document.getElementById('uso');
  const tipoProducto = document.getElementById('tipo_producto');
  const tipoModulo = document.getElementById('tipo_modulo');
  const pitch = document.getElementById('pitch');
  const xDispo = document.getElementById('x_dispo');
  const yDispo = document.getElementById('y_dispo');

  categoriaProducto.addEventListener('change', function() {
    // Resetea todos los campos para habilitarlos al cambiar la selección
    uso.disabled = false;
    tipoProducto.disabled = false;
    tipoModulo.disabled = false;
    pitch.disabled = false;
    xDispo.disabled = false;
    yDispo.disabled = false;

    // Deshabilita los campos según la selección de categoría
    switch (categoriaProducto.value) {
      case '1':
        tipoModulo.disabled = true;
        pitch.disabled = true;
        xDispo.disabled = true;
        yDispo.disabled = true;
        break;
      case '2':
        tipoModulo.disabled = true;
        pitch.disabled = true;
        break;
      case '4':
        uso.disabled = true;
        tipoProducto.disabled = true;
        tipoModulo.disabled = true;
        pitch.disabled = true;
        xDispo.disabled = true;
        yDispo.disabled = true;
        break;
      default:
        // En caso de otra categoría no hacer nada
        break;
    }
  });

  // Para deshabilitar por defecto al cargar la página
  categoriaProducto.dispatchEvent(new Event('change'));
});

</script>