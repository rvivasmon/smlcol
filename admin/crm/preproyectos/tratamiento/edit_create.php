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
                                            <input type="hidden" id="id_uso" name="id_uso" value="<?php echo htmlspecialchars($id_uso); ?>" class="form-control">
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
                                                        <input type="hidden" id="resultadoMultiplicacion" class="form-control">
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
                                                            <label for="pixelxpantalla">Píxel por Pantalla</label>
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
    const agregarProductoCheckbox = document.getElementById('agregar_Producto');
    const formularioExtra = document.getElementById('formularioExtra');
    const modeloSelect = document.getElementById('modelo');
    const controladoraSelect = document.getElementById('controladora');
    const cantidadControlInput = document.getElementById('cantidadControl');


    let originalXReal, originalYReal;

    function initEvents() {
        pitchSelect.addEventListener('change', onPitchChange);
        checkbox.addEventListener('change', onCheckboxChange);
        modeloSelect.addEventListener('change', onModeloChange);
        agregarProductoCheckbox.addEventListener('change', onAgregarProductoChange);
        xRealInput.addEventListener('input', updatePixelPorPantalla);
        yRealInput.addEventListener('input', updatePixelPorPantalla);
        moduloXInput.addEventListener('input', updatePixelPorPantalla);
        moduloYInput.addEventListener('input', updatePixelPorPantalla);
        document.getElementById('x_real').addEventListener('input', updateTotals);
        document.getElementById('y_real').addEventListener('input', updateTotals);
        document.getElementById('x_disp').addEventListener('input', updateTotals);
        document.getElementById('y_disp').addEventListener('input', updateTotals);

    }

    function onPitchChange() {
        const selectedOption = pitchSelect.options[pitchSelect.selectedIndex];
        xRealInput.value = selectedOption.getAttribute('data-medida-x') || '';
        yRealInput.value = selectedOption.getAttribute('data-medida-y') || '';

        originalXReal = xRealInput.value;
        originalYReal = yRealInput.value;

        updateTotals();
        updateRectangulo();
        updatePixelPorPantalla();
    }

    function onCheckboxChange() {
        if (checkbox.checked) {
            [xRealInput.value, yRealInput.value] = [yRealInput.value, xRealInput.value];
        } else {
            xRealInput.value = originalXReal;
            yRealInput.value = originalYReal;
        }
        updateTotals();
        updateRectangulo();
    }

    function onModeloChange() {
        const modeloId = modeloSelect.value;

        fetch(`get_pitch.php?modelo_id=${modeloId}`)
            .then(response => response.json())
            .then(data => {
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
                pitchSelect.dispatchEvent(new Event('change'));
            });
    }

    function onAgregarProductoChange() {
        formularioExtra.style.display = agregarProductoCheckbox.checked ? 'block' : 'none';

        if (agregarProductoCheckbox.checked) {
            controladoraSelect.disabled = false;
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
        } else {
            controladoraSelect.disabled = true;
            controladoraSelect.innerHTML = '<option value="">Seleccione una controladora</option>';
        }
    }

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

    // Calcular el resultado de la multiplicación y redondearlo a 2 dígitos después del punto
    let resultadoMultiplicacion = (xTotal * yTotal) / 1000;
    resultadoMultiplicacion = resultadoMultiplicacion;  // Redondear

    // Mostrar el resultado en el label con separadores de miles
    document.getElementById('resultadoMultiplicacionLabel').textContent = `Mts²: ${parseFloat(resultadoMultiplicacion).toLocaleString('es')} Mts`;

    // Almacenar el valor sin formato en el input oculto
    document.getElementById('resultadoMultiplicacion').value = resultadoMultiplicacion;

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

        // Mostrar el valor formateado con separadores de miles
        const pixelPorPantallaFormatted = document.getElementById('pixelxpantalla_formatted');
        pixelPorPantallaFormatted.value = (pixelX * pixelY).toLocaleString();
    }

    // Inicializar los eventos
    initEvents();
    updateTotals();
    updateRectangulo();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables
    const controladoraSelect = document.getElementById('controladora');
    const pixelMaxLabel = document.getElementById('pixelMaxLabel');

    function actualizarResultadoResta() {
        const pixelXPantalla = Number(document.getElementById('pixelxpantalla').value);
        const pixelMaxLabelFormatted = Number(document.getElementById('pixelMaxLabel_formatted').value);

        // Realizar la resta
        const resultadoResta = pixelXPantalla - pixelMaxLabelFormatted;

        // Mostrar el resultado en el label con separadores de mil
        document.getElementById('resultadoRestaLabel').textContent = `Resultado: ${resultadoResta.toLocaleString('es')}`;
        
        // Asignar el valor sin formato al campo resultadoresta
        document.getElementById('resultadoresta').value = resultadoResta; // Valor sin formatear
    }

    function onControladoraChange() {
        const controladoraId = controladoraSelect.value;
        
        if (controladoraId) {
            fetch(`get_pixel_max.php?controladora_id=${controladoraId}`)
                .then(response => response.json())
                .then(data => {
                    const pixelMax = Number(data.pixel_max); // Obtener el valor sin formatear
                    const pixelMaxFormatted = pixelMax.toLocaleString('es'); // Formatear con puntos de mil

                    pixelMaxLabel.textContent = `Pixel Max: ${pixelMaxFormatted}`;
                    document.getElementById('pixelMaxLabel_formatted').value = pixelMax; // Almacenar el valor sin puntos de mil
                    
                    // Actualizar el resultado de la resta cuando se cambia la controladora
                    actualizarResultadoResta();
                })
                .catch(error => console.error('Error al obtener el pixel:max:', error));
        } else {
            pixelMaxLabel.textContent = ''; // Limpiar el label si no hay selección
            document.getElementById('pixelMaxLabel_formatted').value = ''; // Limpiar el valor formateado
            document.getElementById('resultadoRestaLabel').textContent = ''; // Limpiar el resultado de la resta
        }
    }

    // Agregar un evento para que se actualice el resultado al cambiar el valor de pixelxpantalla
    document.getElementById('pixelxpantalla').addEventListener('input', actualizarResultadoResta);

    // Agregar el evento de cambio al select de controladora
    controladoraSelect.addEventListener('change', onControladoraChange);

    // Inicializa otros eventos si es necesario
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const pitchSelect = document.getElementById('pitch_dispo');
    const modeloSelect = document.getElementById('modelo');
    const agregarProductoCheckbox = document.getElementById('agregar_Producto');
    const formularioExtra = document.getElementById('formularioExtra');
    const controladoraSelect = document.getElementById('controladora');
    const cantidadControlInput = document.getElementById('cantidadControl');
    const pixelMaxLabel = document.getElementById('pixelMaxLabel'); // Añadir referencia al label
    const resultadoRestaLabel = document.getElementById('resultadoRestaLabel'); // Añadir referencia al label
    const pesoxpantallaLabel = document.getElementById('pesoxpantallaLabel'); // Añadir referencia al peso con
    const pesoxpantallasinInput = document.getElementById('pesoxpantallasin'); // Añadir referencia al peso sin

    resultadoRestaLabel

    // Inicializar eventos existentes
    initEvents();

    // Nueva función para resetear el formulario extra
    function resetFormularioExtra() {
        controladoraSelect.value = ''; // Resetea el campo de controladora
        cantidadControlInput.value = ''; // Resetea el campo de cantidad
        pixelMaxLabel.textContent = ''; // Resetea el label de pixelMaxLabel
        resultadoRestaLabel.textContent = ''; // Resetea el label de pixelMaxLabel
        pesoxpantallaLabel.textContent = ''; // Resetea el label de peso con
        pesoxpantallasinInput.textContent = ''; // Resetea el input de peso sin        
        formularioExtra.style.display = 'none'; // Oculta el formulario extra
        agregarProductoCheckbox.checked = false; // Desmarca el checkbox
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
    document.getElementById('pitch_dispo').addEventListener('change', function() {
    const idTipoProducto = document.getElementById('id_tipoproducto').value;
    const resultadoMultiplicacion = Number(document.getElementById('resultadoMultiplicacion').value);

    if (idTipoProducto && resultadoMultiplicacion) {
        // Hacer la solicitud AJAX para obtener el peso_producto21
        fetch('get_pesos.php?id_tipoproducto=' + idTipoProducto)
            .then(response => response.json())
            .then(data => {
                if (data.peso_producto21) {
                    const pesoProducto21 = Number(data.peso_producto21);
                    
                   // Calcular el resultado
                    const resultado = ((pesoProducto21 * resultadoMultiplicacion) / 1000000);

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
});

</script>