<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Movimientos de Entrada Almacén Principal</h1>
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
                            <div class="col-md-6">
                                <h1 class="m-0">Validar Producto</h1>
                            </div>
                        </div>

                                    <!-- MODULO -->

                        <div class="row">
                            <div class="col-md-3 campo Modulo">
                                <div class="form-group">
                                    <label for="uso">Uso</label>
                                    <select id="uso" name="uso" class="form-control">
                                        <option value="">Seleccione un Uso</option>
                                        <?php
                                        // Obtener el valor del producto seleccionado
                                        $categoria_id = 1; // Por defecto, seleccionamos el primero
                                        $query_uso = $pdo->prepare('SELECT id_uso, producto_uso FROM t_uso_productos WHERE t_productos = :categoria_id AND producto_uso IS NOT NULL AND producto_uso != "" ORDER BY producto_uso ASC');
                                        $query_uso->execute(['categoria_id' => $categoria_id]);
                                        $usos = $query_uso->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($usos as $uso): ?>
                                            <option value="<?php echo htmlspecialchars($uso['id_uso']); ?>">
                                                <?php echo htmlspecialchars($uso['producto_uso']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
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
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="pitch">Pitch</label>
                                    <select id="pitch" name="pitch" class="form-control">
                                        <option value="">Seleccione un pitch</option>
                                        <!-- Opciones dinámicas se añadirán aquí -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="medida_x">Tamaño X</label>
                                    <input type="text" id="medida_x" name="medida_x" class="form-control" placeholder="Tamaño X" >
                                </div>
                            </div>
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="medida_y">Tamaño Y</label>
                                    <input type="text" id="medida_y" name="medida_y" class="form-control" placeholder="Tamaño Y" >
                                </div>
                            </div>
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="pixel_x">Pixel X</label>
                                    <input type="text" id="pixel_x" name="pixel_x" class="form-control" placeholder="Pixel X" >
                                </div>
                            </div>
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="pixel_y">Pixel Y</label>
                                    <input type="text" id="pixel_y" name="pixel_y" class="form-control" placeholder="Pixel Y" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 campo Modulo">
                                <div class="form-group">
                                    <label for="serie_modulo">Serie Modulo</label>
                                    <input type="text" id="serie_modulo" name="serie_modulo" class="form-control" placeholder="Serie Módulo" >
                                </div>
                            </div>
                            <div class="col-md-4 campo Modulo">
                                <div class="form-group">
                                    <label for="referencia_modulo">Referencia Módulo</label>
                                    <input type="text" id="referencia_modulo" name="referencia_modulo" class="form-control" placeholder="Referencia Módulo" >
                                </div>
                            </div>
                        </div>

                                    <!-- CONTROLADORA -->

                        <div class="row">
                            <div class="col-md-8 campo Control">
                                <div class="form-group">
                                    <label for="marca_control">Marca</label>
                                    <select id="marca_control" name="marca_control" class="form-control" >
                                        <option value="">Seleccione una marca</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 campo Control">
                                <div class="form-group">
                                    <label for="funcion_control">Función</label>
                                    <select id="funcion_control" name="funcion_control" class="form-control" >
                                        <option value="">Seleccione una función</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 campo Control">
                                <div class="form-group">
                                    <label for="referencia_control">Referencia</label>
                                    <select id="referencia_control" name="referencia_control" class="form-control" >
                                        <option value="">Seleccione una referencia</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <style>
                            .oculto {
                                display: none;
                            }
                        </style>

                        <div class="row oculto">
                            <div class="col-md-4 campo Control">
                                <div class="form-group">
                                    <label for="pixel_maximo">Pixel Máximo</label>
                                    <input type="text" id="pixel_maximo" name="pixel_maximo" class="form-control" placeholder="Pixel Máximo" >
                                </div>
                            </div>
                            <div class="col-md-4 campo Control">
                                <div class="form-group">
                                    <label for="pixel_x_maximo">Pixel X Máximo</label>
                                    <input type="text" id="pixel_x_maximo" name="pixel_x_maximo" class="form-control" placeholder="Pixel X Máximo" >
                                </div>
                            </div>
                            <div class="col-md-4 campo Control">
                                <div class="form-group">
                                    <label for="pixel_y_maximo">Pixel Y Máximo</label>
                                    <input type="text" id="pixel_y_maximo" name="pixel_y_maximo" class="form-control" placeholder="Pixel Y Máximo" >
                                </div>
                            </div>
                        </div>

                        <div class="row oculto">
                            <div class="col-md-4 campo Control">
                                <div class="form-group">
                                    <label for="sim">SIM</label>
                                    <input type="text" id="sim" name="sim" class="form-control" placeholder="SIM" >
                                </div>
                            </div>
                            <div class="col-md-4 campo Control">
                                <div class="form-group">
                                    <label for="puertos">Puertos</label>
                                    <input type="text" id="puertos" name="puertos" class="form-control" placeholder="Puertos" >
                                </div>
                            </div>
                            <div class="col-md-4 campo Control">
                                <div class="form-group">
                                    <label for="pixel_x_puerto">Pixel x Puerto</label>
                                    <input type="text" id="pixel_x_puerto" name="pixel_x_puerto" class="form-control" placeholder="Pixel x Puerto" >
                                </div>
                            </div>
                        </div>

                        <div class="row oculto">
                            <div class="col-md-10 campo Control">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripcion" >
                                </div>
                            </div>
                        </div>

                                    <!-- FUENTE -->

                        <div class="row">
                            <div class="col-md-6 campo Fuente">
                                <div class="form-group">
                                    <label for="marca_fuente">Marca</label>
                                    <select name="marca_fuente" id="marca_fuente" class="form-control">
                                        <option value="">Seleccione una Marca</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 campo Fuente">
                                <div class="form-group">
                                    <label for="tipo_fuente">Tipo</label>
                                    <select name="tipo_fuente" id="tipo_fuente" class="form-control">
                                        <option value="">Seleccione un Tipo</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 campo Fuente">
                                <div class="form-group">
                                    <label for="modelo_fuente">Modelo</label>
                                    <select name="modelo_fuente" id="modelo_fuente" class="form-control">
                                        <option value="">Seleccione un Modelo</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 campo Fuente">
                                <div class="form-group">
                                    <label for="voltaje_fuente">Voltaje</label>
                                    <select name="voltaje_fuente" id="voltaje_fuente" class="form-control">
                                        <option value="">Seleccione el voltaje</option>
                                        <!-- Opciones dinámicas -->
                                    </select>
                                </div>
                            </div>
                        </div>

                                    <!-- LCD -->

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
                        </div>

                                    <!-- ALMACEN -->

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="salida_md">Almacén Origen</label>
                                                <select name="almacen_salida_md" id="almacen_salida_md" class="form-control" required>
                                                    <option value="">Almacén Origen</option>
                                                    <?php 
                                                    $query_almacen  = $pdo->prepare('SELECT * FROM t_asignar_todos_almacenes');
                                                        $query_almacen->execute();
                                                        $almacenes = $query_almacen->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($almacenes as $almacen) {
                                                            echo '<option value="' . $almacen['id_asignacion'] . '">' . $almacen['nombre_almacen'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input class="form-control" name="almacen_salida_md_id" id="almacen_salida_md_id" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="salida_md">Cantidad</label>
                                                <input type="text" name="salida_md" class="form-control" placeholder="Entrada" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7" hidden>
                                            <div class="form-group">
                                                <label for="entrada_md">Almacén Destino</label>
                                                <select name="almacen_entrada_md" id="almacen_entrada_md" class="form-control" >
                                                    <option value="">Almacén Destino</option>
                                                    <?php 
                                                    $query_almacen_entra = $pdo->prepare('SELECT * FROM t_asignar_todos_almacenes');
                                                    $query_almacen_entra->execute();
                                                    $almacenes_entras = $query_almacen_entra->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($almacenes_entras as $almacen_entra) {
                                                        $selected = ($almacen_entra['id_asignacion'] == 3) ? 'selected' : '';
                                                        echo '<option value="' . $almacen_entra['id_asignacion'] . '" ' . $selected . '>' . $almacen_entra['nombre_almacen'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input class="form-control" name="almacen_entrada_md_id" id="almacen_entrada_md_id" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-3" hidden>
                                            <div class="form-group">
                                                <label for="entrada_md">Entrada</label>
                                                <input type="text" name="entrada_md" class="form-control" placeholder="Cantidad Entrada" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="op_destino">Asignar a:</label>
                                                <input type="text" name="op_destino" class="form-control" placeholder="Asignar" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="observacion">Observaciones</label>
                                                <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control" placeholder="Observaciones"></textarea>
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
                                    <a href="<?php echo $URL."admin/almacen/mv_diario/";?>" class="btn btn-default btn-block">Cancelar</a>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear Movimiento</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../../../../layout/admin/parte2.php');?>

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

<script>

//visualizar los id de almacen
document.addEventListener('DOMContentLoaded', function() {
    const selectSalida = document.getElementById('almacen_salida_md');
    const salidaID = document.getElementById('almacen_salida_md_id');
    const selectEntrada = document.getElementById('almacen_entrada_md');
    const entradaID = document.getElementById('almacen_entrada_md_id');

    selectSalida.addEventListener('change', function() {
        salidaID.value = selectSalida.value;
    });

    selectEntrada.addEventListener('change', function() {
        entradaID.value = selectEntrada.value;
    });
});

document.addEventListener('DOMContentLoaded', function() {

    // Agregar funcionalidad para verificar si Almacén Origen y Almacén Destino son iguales
    const selectSalida = document.getElementById('almacen_salida_md');
    const selectEntrada = document.getElementById('almacen_entrada_md');

    function verificarAlmacenes() {
        if (selectSalida.value && selectEntrada.value && selectSalida.value === selectEntrada.value) {
            alert("El Almacén Origen y el Almacén Destino no pueden ser iguales. Por favor, seleccione almacenes diferentes.");
            selectEntrada.value = ''; // Vaciar el campo de Almacén Destino para obligar a seleccionar uno diferente
        }
    }

    selectSalida.addEventListener('change', verificarAlmacenes);
    selectEntrada.addEventListener('change', verificarAlmacenes);
});

document.addEventListener('DOMContentLoaded', function() {
    // Obtener referencias a los campos de entrada y salida
    const salidaMdInput = document.getElementsByName('salida_md')[0];
    const entradaMdInput = document.getElementsByName('entrada_md')[0];

    // Función para actualizar el campo entrada_md
    function actualizarEntradaMd() {
        entradaMdInput.value = salidaMdInput.value; // Establecer el mismo valor que salida_md
    }

    // Escuchar cambios en el campo salida_md y llamar a la función actualizarEntradaMd
    salidaMdInput.addEventListener('input', actualizarEntradaMd);
});
</script>

    <!--    MÓDULOS     -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const usoSelect = document.getElementById('uso');
        const modeloSelect = document.getElementById('modelo_modulo1');
        const pitchSelect = document.getElementById('pitch');
        const medidaX = document.getElementById('medida_x');
        const medidaY = document.getElementById('medida_y');
        const pixelX = document.getElementById('pixel_x');
        const pixelY = document.getElementById('pixel_y');
        const serieModulo = document.getElementById('serie_modulo');
        const referenciaModulo = document.getElementById('referencia_modulo');

    // Evento para cambiar el uso
    usoSelect.addEventListener('change', function () {
        const usoId = this.value;

        // Limpiar los campos dependientes
        modeloSelect.innerHTML = '<option value="">Seleccione un modelo</option>';
            pitchSelect.innerHTML = '<option value="">Seleccione un pitch</option>';
            medidaX.value = '';
            medidaY.value = '';
            pixelX.value = '';
            pixelY.value = '';
            serieModulo.value = '';
            referenciaModulo.value = '';

        if (usoId) {
            fetch(`fetch_modelo1.php?uso=${usoId}`)
                .then(response => response.json())
                .then(data => {
                    modeloSelect.innerHTML = '<option value="">Seleccione un modelo</option>';
                    data.forEach(modelo => {
                        const option = document.createElement('option');
                        option.value = modelo.id;
                        option.textContent = modelo.modelo_modulo;
                        modeloSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al obtener modelos:', error));
        } else {
            modeloSelect.innerHTML = '<option value="">Seleccione un modelo</option>';
        }
    });

    // Evento para cambiar el modelo
    modeloSelect.addEventListener('change', function () {
        const modeloId = this.value;

         // Limpiar los campos dependientes
            pitchSelect.innerHTML = '<option value="">Seleccione un pitch</option>';
            medidaX.value = '';
            medidaY.value = '';
            pixelX.value = '';
            pixelY.value = '';
            serieModulo.value = '';
            referenciaModulo.value = '';

        if (modeloId) {
            fetch(`fetch_pitch1.php?modelo=${modeloId}`)
                .then(response => response.json())
                .then(data => {
                    pitchSelect.innerHTML = '<option value="">Seleccione un pitch</option>';
                    data.forEach(pitch => {
                        const option = document.createElement('option');
                        option.value = pitch.id_car_mod;
                        option.textContent = pitch.pitch;
                        pitchSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al obtener pitch:', error));
        } else {
            pitchSelect.innerHTML = '<option value="">Seleccione un pitch</option>';
        }
    });

    // Evento para cambiar el pitch
    pitchSelect.addEventListener('change', function () {
    const pitchValue = this.value;

    if (pitchValue) {
        fetch(`fetch_medidas1.php?pitch=${pitchValue}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    document.getElementById('medida_x').value = data[0].medida_x;
                    document.getElementById('medida_y').value = data[0].medida_y;
                    document.getElementById('pixel_x').value = data[0].pixel_x;
                    document.getElementById('pixel_y').value = data[0].pixel_y;
                    document.getElementById('serie_modulo').value = data[0].serie_modulo;
                    document.getElementById('referencia_modulo').value = data[0].referencia_modulo;
                }
            })
            .catch(error => console.error('Error al obtener medidas:', error));
    } else {
        document.getElementById('medida_x').value = '';
        document.getElementById('medida_y').value = '';
        document.getElementById('pixel_x').value = '';
        document.getElementById('pixel_y').value = '';
        document.getElementById('serie_modulo').value = '';
        document.getElementById('referencia_modulo').value = '';
        }
    });
});



</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const usoSelect = document.getElementById('uso');
    const modeloSelect = document.getElementById('modelo_modulo1');
    const pitchSelect = document.getElementById('pitch');
    const productoSelect = document.getElementById('producto'); // Agregar referencia al campo "producto"
    
    
    const uso3Field = document.getElementById('uso3');
    const modeloModulo3Field = document.getElementById('modelo_modulo3');
    const pitch3Field = document.getElementById('pitch3');
    const medidaX3Field = document.getElementById('medida_x3');
    const medidaY3Field = document.getElementById('medida_y3');
    const pixelX3Field = document.getElementById('pixel_x3');
    const pixelY3Field = document.getElementById('pixel_y3');
    const serieModulo3Field = document.getElementById('serie_modulo3');
    const referenciaModulo3Field = document.getElementById('referencia_modulo3');

    function actualizarCampos() {
        console.log('Valor de productoSelect:', productoSelect.value); // Debug: Verifica el valor seleccionado
        if (productoSelect === "1" || productoSelect === "Modulo") {
            // Si se selecciona "1" o "Módulo" en el campo "producto", deshabilitar todos los campos excepto uso3Field
            uso3Field.disabled = false;
            modeloModulo3Field.disabled = true;
            pitch3Field.disabled = true;
            medidaX3Field.disabled = true;
            medidaY3Field.disabled = true;
            pixelX3Field.disabled = true;
            pixelY3Field.disabled = true;
            serieModulo3Field.disabled = true;
            referenciaModulo3Field.disabled = true;
        } else if (usoSelect.value) {
            // Deshabilitar todos los campos excepto modelo_modulo3
            uso3Field.disabled = true;
            pitch3Field.disabled = true;
            medidaX3Field.disabled = true;
            medidaY3Field.disabled = true;
            pixelX3Field.disabled = true;
            pixelY3Field.disabled = true;
            serieModulo3Field.disabled = true;
            referenciaModulo3Field.disabled = true;
            modeloModulo3Field.disabled = false;

            if (modeloSelect.value) {
                // Si se selecciona uso y modelo_modulo1, habilitar pitch3 y medidas/píxeles
                modeloModulo3Field.disabled = true;
                pitch3Field.disabled = false;
                medidaX3Field.disabled = false;
                medidaY3Field.disabled = false;
                pixelX3Field.disabled = false;
                pixelY3Field.disabled = false;
                serieModulo3Field.disabled = false;
                referenciaModulo3Field.disabled = false;

                if (pitchSelect.value) {
                    // Si se selecciona pitch, deshabilitar pitch3 y dejar habilitadas medidas y píxeles
                    pitch3Field.disabled = true;
                }
            }
        } else {
            // Si no se selecciona uso, habilitar todos los campos
            uso3Field.disabled = false;
            modeloModulo3Field.disabled = false;
            pitch3Field.disabled = false;
            medidaX3Field.disabled = false;
            medidaY3Field.disabled = false;
            pixelX3Field.disabled = false;
            pixelY3Field.disabled = false;
            serieModulo3Field.disabled = false;
            referenciaModulo3Field.disabled = false;
        }
    }

    // Llamar a la función al cambiar cualquiera de los tres campos
    usoSelect.addEventListener('change', actualizarCampos);
    modeloSelect.addEventListener('change', actualizarCampos);
    pitchSelect.addEventListener('change', actualizarCampos);
    
    // Ejecutar la función al cargar la página para establecer el estado inicial
    actualizarCampos();
});
</script>

    <!--    CONTROLADORAS   -->

<script>
    document.getElementById('producto').addEventListener('change', function() {
        const producto = this.value;
        
        if (producto == 2) { // Si selecciona "Controladora"
            cargarMarcas();
            document.getElementById('marca_control').disabled = false;
        } else {
            document.getElementById('marca_control').disabled = true;
            document.getElementById('funcion_control').disabled = true;
            document.getElementById('referencia_control').disabled = true;

            // Limpia los campos
            document.getElementById('marca_control').innerHTML = '<option value="">Seleccionar...</option>';
            document.getElementById('funcion_control').innerHTML = '<option value="">Seleccionar...</option>';
            document.getElementById('referencia_control').innerHTML = '<option value="">Seleccionar...</option>';
        }
    });

    document.getElementById('marca_control').addEventListener('change', function() {
        const id_car_ctrl = this.value;
        // Limpia los campos
        document.getElementById('funcion_control').innerHTML = '<option value="">Seleccionar...</option>';
        document.getElementById('referencia_control').innerHTML = '<option value="">Seleccionar...</option>';
        cargarFunciones(id_car_ctrl);
        document.getElementById('funcion_control').disabled = false;
    });

    document.getElementById('funcion_control').addEventListener('change', function() {
        const funcion = this.value;
        cargarReferencias(funcion);
        document.getElementById('referencia_control').disabled = false;
    });

    function cargarMarcas() {
        fetch('cargar_marcas1.php')
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById('marca_control');
                select.innerHTML = '<option value="">Seleccionar...</option>';
                data.forEach(marca => {
                    select.innerHTML += `<option value="${marca.id_car_ctrl}">${marca.marca_control}</option>`;
                });
            });
    }

    function cargarFunciones(id_car_ctrl) {
        fetch(`cargar_funciones1.php?id_car_ctrl=${id_car_ctrl}`)
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById('funcion_control');
                select.innerHTML = '<option value="">Seleccionar...</option>';
                data.forEach(funcion => {
                    select.innerHTML += `<option value="${funcion.id_car_ctrl}">${funcion.funcion_control}</option>`;
                });
            });
    }

    document.getElementById('funcion_control').addEventListener('change', function() {
    const funcion = this.value;
    const marca = document.getElementById('marca_control').value;

    // Limpia los campos
    document.getElementById('referencia_control').innerHTML = '<option value="">Seleccionar...</option>';
    document.getElementById('sim').value = '';
    document.getElementById('descripcion').value = '';
    document.getElementById('puertos').value = '';
    document.getElementById('pixel_maximo').value = '';
    document.getElementById('pixel_x_maximo').value = '';
    document.getElementById('pixel_y_maximo').value = '';
    document.getElementById('pixel_x_puerto').value = '';

    cargarReferencias(marca, funcion);
    document.getElementById('referencia_control').disabled = false;
});

function cargarReferencias(marca, funcion) {
    fetch(`cargar_referencias1.php?marca=${marca}&funcion=${funcion}`)
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById('referencia_control');
            select.innerHTML = '<option value="">Seleccionar...</option>';
            data.forEach(referencia => {
                select.innerHTML += `<option value="${referencia.id_referencia}">${referencia.referencia}</option>`;
            });
        });
}

// Añadir un event listener al campo 'referencia_control'
document.getElementById('referencia_control').addEventListener('change', function() {
    const idReferencia = this.value;
    cargarDetalles(idReferencia);
});

function cargarDetalles(idReferencia) {
    fetch(`cargar_detalles1.php?id_referencia=${idReferencia}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);  // Depuración
            // Llenar los campos con los datos correspondientes
            document.getElementById('sim').value = data.sim;
            document.getElementById('descripcion').value = data.descripcion;
            document.getElementById('puertos').value = data.puertos;
            document.getElementById('pixel_maximo').value = data.pixel_max;
            document.getElementById('pixel_x_maximo').value = data.pixel_x_max;
            document.getElementById('pixel_y_maximo').value = data.pixel_y_max;
            document.getElementById('pixel_x_puerto').value = data.px_x_puerto;
        });
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Obtener los elementos
    const productoSelect = document.getElementById('producto');
    const marcaControl = document.getElementById('marca_control');
    const funcionControl = document.getElementById('funcion_control');
    const referenciaControl = document.getElementById('referencia_control');

    const marcaControl3 = document.getElementById('marca_control3');
    const funcionControl3 = document.getElementById('funcion_control3');
    const referenciaControl3 = document.getElementById('referencia_control3');
    const pixelMaximo3 = document.getElementById('pixel_maximo3');
    const pixelXMaximo3 = document.getElementById('pixel_x_maximo3');
    const pixelYMaximo3 = document.getElementById('pixel_y_maximo3');
    const sim3 = document.getElementById('sim3');
    const puertos3 = document.getElementById('puertos3');
    const pixelXPuerto3 = document.getElementById('pixel_x_puerto3');
    const descripcion3 = document.getElementById('descripcion3');

    // Agregar eventos para actualizar los campos al cambiar las selecciones
    productoSelect.addEventListener('change', actualizarCampos);
    marcaControl.addEventListener('change', actualizarCampos);
    funcionControl.addEventListener('change', actualizarCampos);
    referenciaControl.addEventListener('change', actualizarCampos);

    // Ejecutar la función al cargar la página para establecer el estado inicial
    actualizarCampos();
});
</script>

    <!--    FUENTES     -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Obtener los elementos
    const productoSelect = document.getElementById('producto');
    const marcaFuenteSelect = document.getElementById('marca_fuente');
    const tipoFuenteSelect = document.getElementById('tipo_fuente');
    const modeloFuenteSelect = document.getElementById('modelo_fuente');
    const voltajeFuenteSelect = document.getElementById('voltaje_fuente');
    
    const marcaFuente3 = document.getElementById('marca_fuente');
    const tipoFuente3 = document.getElementById('tipo_fuente');
    const modeloFuente3 = document.getElementById('modelo_fuente');
    const voltajeFuente3 = document.getElementById('voltaje_fuente');

    // Agregar eventos para actualizar los campos al cambiar las selecciones
    productoSelect.addEventListener('change', actualizarCampos);
    marcaFuenteSelect.addEventListener('change', actualizarCampos);
    tipoFuenteSelect.addEventListener('change', actualizarCampos);
    modeloFuenteSelect.addEventListener('change', actualizarCampos);
    voltajeFuenteSelect.addEventListener('change', actualizarCampos);

    // Ejecutar la función al cargar la página para establecer el estado inicial
    actualizarCampos();
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const productoSelect = document.getElementById('producto');
    const marcaFuenteSelect = document.getElementById('marca_fuente');
    const tipoFuenteSelect = document.getElementById('tipo_fuente');
    const modeloFuenteSelect = document.getElementById('modelo_fuente');
    const voltajeFuenteSelect = document.getElementById('voltaje_fuente');
    
    function actualizarCampos() {

        if (productoSelect.value === '3') { // Si selecciona "Fuente"
            cargarMarcasFuente();

        } else {
            // Limpia los campos y deshabilita si no es "Fuente"
            marcaFuenteSelect.innerHTML = '<option value="">Seleccionar...</option>';
            tipoFuenteSelect.innerHTML = '<option value="">Seleccionar...</option>';
            modeloFuenteSelect.innerHTML = '<option value="">Seleccionar...</option>';
            voltajeFuenteSelect.innerHTML = '<option value="">Seleccionar...</option>';
        }
    }

    productoSelect.addEventListener('change', actualizarCampos);
    marcaFuenteSelect.addEventListener('change', function() {
        cargarTiposFuente(this.value);
    });

    tipoFuenteSelect.addEventListener('change', function() {
        cargarModelosFuente(marcaFuenteSelect.value, this.value);
    });

                    /*  Código nuevo    */
    modeloFuenteSelect.addEventListener('change', function() {
    const idModeloFuente = this.value;
    cargarVoltajeFuente(marcaFuenteSelect.value, tipoFuenteSelect.value, idModeloFuente);
});
                    /*  Fin Código Nuevo    */

    function cargarMarcasFuente() {
        fetch('cargar_marcas_fuente1.php')
            .then(response => response.json())
            .then(data => {
                marcaFuenteSelect.innerHTML = '<option value="">Seleccionar...</option>';
                data.forEach(marca => {
                    marcaFuenteSelect.innerHTML += `<option value="${marca.id_car_fuen}">${marca.marca_fuente}</option>`;
                });
            });
    }

    function cargarTiposFuente(idCarFuen) {
        fetch(`cargar_tipos_fuente1.php?id_car_fuen=${idCarFuen}`)
            .then(response => response.json())
            .then(data => {
                tipoFuenteSelect.innerHTML = '<option value="">Seleccionar...</option>';
                data.forEach(tipo => {
                    tipoFuenteSelect.innerHTML += `<option value="${tipo.id_car_fuen}">${tipo.tipo_fuente}</option>`;
                });
            });
    }

                        /*  Código Nuevo    */
    function cargarModelosFuente(idCarFuen, tipoFuente) {
    fetch(`cargar_modelos_fuente1.php?id_car_fuen=${idCarFuen}&tipo_fuente=${tipoFuente}`)
        .then(response => response.json())
        .then(data => {
            modeloFuenteSelect.innerHTML = '<option value="">Seleccionar...</option>';
            data.forEach(modelo => {
                modeloFuenteSelect.innerHTML += `<option value="${modelo.id_referencias_fuentes}">${modelo.modelo_fuente}</option>`;
            });
        });
}
                        /*  Fin Código Nuevo    */

                        /*  Código Nuevo    */
    // Carga los valores de voltaje basados en la selección de marca, tipo y modelo
    function cargarVoltajeFuente(idCarFuen, tipoFuente, modeloFuente) {
        fetch(`cargar_voltaje_fuente1.php?marca_fuente=${idCarFuen}&tipo_fuente=${tipoFuente}&modelo_fuente=${modeloFuente}`)
            .then(response => response.json())
            .then(data => {
                voltajeFuenteSelect.innerHTML = '<option value="">Seleccionar...</option>';
                data.forEach(voltaje => {
                    voltajeFuenteSelect.innerHTML += `<option value="${voltaje}">${voltaje}</option>`;
                });
            });
    }

    // Ejecutar la función al cargar la página para establecer el estado inicial
    actualizarCampos();
});
</script>