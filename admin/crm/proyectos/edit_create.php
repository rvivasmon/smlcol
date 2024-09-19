<?php 
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : null;
$preproyec_id = isset($_GET['preproyec_id']) ? $_GET['preproyec_id'] : null;

// Consulta para obtener los datos del pre-proyecto
$query = $pdo->prepare("SELECT
                                item_preproyecto.*,
                                t_estado.estado_ppc AS nom_estado,
                                t_categoria_productos.categoria AS nom_categoria,
                                tipo_prod.tipo_producto21 AS nom_producto,
                                modelo_prod.modelo_modulo AS nom_modelo,
                                t_tipo_producto.producto_uso AS nom_uso,
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
                                t_tipo_producto ON item_preproyecto.uso = t_tipo_producto.id
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
    $pitch = $proyecto['pitch'];
    $modeluso = $proyecto['modelo_uso'];
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

// Obtener el valor del modelo del formulario
$modeluso = isset($_POST['modelo']) ? $_POST['modelo'] : '';

// Consulta para obtener los pitches filtrados por el modelo
$query_pitch = $pdo->prepare("SELECT 
    id_car_mod,
    pitch,
    medida_x,
    medida_y,
    pixel_x,
    pixel_y
FROM
    caracteristicas_modulos
WHERE
    modelo_modulo = :modeluso
");
$query_pitch->bindParam(':modeluso', $modeluso, PDO::PARAM_STR);
$query_pitch->execute();
$pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);

// Obtener el valor de id_uso del formulario
$id_uso = $proyecto['uso'];

// Consulta para obtener los modelos filtrados por id_uso
$query_modelo = $pdo->prepare("SELECT 
    modelo_modulo
FROM
    t_tipo_producto
WHERE
    uso_modelo = :id_uso
");
$query_modelo->bindParam(':id_uso', $id_uso, PDO::PARAM_INT);
$query_modelo->execute();
$modelos = $query_modelo->fetchAll(PDO::FETCH_ASSOC);


// Recuperar los datos de las opciones de 'sending', 'reciving', y 'controladora'
$pixelxpantalla = isset($_POST['pixelxpantalla']) ? intval($_POST['pixelxpantalla']) : 0;

// Opciones de 'sending'
$query_sending = $pdo->prepare("SELECT * FROM referencias_control WHERE funcion = '2' AND pixel_max >= :pixelxpantalla");
$query_sending->bindParam(':pixelxpantalla', $pixelxpantalla, PDO::PARAM_INT);
$query_sending->execute();
$result_sending = $query_sending->fetchAll(PDO::FETCH_ASSOC);
$options_sending = "";
foreach ($result_sending as $row) {
    $options_sending .= "<option value=\"" . htmlspecialchars($row['id_referencia']) . "\">" . htmlspecialchars($row['referencia']) . "</option>";
}

// Opciones de 'reciving'
$query_reciving = $pdo->prepare("SELECT * FROM referencias_control WHERE funcion = '1' AND pixel_max >= :pixelxpantalla");
$query_reciving->bindParam(':pixelxpantalla', $pixelxpantalla, PDO::PARAM_INT);
$query_reciving->execute();
$result_reciving = $query_reciving->fetchAll(PDO::FETCH_ASSOC);
$options_reciving = "";
foreach ($result_reciving as $row) {
    $options_reciving .= "<option value=\"" . htmlspecialchars($row['id_referencia']) . "\">" . htmlspecialchars($row['referencia']) . "</option>";
}

// Opciones de 'controladora'
$query_controladora = $pdo->prepare("SELECT * FROM referencias_control WHERE funcion NOT IN ('1', '2') AND pixel_max >= :pixelxpantalla");
$query_controladora->bindParam(':pixelxpantalla', $pixelxpantalla, PDO::PARAM_INT);
$query_controladora->execute();
$result_controladora = $query_controladora->fetchAll(PDO::FETCH_ASSOC);
$options_controladora = "";
foreach ($result_controladora as $row) {
    $options_controladora .= "<option value=\"" . htmlspecialchars($row['id_referencia']) . "\">" . htmlspecialchars($row['referencia']) . "</option>";
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
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="modelo">Modelo Producto</label>
                                            <select name="modelo" id="modelo" class="form-control">
                                                <?php foreach($modelos as $modelo): ?>
                                                    <option value="<?php echo $modelo['modelo_modulo']; ?>">
                                                        <?php echo $modelo['modelo_modulo']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pitch_dispo">Pitch disponible</label>
                                            <select name="pitch_dispo" id="pitch_dispo" class="form-control">
                                                <option value="">Seleccione Pitch</option>
                                                <?php foreach ($pitches as $pitch): ?>
                                                    <option value="<?php echo htmlspecialchars($pitch['id_car_mod']); ?>" 
                                                            data-medida-x="<?php echo htmlspecialchars($pitch['medida_x']); ?>"
                                                            data-medida-y="<?php echo htmlspecialchars($pitch['medida_y']); ?>"
                                                            data-pitch="<?php echo htmlspecialchars($pitch['pitch']); ?>">  <!-- Agregar data-pitch -->
                                                        <?php echo htmlspecialchars($pitch['pitch']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="x_real">Tamaño módulo en X</label>
                                            <input type="text" name="x_real" id="x_real" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                                            <input type="text" name="pixelxpantalla" id="pixelxpantalla" class="form-control">
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

                        <!-- Formulario para agregar otro producto -->
                        <div id="formularioExtra" style="display: none;">
                            <h3>SISTEMA DE CONTROL</h3>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sending">Sending</label>
                                        <select name="sending" id="sending" class="form-control">
                                            <?php echo $options_sending; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cantidadsending">Cantidad</label>
                                        <input type="text" name="cantidadsending" id="cantidadsending" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="reciving">Reciving</label>
                                        <select name="reciving" id="reciving" class="form-control">
                                            <?php echo $options_reciving; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cantidadReciving">Cantidad</label>
                                        <input type="text" name="cantidadReciving" id="cantidadReciving" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="controladora">Controladora</label>
                                        <select name="controladora" id="controladora" class="form-control">
                                            <?php echo $options_controladora; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cantidadControl">Cantidad</label>
                                        <input type="text" name="cantidadControl" id="cantidadControl" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/crm/proyectos/create.php?id=".$id_pre;?>" class="btn btn-default btn-block">Cancelar</a>
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

<?php include('../../../layout/admin/parte2.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pitchSelect = document.getElementById('pitch_dispo');
    const xRealInput = document.querySelector('input[name="x_real"]');
    const yRealInput = document.querySelector('input[name="y_real"]');

    pitchSelect.addEventListener('change', function() {
        const selectedOption = pitchSelect.options[pitchSelect.selectedIndex];

        // Obtener los valores de data-medida-x e data-medida-y
        const medidaX = selectedOption.getAttribute('data-medida-x');
        const medidaY = selectedOption.getAttribute('data-medida-y');

        // Asignar los valores a los campos x_real e y_real
        xRealInput.value = medidaX || '';
        yRealInput.value = medidaY || '';
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pitchSelect = document.getElementById('pitch_dispo');
    const xRealInput = document.querySelector('input[name="x_real"]');
    const yRealInput = document.querySelector('input[name="y_real"]');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    function updateRectangulo() {
        const xReal = parseFloat(xRealInput.value) || 0;
        const yReal = parseFloat(yRealInput.value) || 0;

        // Limpiar el canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (xReal > yReal) {
            // Dibuja un rectángulo horizontal
            ctx.fillStyle = 'blue';
            ctx.fillRect(10, 10, xReal/2, yReal/2);
        } else if (xReal < yReal) {
            // Dibuja un rectángulo vertical
            ctx.fillStyle = 'green';
            ctx.fillRect(10, 10, xReal/2, yReal/2);
        } else {
            // Dibuja un cuadrado
            ctx.fillStyle = 'red';
            ctx.fillRect(10, 10, xReal/2, xReal/2);
        }
    }

    pitchSelect.addEventListener('change', updateRectangulo);
    xRealInput.addEventListener('input', updateRectangulo);
    yRealInput.addEventListener('input', updateRectangulo);

    // Actualiza el rectángulo o cuadrado al cargar la página inicialmente
    updateRectangulo();
});
</script>

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
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const checkbox = document.getElementById('intercambiar');

    // Evento para el cambio de pitch
    pitchSelect.addEventListener('change', function() {
        const selectedOption = pitchSelect.options[pitchSelect.selectedIndex];

        // Obtener los valores de data-medida-x e data-medida-y
        const medidaX = selectedOption.getAttribute('data-medida-x');
        const medidaY = selectedOption.getAttribute('data-medida-y');

        // Asignar los valores a los campos x_real e y_real
        xRealInput.value = medidaX || '';
        yRealInput.value = medidaY || '';
        
        // Actualizar los valores totales y los módulos
        updateTotals();
    });

    // Evento para el cambio del checkbox
    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            // Intercambiar los valores de x_real y y_real
            [xRealInput.value, yRealInput.value] = [yRealInput.value, xRealInput.value];
            // Recalcular los totales y módulos después de intercambiar
            updateTotals();
        } else {
            // Si se desmarca, mantener los valores originales
            const selectedOption = pitchSelect.options[pitchSelect.selectedIndex];
            xRealInput.value = selectedOption.getAttribute('data-medida-x') || '';
            yRealInput.value = selectedOption.getAttribute('data-medida-y') || '';
            updateTotals();
        }
    });

    function updateTotals() {
        const xDisp = parseFloat(xDispInput.value) || 0;
        const yDisp = parseFloat(yDispInput.value) || 0;
        const xReal = parseFloat(xRealInput.value) || 1;
        const yReal = parseFloat(yRealInput.value) || 1;

        const xModulo = Math.round(xDisp / xReal);
        const yModulo = Math.round(yDisp / yReal);

        const xTotal = xModulo * xReal;
        const yTotal = yModulo * yReal;

        // Asignar valores calculados a los campos de total y módulo
        xTotalInput.value = xTotal;
        yTotalInput.value = yTotal;
        moduloXInput.value = xModulo;
        moduloYInput.value = yModulo;

        // Llamar a la función para actualizar el color de los campos
        updateFieldColors();
        updateRectangulo();
    }

    function updateFieldColors() {
        const xDisp = parseFloat(xDispInput.value) || 0;
        const yDisp = parseFloat(yDispInput.value) || 0;
        const xTotal = parseFloat(xTotalInput.value) || 0;
        const yTotal = parseFloat(yTotalInput.value) || 0;

        // Actualizar el color del texto para x_total
        xTotalInput.style.color = (xTotal > xDisp) ? 'red' : 'green';

        // Actualizar el color del texto para y_total
        yTotalInput.style.color = (yTotal > yDisp) ? 'red' : 'green';

        // Asegurarse de que el fondo sea blanco
        xTotalInput.style.backgroundColor = 'white';
        yTotalInput.style.backgroundColor = 'white';
    }

    function updateRectangulo() {
        const xReal = parseFloat(xRealInput.value) || 0;
        const yReal = parseFloat(yRealInput.value) || 0;

        // Limpiar el canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Calcular escala para ajustar el dibujo al canvas
        const maxCanvasSize = 160; // Tamaño máximo para las dimensiones del canvas
        const scaleFactor = Math.min(maxCanvasSize / xReal, maxCanvasSize / yReal);
        const scaledX = xReal * scaleFactor;
        const scaledY = yReal * scaleFactor;

        // Determinar el color y forma del rectángulo
        if (xReal > yReal) {
            // Dibuja un rectángulo horizontal
            ctx.fillStyle = 'blue';
            ctx.fillRect(10, 10, scaledX, scaledY);
        } else if (xReal < yReal) {
            // Dibuja un rectángulo vertical
            ctx.fillStyle = 'green';
            ctx.fillRect(10, 10, scaledX, scaledY);
        } else {
            // Dibuja un cuadrado
            ctx.fillStyle = 'red';
            ctx.fillRect(10, 10, scaledX, scaledY);
        }
    }

    // Inicializar los valores totales al cargar la página
    updateTotals();
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const pitchSelect = document.getElementById('pitch_dispo');
    const xRealInput = document.querySelector('input[name="x_real"]');
    const yRealInput = document.querySelector('input[name="y_real"]');
    const moduloXInput = document.getElementById('modulo_x');
    const moduloYInput = document.getElementById('modulo_y');
    const pixelPorPantallaInput = document.getElementById('pixelxpantalla');
    const checkboxIntercambiar = document.getElementById('intercambiar');

    // Función para actualizar el campo pixelxpantalla
    function updatePixelPorPantalla() {
        const selectedOption = pitchSelect.options[pitchSelect.selectedIndex];
        const pitch = parseFloat(selectedOption.getAttribute('data-pitch')) || 1;  // Tomamos el valor de pitch desde data-pitch
        let xReal = parseFloat(xRealInput.value) || 0;
        let yReal = parseFloat(yRealInput.value) || 0;
        const moduloX = parseInt(moduloXInput.value) || 0;
        const moduloY = parseInt(moduloYInput.value) || 0;

        // Si el checkbox de intercambiar está marcado, intercambia x_real y y_real
        if (checkboxIntercambiar.checked) {
            [xReal, yReal] = [yReal, xReal];
        }

        // Realizar el cálculo de (modulo_x * (redondear(x_real / pitch)) * (modulo_y * redondear(y_real / pitch)))
        const pixelX = moduloX * Math.round(xReal / pitch);
        const pixelY = moduloY * Math.round(yReal / pitch);
        const pixelPorPantalla = pixelX * pixelY;

        // Asignar el resultado al campo pixelxpantalla
        pixelPorPantallaInput.value = pixelPorPantalla;
    }

    // Evento para actualizar el cálculo cuando se cambia pitch, x_real, y_real, modulo_x, modulo_y
    pitchSelect.addEventListener('change', updatePixelPorPantalla);
    xRealInput.addEventListener('input', updatePixelPorPantalla);
    yRealInput.addEventListener('input', updatePixelPorPantalla);
    moduloXInput.addEventListener('input', updatePixelPorPantalla);
    moduloYInput.addEventListener('input', updatePixelPorPantalla);

    // Evento para actualizar el cálculo cuando se cambia el checkbox de intercambiar
    checkboxIntercambiar.addEventListener('change', updatePixelPorPantalla);

    // Inicializar el cálculo cuando se carga la página
    updatePixelPorPantalla();
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const agregarProductoCheckbox = document.getElementById('agregar_Producto');
        const formularioExtra = document.getElementById('formularioExtra');

        // Mostrar/ocultar el formulario adicional cuando el checkbox cambia
        agregarProductoCheckbox.addEventListener('change', function() {
            if (this.checked) {
                formularioExtra.style.display = 'block';
            } else {
                formularioExtra.style.display = 'none';
            }
        });
    });
</script>