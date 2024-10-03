<?php 
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : null;
$preproyec_id = isset($_GET['preproyec_id']) ? $_GET['preproyec_id'] : null;

// Consulta para obtener los datos del pre-proyecto
$query = $pdo->prepare("SELECT
                                item_preproyecto.*,
                                t_estado.estado_ppc AS nom_estado,
                                t_categoria_productos.categoria AS nom_categoria,
                                tipo_prod.tipo_producto21 AS nom_producto,
                                modelo_prod.modelo_modulo AS nom_modelo,
                                t_uso_productos.producto_uso AS nom_uso,
                                caracteristicas_modulos.pitch AS nom_pitch
                            FROM
                                item_preproyecto
                            LEFT JOIN
                                t_estado ON item_preproyecto.estado = t_estado.id
                            LEFT JOIN
                                t_categoria_productos ON item_preproyecto.categoria = t_categoria_productos.id_prod_terminado
                            LEFT JOIN
                                t_tipo_producto as tipo_prod ON item_preproyecto.tipo_producto = tipo_prod.id
                            LEFT JOIN
                                t_tipo_producto as modelo_prod ON item_preproyecto.modelo_uso = modelo_prod.id
                            LEFT JOIN
                                t_uso_productos ON item_preproyecto.uso = t_uso_productos.id_uso
                            LEFT JOIN
                                caracteristicas_modulos ON item_preproyecto.pitch = caracteristicas_modulos.id_car_mod
                            WHERE
                                item_preproyecto.id_item_preproy = :item_id"
                            );

$query->bindParam(':item_id', $item_id, PDO::PARAM_INT);
$query->execute();
$proyecto = $query->fetch(PDO::FETCH_ASSOC);

if ($proyecto) {
    $id = $proyecto['id_item_preproy'];
    $fecha = $proyecto['cantidad_pantallas'];
    $tipo = $proyecto['nom_categoria'];
    $idprepro = $proyecto['nom_producto'];
    $preproyecto = $proyecto['nom_uso'];
    $id_uso = $proyecto['uso'];
    $cliente = $proyecto['nom_modelo'];
    $contacto = $proyecto['nom_pitch'];
    $telefono = $proyecto['x_disponible'];
    $ciudad = $proyecto['y_disponible'];
    $justificacion = $proyecto['justificacion'];
} else {
    echo "No se encontró el pre-proyecto.";
    exit;
}

// Consulta para obtener los datos del item - preproyecto
$query_pre = $pdo->prepare("SELECT * FROM pre_proyecto WHERE id_preproyec = :preproyec_id");
$query_pre->bindParam(':preproyec_id', $preproyec_id, PDO::PARAM_INT);
$query_pre->execute();
$pre_proyecto = $query_pre->fetch(PDO::FETCH_ASSOC);

if ($pre_proyecto) {
    $id_pre = $pre_proyecto['id_preproyec'];
} else {
    echo "No se encontró el pre-proyecto.";
    exit;
}

// Recuperar los datos de las opciones de 'sending', 'reciving', y 'controladora'
$pixelxpantalla = isset($_POST['pixelxpantalla']) ? intval($_POST['pixelxpantalla']) : 0;

// Opciones de 'controladora'
$query_controladora = $pdo->prepare("SELECT * FROM referencias_control WHERE funcion IN (6, 9, 10, 12, 16) AND pixel_max > :pixelxpantalla");
$query_controladora->bindParam(':pixelxpantalla', $pixelxpantalla, PDO::PARAM_INT);
$query_controladora->execute();
$result_controladora = $query_controladora->fetchAll(PDO::FETCH_ASSOC);
$options_controladora = "";
foreach ($result_controladora as $row) {
    $options_controladora .= "<option value=\"" . htmlspecialchars($row['id_referencia']) . "\">" . htmlspecialchars($row['referencia']) . "</option>";
}

// Suponiendo que ya tienes el valor de id_uso definido
$id_uso = $proyecto['uso'];

// Obtener modelos de la base de datos donde uso_modelo coincide con id_uso
$query = $pdo->prepare("SELECT id, modelo_modulo FROM t_tipo_producto WHERE uso_modelo = :id_uso ORDER BY modelo_modulo ASC");
$query->execute(['id_uso' => $id_uso]);
$modelos = $query->fetchAll(PDO::FETCH_ASSOC);

// Crear opciones para el campo modelo
$options_modelo = '';
foreach ($modelos as $modelo) {
    $options_modelo .= '<option value="' . $modelo['id'] . '">' . $modelo['modelo_modulo'] . '</option>';
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edición ITEMS</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card">
                <div class="card-header" style="background-color: #00A000; color: #ffffff">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pantallas"># Pantallas</label>
                                            <input type="text" name="pantallas" value="<?php echo htmlspecialchars($fecha); ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="categoria">Categoría</label>
                                            <input type="text" name="categoria" value="<?php echo htmlspecialchars($tipo); ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="uso">Uso Producto</label>
                                            <input type="text" name="uso" value="<?php echo htmlspecialchars($preproyecto); ?>" class="form-control" readonly>
                                            <input type="hidden" name="id_uso" value="<?php echo htmlspecialchars($id_uso); ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipo">Tipo Producto</label>
                                            <input type="text" name="tipo" value="<?php echo htmlspecialchars($idprepro); ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="x_disp">X Disponible en mm</label>
                                            <input type="text" name="x_disp" id="x_disp" value="<?php echo htmlspecialchars($telefono); ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="y_disp">Y Disponible en mm</label>
                                            <input type="text" name="y_disp" id="y_disp" value="<?php echo htmlspecialchars($ciudad); ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="justificacion">Observaciones</label>
                                            <textarea name="justificacion" id="justificacion" cols="30" row="4" class="form-control" readonly><?php echo htmlspecialchars($justificacion); ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Formulario para agregar otro producto -->
                                    <div id="formularioExtra" style="display: none;">
                                        <h3>SISTEMA DE CONTROL</h3>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="controladora">Controladora</label>
                                                    <select name="controladora" id="controladora" class="form-control">
                                                        <option value="">Seleccione una tarjeta</option> <!-- Opción inicial -->
                                                        <?php echo $options_controladora; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cantidadControl">Cantidad</label>
                                                    <input type="text" name="cantidadControl" id="cantidadControl" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="modelo">Modelo Producto</label>
                                            <select name="modelo" id="modelo" class="form-control">
                                                <option value="">Seleccione un modelo</option>
                                                <?php echo $options_modelo; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="pitch_dispo">Pitch disponible</label>
                                            <select name="pitch_dispo" id="pitch_dispo" class="form-control">
                                                <option value="">Seleccione un pitch</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="x_real">Tamaño módulo en X</label>
                                            <input type="text" name="x_real" id="x_real" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="y_real">Tamaño módulo en Y</label>
                                            <input type="text" name="y_real" id="y_real" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-froup">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="x_total">X Real</label>
                                                            <input type="text" name="x_total" id="x_total" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="y_total">Y Real</label>
                                                            <input type="text" name="y_total" id="y_total" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Nueva fila para modulo_x y modulo_y -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="modulo_x"> Módulos en X</label>
                                                            <input type="text" name="modulo_x" id="modulo_x" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="modulo_y">Módulos en Y</label>
                                                            <input type="text" name="modulo_y" id="modulo_y" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="pixelxpantalla"> Píxel por Pantalla</label>
                                                            <input type="numero" name="pixelxpantalla" id="pixelxpantalla" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group canvas-container">
                                                <div class="col-md-6">
                                                    <div class="text-center">
                                                        <label for="rectangulo"></label>
                                                        <canvas id="canvas" width="180" height="180" style="border: 1px solid #000000;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="intercambiar">Intercambiar X y Y</label>
                                                <input type="checkbox" id="intercambiar" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nuevo Checkbox para mostrar/ocultar formulario -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="agregar_Producto" id="agregar_Producto" value="1"> Agregar Sistema de Control
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/crm/preproyectos/tratamiento/create.php?id=".$id_pre;?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Asegúrese de diligenciar correctamente los datos')" class="btn btn-success btn-block">Actualizar Proyecto</button>
                            </div>
                        </div>

                        <input type="hidden" name="id_item_preproy" value="<?php echo htmlspecialchars($id_pre); ?>">
                        <input type="hidden" name="id_preproyec" value="<?php echo htmlspecialchars($item_id); ?>">

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../../../../layout/admin/parte2.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pitchSelect = document.getElementById('pitch_dispo');
    const xRealInput = document.querySelector('input[name="x_real"]');
    const yRealInput = document.querySelector('input[name="y_real"]');
    const xDispInput = document.getElementById('x_disp');
    const yDispInput = document.getElementById('y_disp');
    const xTotalInput = document.getElementById('x_total');
    const yTotalInput = document.getElementById('y_total');
    const moduloXInput = document.getElementById('modulo_x');
    const moduloYInput = document.getElementById('modulo_y');
    const pixelPorPantallaInput = document.getElementById('pixelxpantalla');
    const checkbox = document.getElementById('intercambiar');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    // Variables para guardar los valores originales de x_real e y_real
    let originalXReal, originalYReal;

    // Función para actualizar los campos x_real e y_real al cambiar el pitch
    pitchSelect.addEventListener('change', function() {
        const selectedOption = pitchSelect.options[pitchSelect.selectedIndex];
        xRealInput.value = selectedOption.getAttribute('data-medida-x') || '';
        yRealInput.value = selectedOption.getAttribute('data-medida-y') || '';

        // Guardar los valores originales de x_real y y_real al seleccionar un pitch
        originalXReal = xRealInput.value;
        originalYReal = yRealInput.value;

        updateTotals();
        updateRectangulo();
    });

    // Evento para intercambiar valores de x_real e y_real cuando se marca el checkbox
    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            // Intercambiar los valores cuando se marque el checkbox
            [xRealInput.value, yRealInput.value] = [yRealInput.value, xRealInput.value];
        } else {
            // Restaurar los valores originales cuando se desmarque el checkbox
            xRealInput.value = originalXReal;
            yRealInput.value = originalYReal;
        }

        updateTotals();
        updateRectangulo();
    });

    // Función para actualizar el total y los módulos
    function updateTotals() {
        const xReal = parseFloat(xRealInput.value) || 1;
        const yReal = parseFloat(yRealInput.value) || 1;
        const xDisp = parseFloat(xDispInput.value) || 0;
        const yDisp = parseFloat(yDispInput.value) || 0;

        const xModulo = Math.round(xDisp / xReal);
        const yModulo = Math.round(yDisp / yReal);

        const xTotal = xModulo * xReal;
        const yTotal = yModulo * yReal;

        xTotalInput.value = xTotal;
        yTotalInput.value = yTotal;
        moduloXInput.value = xModulo;
        moduloYInput.value = yModulo;

        updateFieldColors();
        updatePixelPorPantalla();
    }

    // Función para actualizar el color de los campos basados en el total
    function updateFieldColors() {
        const xDisp = parseFloat(xDispInput.value) || 0;
        const yDisp = parseFloat(yDispInput.value) || 0;
        const xTotal = parseFloat(xTotalInput.value) || 0;
        const yTotal = parseFloat(yTotalInput.value) || 0;

        xTotalInput.style.color = (xTotal > xDisp) ? 'red' : 'green';
        yTotalInput.style.color = (yTotal > yDisp) ? 'red' : 'green';
    }

    // Función para dibujar el rectángulo en el canvas
    function updateRectangulo() {
        const xReal = parseFloat(xRealInput.value) || 0;
        const yReal = parseFloat(yRealInput.value) || 0;

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        const maxCanvasSize = 160;
        const scaleFactor = Math.min(maxCanvasSize / xReal, maxCanvasSize / yReal);
        const scaledX = xReal * scaleFactor;
        const scaledY = yReal * scaleFactor;

        ctx.fillStyle = (xReal > yReal) ? 'blue' : (xReal < yReal) ? 'green' : 'red';
        ctx.fillRect(10, 10, scaledX, scaledY);
    }

    // Función para calcular los píxeles por pantalla
    function updatePixelPorPantalla() {
        const selectedOption = pitchSelect.options[pitchSelect.selectedIndex];
        const pitch = parseFloat(selectedOption.getAttribute('data-pitch')) || 1;
        let xReal = parseFloat(xRealInput.value) || 0;
        let yReal = parseFloat(yRealInput.value) || 0;
        const moduloX = parseInt(moduloXInput.value) || 0;
        const moduloY = parseInt(moduloYInput.value) || 0;

        if (checkbox.checked) [xReal, yReal] = [yReal, xReal];

        const pixelX = moduloX * Math.round(xReal / pitch);
        const pixelY = moduloY * Math.round(yReal / pitch);
        const totalPixels = pixelX * pixelY;

            // Aplicar formato con separadores de miles
            pixelPorPantallaInput.value = totalPixels.toLocaleString();
    }

    // Inicializar la página y sus eventos
    updateTotals();
    updateRectangulo();

    pitchSelect.addEventListener('change', updatePixelPorPantalla);
    xRealInput.addEventListener('input', updatePixelPorPantalla);
    yRealInput.addEventListener('input', updatePixelPorPantalla);
    moduloXInput.addEventListener('input', updatePixelPorPantalla);
    moduloYInput.addEventListener('input', updatePixelPorPantalla);
    checkbox.addEventListener('change', updatePixelPorPantalla);
});

</script>

<script>
    // Mostrar u ocultar formulario adicional
    document.addEventListener('DOMContentLoaded', function() {
        const agregarProductoCheckbox = document.getElementById('agregar_Producto');
        const formularioExtra = document.getElementById('formularioExtra');

        agregarProductoCheckbox.addEventListener('change', function() {
            formularioExtra.style.display = this.checked ? 'block' : 'none';
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modeloSelect = document.getElementById('modelo');
        const pitchSelect = document.getElementById('pitch_dispo');

        // Al seleccionar un modelo, realizar solicitud AJAX para obtener pitch_dispo
        modeloSelect.addEventListener('change', function() {
            const modeloId = this.value;

            // Realizar una solicitud AJAX para obtener pitch_dispo
            fetch(`get_pitch.php?modelo_id=${modeloId}`)
                .then(response => response.json())
                .then(data => {
                    // Limpiar las opciones actuales del select
                    pitchSelect.innerHTML = '<option value="">Seleccione un pitch</option>';
                    
                    // Agregar nuevas opciones al select
                    data.forEach(item => {
                        pitchSelect.innerHTML += `
                            <option value="${item.id_car_mod}" 
                                    data-pitch="${item.pitch}" 
                                    data-medida-x="${item.medida_x}" 
                                    data-medida-y="${item.medida_y}">
                                ${item.pitch} / ${item.medida_x} x ${item.medida_y}
                            </option>`;
                    });
                });
        });

        // Activar el evento 'change' en la carga de la página para el modelo predeterminado
        modeloSelect.dispatchEvent(new Event('change'));
    });
</script>
