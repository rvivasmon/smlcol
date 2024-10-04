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
    $id_tipoproducto = $proyecto['tipo_producto'];
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
                    <form  id="editaritems" action="controller_edit.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pantallas"># Pantallas</label>
                                            <input type="text" id="pantallas" name="pantallas" value="<?php echo htmlspecialchars($fecha); ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="categoria">Categoría</label>
                                            <input type="text" id="categoria" name="categoria" value="<?php echo htmlspecialchars($tipo); ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="uso">Uso Producto</label>
                                            <input type="text" id="uso" name="uso" value="<?php echo htmlspecialchars($preproyecto); ?>" class="form-control" readonly>
                                            <input type="hidden" id="id_uso1" name="id_uso1" value="<?php echo htmlspecialchars($id_uso); ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipo">Tipo Producto</label>
                                            <input type="text" id="tipo" name="tipo" value="<?php echo htmlspecialchars($idprepro); ?>" class="form-control" readonly>
                                            <!-- Campo oculto para almacenar el valor de $id_tipoproducto -->
                                            <input type="hidden" id="id_tipoproducto" name="id_tipoproducto" value="<?php echo htmlspecialchars($id_tipoproducto); ?>">
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
                                    <div class="col-md-6">
                                        <!-- Formulario para agregar otro producto -->
                                        <div id="formularioExtra" style="display: none;">
                                            <h3>SISTEMA DE CONTROL</h3>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="controladora">Controladora</label>
                                                        <select id="controladora" class="form-control">
                                                            <option value="">Seleccione una controladora</option>
                                                            <!-- Opciones serán llenadas por JavaScript -->
                                                        </select>
                                                        <label id="pixelMaxLabel" class="mt-2"></label> <!-- Label para mostrar pixel:max -->
                                                        <!-- Campo (oculto) -->
                                                        <input type="hidden" id="pixelMaxLabel_formatted" name="pixelMaxLabel_formatted" class="form-control">                                                    
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cantidadControl">Cantidad</label>
                                                        <input type="text" name="cantidadControl" id="cantidadControl" class="form-control">
                                                        <label id="resultadoRestaLabel" class="mt-2"></label>
                                                        <!-- Campo (oculto) -->
                                                        <input type="hidden" id="resultadoresta" name="resultadoresta" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="resultadoMultiplicacionLabel" class="mt-2"></label>
                                                        <!-- Campo (oculto) -->
                                                        <input type="hidden" id="resultadoMultiplicacioninput" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="pesoxpantallaLabel" class="mt-2"></label>
                                                        <!-- Campo (oculto) -->
                                                        <input type="hidden" id="pesoxpantallasin" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label id="labelWattsConsumo" name="labelWattsConsumo" class="mt-2"></label>
                                                        <!-- Campo (oculto) -->
                                                        <input type="hidden" id="inputWattsConsumo" name="inputWattsConsumo" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label id="voltaje" name="voltaje" class="mt-2">Voltaje: 220 voltios</label>
                                                        <!-- Campo (oculto) -->
                                                        <input type="hidden" id="inputWattsConsumo" name="inputWattsConsumo" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label id="calibre" name="calibre" class="mt-2">Cable Calibre 12</label>
                                                        <!-- Campo (oculto) -->
                                                        <input type="hidden" id="inputWattsConsumo" name="inputWattsConsumo" class="form-control">
                                                    </div>
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
                                            <input type="text" name="x_real" id="x_real" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="y_real">Tamaño módulo en Y</label>
                                            <input type="text" name="y_real" id="y_real" class="form-control" readonly>
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
                                                            <input type="text" name="x_total" id="x_total" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="y_total">Y Real</label>
                                                            <input type="text" name="y_total" id="y_total" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Nueva fila para modulo_x y modulo_y -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="modulo_x"> Módulos en X</label>
                                                            <input type="text" name="modulo_x" id="modulo_x" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="modulo_y">Módulos en Y</label>
                                                            <input type="text" name="modulo_y" id="modulo_y" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label id="pixelxpantalla">Píxel por Pantalla</label>
                                                            <!-- Nuevo campo para mostrar el valor con separador de miles -->
                                                            <input type="text" id="pixelxpantalla_formatted" class="form-control" readonly>
                                                            <!-- Campo original pixelxpantalla (oculto) -->
                                                            <input type="hidden" id="pixelxpantalla" name="pixelxpantalla" value="">
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
                                                        <label id="rectangulo"></label>
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
    // Variables
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
    const agregarProductoCheckbox = document.getElementById('agregar_Producto');
    const formularioExtra = document.getElementById('formularioExtra');
    const modeloSelect = document.getElementById('modelo');
    const controladoraSelect = document.getElementById('controladora');
    const cantidadControlInput = document.getElementById('cantidadControl');
    const originalValues = { x: null, y: null };

    initEvents();
    updateTotals();
    updateRectangulo();

    function initEvents() {
        pitchSelect.addEventListener('change', onPitchChange);
        checkbox.addEventListener('change', onCheckboxChange);
        modeloSelect.addEventListener('change', onModeloChange);
        agregarProductoCheckbox.addEventListener('change', onAgregarProductoChange);
        addInputEventListeners([xRealInput, yRealInput, moduloXInput, moduloYInput, xDispInput, yDispInput], updatePixelPorPantalla);
    }

    function addInputEventListeners(inputs, callback) {
        inputs.forEach(input => {
            input.addEventListener('input', callback);
        });
    }

    function onPitchChange() {
        const selectedOption = pitchSelect.options[pitchSelect.selectedIndex];
        xRealInput.value = selectedOption.getAttribute('data-medida-x') || '';
        yRealInput.value = selectedOption.getAttribute('data-medida-y') || '';

        originalValues.x = xRealInput.value;
        originalValues.y = yRealInput.value;

        updateTotals();
        updateRectangulo();
        updatePixelPorPantalla();
    }

    function onCheckboxChange() {
        if (checkbox.checked) {
            [xRealInput.value, yRealInput.value] = [yRealInput.value, xRealInput.value];
        } else {
            xRealInput.value = originalValues.x;
            yRealInput.value = originalValues.y;
        }
        updateTotals();
        updateRectangulo();
    }

    function onModeloChange() {
        const modeloId = modeloSelect.value;

        fetch(`get_pitch.php?modelo_id=${modeloId}`)
            .then(response => response.json())
            .then(data => {
                updatePitchSelect(data);
                pitchSelect.dispatchEvent(new Event('change'));
            })
            .catch(error => console.error('Error al obtener pitches:', error));
    }

    function updatePitchSelect(data) {
        pitchSelect.innerHTML = '<option value="">Seleccione un pitch</option>';
        data.forEach(item => {
            pitchSelect.innerHTML += `
                <option value="${item.id_car_mod}" 
                        data-pitch="${item.pitch}" 
                        data-medida-x="${item.medida_x}" 
                        data-medida-y="${item.medida_y}">
                    ${item.pitch} / ${item.medida_x} x ${item.medida_y}
                </option>`;
        });
    }

    function onAgregarProductoChange() {
        formularioExtra.style.display = agregarProductoCheckbox.checked ? 'block' : 'none';
        controladoraSelect.disabled = !agregarProductoCheckbox.checked;

        if (agregarProductoCheckbox.checked) {
            fetchControladoras();
        } else {
            controladoraSelect.innerHTML = '<option value="">Seleccione una controladora</option>';

                    // Reiniciar los campos cuando el checkbox se desmarca
                    (document.getElementById('pixelMaxLabel_formatted')).value = ''; // Reinicia el valor del input
                    (document.getElementById('resultadoresta')).value = ''; // Reinicia el valor del input
                    (document.getElementById('pixelMaxLabel')).textContent = ''; // Reinicia el texto del label
                    (document.getElementById('resultadoRestaLabel')).textContent = ''; // Reinicia el texto del label
        }
    }

    function fetchControladoras() {
        const pixelMaxValue = parseFloat(pixelPorPantallaInput.value);
        fetch(`get_controladoras.php?pixel_max=${pixelMaxValue}`)
            .then(response => response.json())
            .then(data => {
                controladoraSelect.innerHTML = '<option value="">Seleccione una controladora</option>';
                data.forEach(item => {
                    controladoraSelect.innerHTML += `
                        <option value="${item.id_referencia}">${item.referencia}</option>`;
                });
            })
            .catch(error => console.error('Error al obtener controladoras:', error));
    }

    function updateTotals() {
        const xReal = Number(xRealInput.value) || 1;
        const yReal = Number(yRealInput.value) || 1;
        const xDisp = Number(xDispInput.value) || 0;
        const yDisp = Number(yDispInput.value) || 0;

        const xModulo = Math.floor(xDisp / xReal);
        const yModulo = Math.floor(yDisp / yReal);

        const xTotal = xModulo * xReal;
        const yTotal = yModulo * yReal;

        xTotalInput.value = xTotal;
        yTotalInput.value = yTotal;
        moduloXInput.value = xModulo;
        moduloYInput.value = yModulo;

        const resultadoMultiplicacion = Math.round((xTotal * yTotal) / 1000);
        document.getElementById('resultadoMultiplicacionLabel').textContent = `Mts²: ${Number(resultadoMultiplicacion).toLocaleString('es')} Mts`;
        document.getElementById('resultadoMultiplicacioninput').value = resultadoMultiplicacion;

        updateFieldColors();
        updatePixelPorPantalla();
    }

    function updateFieldColors() {
        const xTotal = parseFloat(xTotalInput.value) || 0;
        const yTotal = parseFloat(yTotalInput.value) || 0;
        const xDisp = parseFloat(xDispInput.value) || 0;
        const yDisp = parseFloat(yDispInput.value) || 0;

        xTotalInput.style.color = (xTotal > xDisp) ? 'red' : 'green';
        yTotalInput.style.color = (yTotal > yDisp) ? 'red' : 'green';
    }

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
        pixelPorPantallaInput.value = pixelX * pixelY;

        document.getElementById('pixelxpantalla_formatted').value = (pixelX * pixelY).toLocaleString();
    }

    // Parte del script para actualizar el resultado de la resta
    const pixelMaxLabel = document.getElementById('pixelMaxLabel');
    const resultadoRestaLabel = document.getElementById('resultadoRestaLabel');

    document.getElementById('pixelxpantalla').addEventListener('input', actualizarResultadoResta);
    controladoraSelect.addEventListener('change', onControladoraChange);

    function actualizarResultadoResta() {
        const pixelXPantalla = Number(pixelPorPantallaInput.value);
        const pixelMaxLabelFormatted = Number(document.getElementById('pixelMaxLabel_formatted').value);
        const resultadoResta = pixelXPantalla - pixelMaxLabelFormatted;

        resultadoRestaLabel.textContent = `Resultado: ${resultadoResta.toLocaleString('es')}`;
        document.getElementById('resultadoresta').value = resultadoResta; // Valor sin formatear
    }

    function onControladoraChange() {
        const controladoraId = controladoraSelect.value;
        
        if (controladoraId) {
            fetch(`get_pixel_max.php?controladora_id=${controladoraId}`)
                .then(response => response.json())
                .then(data => {
                    const pixelMax = Number(data.pixel_max);
                    const pixelMaxFormatted = pixelMax.toLocaleString('es');
                    document.getElementById('pixelMaxLabel').textContent = `Pixel Max: ${pixelMaxFormatted}`;
                    document.getElementById('pixelMaxLabel_formatted').value = pixelMax; // Guardar el valor para cálculos
                    actualizarResultadoResta();
                })
                .catch(error => console.error('Error al obtener pixel_max:', error));
        }
    }
});
</script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const pitchSelect = document.getElementById('pitch_dispo');
    const modeloSelect = document.getElementById('modelo');
    const agregarProductoCheckbox = document.getElementById('agregar_Producto');
    const formularioExtra = document.getElementById('formularioExtra');
    const controladoraSelect = document.getElementById('controladora');
    const pixelMaxLabel = document.getElementById('pixelMaxLabel'); // Añadir referencia al label
    const pixelMaxLabelInput = document.getElementById('pixelMaxLabel_formatted'); // Añadir referencia al peso sin
    const cantidadControlInput = document.getElementById('cantidadControl');
    const resultadoRestaLabel = document.getElementById('resultadoRestaLabel'); // Añadir referencia al label
    const resultadorestaInput = document.getElementById('resultadoresta'); // Añadir referencia al peso sin
    const resultadoMultiplicacionLabel = document.getElementById('resultadoMultiplicacionLabel'); // Añadir referencia al peso sin
    const resultadoMultiplicacionInput = document.getElementById('resultadoMultiplicacioninput'); // Añadir referencia al peso sin
    const pesoxpantallaLabel = document.getElementById('pesoxpantallaLabel'); // Añadir referencia al peso con
    const pesoxpantallasinInput = document.getElementById('pesoxpantallasin'); // Añadir referencia al peso sin
    const LabelWattsConsumo = document.getElementById('labelWattsConsumo'); // Añadir referencia al peso con
    const InputWattsConsumo = document.getElementById('inputWattsConsumo'); // Añadir referencia al peso sin

    resultadoRestaLabel

    // Inicializar eventos existentes
    initEvents();

    // Nueva función para resetear el formulario extra
    function resetFormularioExtra() {

        controladoraSelect.value = '';  // Resetea
        pixelMaxLabelInput.value = '';  // Resetea
        cantidadControlInput.value = '';    // Resetea
        resultadorestaInput.value = ''; // Resetea
        pixelMaxLabel.textContent = ''; //  Resetea
        resultadoRestaLabel.textContent = '';   //  Resetea
        agregarProductoCheckbox.checked = false; // Desmarca el checkbox
        formularioExtra.style.display = 'none'; // Oculta el formulario extra

    }

    // Añadir eventos de cambio para los campos "modelo" y "pitch_dispo"
    modeloSelect.addEventListener('change', resetFormularioExtra);
    pitchSelect.addEventListener('change', resetFormularioExtra);

    // Función que inicializa los eventos
    function initEvents() {
        // Agrega otros eventos que ya tienes...
        agregarProductoCheckbox.addEventListener('change', onAgregarProductoChange);
    }

    // La función existente onAgregarProductoChange (asegúrate de que maneja la visibilidad del formulario extra)
    function onAgregarProductoChange() {
        formularioExtra.style.display = agregarProductoCheckbox.checked ? 'block' : 'none';
        if (agregarProductoCheckbox.checked) {
            controladoraSelect.disabled = false;
            // Lógica para llenar las opciones de controladora
        } else {
            controladoraSelect.disabled = true;
            controladoraSelect.innerHTML = '<option value="">Seleccione una controladora</option>';
        }
    }
});

</script>

<script>
document.getElementById('agregar_Producto').addEventListener('change', function(){
    const idUso = Number(document.getElementById('id_uso1').value);
    const idTipoProducto = document.getElementById('id_tipoproducto').value;
    const resultadoMultiplicacion = Number(document.getElementById('resultadoMultiplicacioninput').value);

    if (idTipoProducto && resultadoMultiplicacion) {
        // Hacer la solicitud AJAX para obtener el peso_producto21
        fetch('get_pesos.php?id_tipoproducto=' + idTipoProducto)
            .then(response => response.json())
            .then(data => {
                if (data.peso_producto21) {
                    const pesoProducto21 = Number(data.peso_producto21);
                    
                    // Calcular el resultado
                    const resultado = ((resultadoMultiplicacion * pesoProducto21) / 1000000);

                    // Redondear el resultado
                    const resultadoRedondeado = Math.round(resultado);

                    // Formatear el resultado con separador de miles y sin decimales
                    const resultadoConPuntos = resultadoRedondeado.toLocaleString('es-CO', { 
                        minimumFractionDigits: 0, 
                        maximumFractionDigits: 0 
                    });

                    // Actualizar los campos en el formulario
                    document.getElementById('pesoxpantallaLabel').textContent = "Peso: " + resultadoConPuntos + " Kgs";
                    document.getElementById('pesoxpantallasin').value = resultado;
                }
            })
        .catch(error => console.error('Error al obtener el peso_producto21:', error));
    }

    // Verifica si id_uso es 1, 2, 3, 4 o 5
    if ([1, 2, 3, 4, 5].includes(idUso)) {
        // Realiza la consulta a la base de datos (usando AJAX o fetch)
        fetch(`consumo_wats.php?id_uso=${idUso}`)
        .then(response => response.json())
        .then(data => {
            console.log('Datos recibidos:', data);  // Verificar la respuesta

            if (data && data.consumo_wats) {
                const consumoWats = Number(data.consumo_wats); // Obtén el valor del campo "consumo_wats"
                console.log('consumo_wats:', consumoWats);  // Verificar el valor de consumo_wats

                let resultadoConsumo = Math.round((consumoWats * resultadoMultiplicacion) / 1000);
                console.log('Resultado redondeado:', resultadoConsumo);  // Verificar el resultado redondeado

                // Actualiza el input y el label
                document.getElementById('inputWattsConsumo').value = resultadoConsumo;
                document.getElementById('labelWattsConsumo').textContent = `Consumo: ${resultadoConsumo.toLocaleString('es')} Watts`;
            } else {
                console.log('Error: No se encontró consumo_wats.');
            }
        })
        .catch(error => console.log('Error en la solicitud:', error));
    } else {
        console.log('El id_uso no es válido para la búsqueda de consumo_wats.');
    }

});

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('intercambiar');
    const resultadoResta = document.getElementById('resultadoresta');
    const resultadoRestaLabel = document.getElementById('resultadoRestaLabel');
    const inputWattsConsumo = document.getElementById('inputWattsConsumo');
    const labelWattsConsumo = document.getElementById('labelWattsConsumo');
    const pesoxpantallaLabel = document.getElementById('pesoxpantallaLabel');
    const pesoxpantallasin = document.getElementById('pesoxpantallasin');

    checkbox.addEventListener('change', function() {
        updateFields();
    });

    function updateFields() {
        // Obtener los valores actuales de los campos que necesites
        const xReal = parseFloat(document.querySelector('input[name="x_real"]').value) || 0;
        const yReal = parseFloat(document.querySelector('input[name="y_real"]').value) || 0;
        const moduloX = parseInt(document.getElementById('modulo_x').value) || 0;
        const moduloY = parseInt(document.getElementById('modulo_y').value) || 0;

        let newXReal, newYReal;

        // Intercambiar valores si el checkbox está marcado
        if (checkbox.checked) {
            newXReal = yReal;
            newYReal = xReal;
        } else {
            newXReal = xReal;
            newYReal = yReal;
        }

        // Realiza los cálculos que necesitas y actualiza los campos
        const result = newXReal * moduloX - newYReal * moduloY; // Ejemplo de cálculo para "resultadoresta"
        resultadoResta.value = result.toFixed(2); // Redondea a 2 decimales
        resultadoRestaLabel.textContent = `Resultado: ${result.toFixed(2)}`; // Actualiza la etiqueta

        // Actualiza inputWattsConsumo y labelWattsConsumo
        const wattsConsumo = (newXReal + newYReal) * 10; // Ejemplo de cálculo
        inputWattsConsumo.value = wattsConsumo.toFixed(2);
        labelWattsConsumo.textContent = `Watts Consumo: ${wattsConsumo.toFixed(2)}`;

        // Actualiza pesoxpantallaLabel y pesoxpantallasin
        const pesoPorPantalla = (newXReal + newYReal) * 5; // Ejemplo de cálculo
        pesoxpantallaLabel.textContent = `Peso por Pantalla: ${pesoPorPantalla.toFixed(2)}`;
        pesoxpantallasin.value = pesoPorPantalla.toFixed(2);
    }
});
</script>
