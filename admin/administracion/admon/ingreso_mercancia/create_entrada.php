<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

    // Consulta para obtener módulos sin referencia
    $query_referencia = $pdo->prepare('SELECT pmc.*, pmc.id, pmc.serie, ttm.tamanos_modulos as nombre_tamano FROM producto_modulo_creado as pmc LEFT JOIN tabla_tamanos_modulos AS ttm ON pmc.tamano = ttm.id WHERE referencia IS NULL');
    $query_referencia->execute();
    
    // Obtener los módulos sin referencia
    $modulosSinReferencia = $query_referencia->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Movimientos de Entrada </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue" style="width: 120rem;">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create.php" method="POST" id="formulario_creacion_producto">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="fecha">Fecha</label>
                                                    <input type="date" id="fecha" name="fecha" class="form-control" placeholder="Fecha" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="hora">Hora</label>
                                                    <input type="time" id="hora" name="hora" class="form-control" placeholder="Hora" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="contador_entra">Contador de Entrada</label>
                                                    <input type="text" id="id_generado12" name="id_generado12" class="form-control" required readonly>
                                                    <input type="hidden" id="contador_entra" name="contador_entra" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                                    <label for="idusuario">Usuario</label>
                                                    <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="salida_md">Almacén Origen</label>
                                                    <select name="almacen_salida_md" id="almacen_salida_md" class="form-control" required>
                                                        <option value="">Almacén Origen</option>
                                                        <?php 
                                                        $query_almacen  = $pdo->prepare('SELECT * FROM t_asignar_todos_almacenes WHERE id_asignacion  IN (12) ORDER BY nombre_almacen ASC');
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
                                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                                    <label for="bodega">BODEGA</label>
                                                    <select name="bodega" id="bodega" class="form-control" required>
                                                        <option value="">Seleccione una Bodega</option>
                                                        <?php
                                                        $query_posicion = $pdo->prepare('SELECT * FROM t_bodegas');
                                                        $query_posicion->execute();
                                                        $posiciones = $query_posicion->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($posiciones as $posicion) {
                                                            echo '<option value="' . $posicion['id'] . '">' . $posicion['nombre_bodega'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="almacen_entra">Almacén</label>
                                                    <select name="almacen_entra" id="almacen_entra" class="form-control" required>
                                                        <option value="">Seleccione un Almacen</option>
                                                        <?php
                                                        $query_producto = $pdo->prepare('SELECT id, almacenes FROM almacenes_grupo WHERE almacenes IS NOT NULL AND almacenes != "" AND habilitar = "1" ORDER BY almacenes ASC');
                                                        $query_producto->execute();
                                                        $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($productos as $producto) {
                                                            echo '<option value="' . $producto['id'] . '">' . $producto['almacenes'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="sub_almacen">Sub Almacén</label>
                                                    <select name="sub_almacen" id="sub_almacen" class="form-control" required>
                                                        <option value="">Seleccione un Sub Almacen</option>
                                                        <?php
                                                        $query_producto = $pdo->prepare('SELECT id, sub_almacen FROM t_sub_almacen WHERE sub_almacen IS NOT NULL AND sub_almacen != "" AND habilitar = "1" ORDER BY sub_almacen ASC');
                                                        $query_producto->execute();
                                                        $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($productos as $producto) {
                                                            echo '<option value="' . $producto['id'] . '">' . $producto['sub_almacen'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group cloned-section">
                                            <div class="row">
                                                <div class="col-md-4 items_pre">
                                                    <div class="form-group">
                                                        <label for="items" class="d-block mb-0">Items</label>
                                                        <input type="text" id="items" name="items[]" class="form-control" value="1" readonly>
                                                        <input type="hidden" id="item_data" name="item_data">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="producto" class="d-block mb-0">Categoría</label>
                                                        <select id="producto" name="producto[]" class="form-control">
                                                            <option value="">Seleccione un Producto</option>
                                                            <?php
                                                            $query_producto = $pdo->prepare('SELECT id_producto, tipo_producto FROM t_productos WHERE tipo_producto IS NOT NULL AND tipo_producto != "" AND habilitar = "1" ORDER BY tipo_producto ASC');
                                                            $query_producto->execute();
                                                            $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($productos as $producto) {
                                                                echo '<option value="' . $producto['id_producto'] . '">' . $producto['tipo_producto'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="entrada_md" class="d-block mb-0">Cantidad</label>
                                                        <input type="text" id="entrada_md" name="entrada_md[]" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- MODULO -->

                                            <div class="row">
                                                    <div class="col-md-6 items_pre campo Modulo">
                                                        <div class="form-group">
                                                            <label for="pitch" class="d-block mb-0">Pitch</label>
                                                            <select id="pitch" name="pitch[]" class="form-control">
                                                                <option value=""></option>
                                                                <?php 
                                                                $query_pitch = $pdo->prepare('SELECT DISTINCT
                                                                                                        pmc.pitch, 
                                                                                                        tp.pitch AS pitch_nombre
                                                                                                    FROM
                                                                                                        producto_modulo_creado AS pmc
                                                                                                    INNER JOIN
                                                                                                        tabla_pitch AS tp ON pmc.pitch = tp.id
                                                                                                    ORDER BY
                                                                                                        tp.pitch ASC
                                                                                                    ');
                                                                $query_pitch->execute();
                                                                $pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach ($pitches as $pitch): ?>
                                                                <option value="<?php echo $pitch['pitch']; ?>">
                                                                    <?php echo $pitch['pitch_nombre']; ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 items_pre campo Modulo">
                                                        <div class="form-group">
                                                            <label for="serie_modulo" class="d-block mb-0">Serie</label>
                                                            <select id="serie_modulo" name="serie_modulo[]" class="form-control">
                                                                <option value=""></option>
                                                                <!-- Las opciones se llenarán dinámicamente vía AJAX -->
                                                            </select>
                                                            <input type="hidden" id="id_serie_modulo" name="id_serie_modulo[]">
                                                        </div>
                                                    </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 items_pre campo Modulo">
                                                    <div class="form-group">
                                                        <label for="referencia_modulo" class="d-block mb-0">Referencia</label>
                                                        <input type="text" id="campo_referencia" name="campo_referencia[]" class="form-control" readonly>
                                                        <!-- Campos ocultos para almacenar los valores de serie y referencia -->
                                                        <input type="hidden" id="campo_serie" name="campo_serie[]">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- CONTROLADORA -->

                                            <div class="row">
                                                <div class="col-md-6 items_pre campo Control">
                                                    <div class="form-group">
                                                        <label for="marca_control" class="d-block mb-0">Marca</label>
                                                        <select id="marca_control" name="marca_control[]" class="form-control" >
                                                            <option value=""></option>
                                                            <?php 
                                                            $query_marca_control = $pdo->prepare('SELECT id_car_ctrl, marca_control FROM caracteristicas_control WHERE marca_control IS NOT NULL AND marca_control != "" ORDER BY marca_control ASC');
                                                            $query_marca_control->execute();
                                                            $marcas_controles = $query_marca_control->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($marcas_controles as $marca_control): ?>
                                                            <option value="<?php echo $marca_control['id_car_ctrl']; ?>">
                                                                <?php echo $marca_control['marca_control']; ?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 items_pre campo Control">
                                                    <div class="form-group">
                                                        <label for="referencia_control35" class="d-block mb-0">Referencia</label>
                                                        <select id="referencia_control35" name="referencia_control35[]" class="form-control" >
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- FUENTE -->

                                            <div class="row">
                                                <div class="col-md-6 items_pre campo Fuente">
                                                        <div class="form-group">
                                                            <label for="marca_fuente" class="d-block mb-0">Marca</label>
                                                            <select id="marca_fuente" name="marca_fuente[]" class="form-control">
                                                                <option value=""></option>
                                                                <?php 
                                                                $query_modelo_fuente = $pdo->prepare('SELECT id_car_fuen, marca_fuente FROM caracteristicas_fuentes WHERE marca_fuente IS NOT NULL AND marca_fuente != ""  ORDER BY marca_fuente ASC');
                                                                $query_modelo_fuente->execute();
                                                                $modelos_fuentes = $query_modelo_fuente->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach ($modelos_fuentes as $modelo_fuente): ?>
                                                                <option value="<?php echo $modelo_fuente['id_car_fuen']; ?>">
                                                                    <?php echo $modelo_fuente['marca_fuente']; ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="col-md-6 items_pre campo Fuente">
                                                        <div class="form-group">
                                                            <label for="modelo_fuente35" class="d-block mb-0">Modelo</label>
                                                            <select id="modelo_fuente35" name="modelo_fuente35[]" class="form-control">
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>

                                            <!-- LCD -->

                                            <div class="row">
                                                    <div class="col-md-6 items_pre campo LCD">
                                                        <div class="form-group">
                                                            <label for="marca_lcd" class="d-block mb-0">Marca</label>
                                                            <input type="text" id="marca_lcd" name="marca_lcd" class="form-control" placeholder="Marca">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 items_pre campo LCD">
                                                        <div class="form-group">
                                                            <label for="modelo_lcd" class="d-block mb-0">Modelo</label>
                                                            <input type="text" id="modelo_lcd" name="modelo_lcd" class="form-control" placeholder="Modelo">
                                                        </div>
                                                    </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 items_pre">
                                                    <div class="form-group">
                                                        <label for="justificacion" class="d-block mb-0">Observaciones</label>
                                                        <textarea id="justificacion" name="justificacion[]" class="form-control" rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- Botón para añadir item -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary btn-block" id="add_item">Añadir Item</button>
                                                </div>
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
                                                    <th>Categoría</th>
                                                    <th>Pitch</th>
                                                    <th>Serie</th>
                                                    <th>Referencia</th>
                                                    <th>Marca</th>
                                                    <th>Referencia</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Justificaión</th>
                                                    <th>Cantidad</th>
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <a href="<?php echo $URL."admin/administracion/admon/ingreso_mercancia";?>" class="btn btn-default btn-block">Cancelar</a>
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

    <!-- Estilo para el Modal -->
    <style>
    .modal {
        display: none; /* Oculto por defecto */
        position: fixed;
        z-index: 1050;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5); /* Fondo oscuro */
    }
    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }
    </style>

    <!-- Script para validar el formulario en el modal y evitar el envío si hay campos incompletos -->
    <script>
        function validarFormulario(form) {
            // Obtener los valores de referencia e imagen
            var referencia = form.referencia.value.trim();
            var imagen = form.imagen.value;

            // Validar que ambos campos estén diligenciados
            if (referencia === "" || imagen === "") {
                alert("Por favor, complete todos los campos antes de enviar.");
                return false; // Evita el envío del formulario
            }
            return true; // Permite el envío del formulario
        }

        function cerrarModal() {
            // Ocultar el modal solo si no existen formularios con campos incompletos
            var forms = document.querySelectorAll('#modalReferencia form');
            var completo = true;

            forms.forEach(function(form) {
                if (!validarFormulario(form)) {
                    completo = false;
                }
            });

            if (completo) {
                document.getElementById('modalReferencia').style.display = 'none';
            } else {
                alert("Por favor, complete todas las referencias e imágenes antes de cerrar el modal.");
            }
        }
    </script>

    <!-- Script para actualizar los campos según el producto seleccionado -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener y establecer la fecha actual (yyyy-mm-dd)
        var fechaInput = document.getElementById('fecha');
        if (fechaInput) {
            fechaInput.value = new Date().toISOString().split('T')[0];
        }

        // Obtener y establecer la hora actual (hh:mm)
        var horaInput = document.getElementById('hora');
        if (horaInput) {
            var now = new Date();
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            horaInput.value = hours + ':' + minutes;
        }

        // Ocultar todos los campos al cargar la página
        var campos = document.querySelectorAll('.campo');
        campos.forEach(function(campo) {
            campo.style.display = 'none';
        });

        // Evento cuando cambia el producto
        var productoSelect = document.getElementById('producto');
        if (productoSelect) {
            productoSelect.addEventListener('change', actualizarCampos);
        }

        // Función para mostrar/ocultar campos según el producto seleccionado
        function actualizarCampos() {
            var producto = productoSelect.value.trim(); // No es necesario toLowerCase() si son números

            // Ocultar todos los campos
            campos.forEach(campo => campo.style.display = 'none');

            // Determinar qué mostrar usando switch
            switch (producto) {
                case "1":
                    mostrarCampos('Modulo');
                    break;
                case "2":
                    mostrarCampos('Control');
                    break;
                case "3":
                    mostrarCampos('Fuente');
                    break;
                case "4":
                    mostrarCampos('LCD');
                    break;
                case "5":
                    mostrarCampos('Accesorios');
                    break;
            }
        }

        function mostrarCampos(clase) {
            document.querySelectorAll('.' + clase).forEach(campo => {
                campo.style.display = 'block';
            });
        }
    });
    </script>

    <!-- Script para calcular el total de la referencia -->
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

    <!-- Script para obtener la serie y referencia del módulo seleccionado -->
    <script>
        document.getElementById('serie_modulo').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];

            // Obtener el valor de referencia desde el atributo 'data-referencia' del option seleccionado
            var referencia = selectedOption.getAttribute('data-referencia');
            var serie = selectedOption.textContent.split(' / ')[0]; // Extraer solo la parte de la serie, antes del "/"

            // Puedes usar estos valores para actualizar otros campos o realizar otras acciones
            console.log('Serie:', serie);  // El valor de serie
            console.log('Referencia:', referencia);  // El valor de referencia

            // Si deseas enviar ambos valores a través de un campo oculto o similar
            document.getElementById('campo_serie').value = serie;  // Asignar serie a un campo oculto (ejemplo)
            document.getElementById('campo_referencia').value = referencia;  // Asignar referencia a otro campo
        });
    </script>

    <!-- Script para obtener la referencia del id del almacen seleccionado -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const almacenSelect = document.getElementById("almacen_entra");
        const idGeneradoInput = document.getElementById("id_generado12");
        const contadorEntraInput = document.getElementById("contador_entra"); // Asegúrate de que este campo exista en tu formulario


        almacenSelect.addEventListener("change", function () {
            const almacenEntra = this.value;

            if (almacenEntra) {
                fetch("generar_id.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "almacen_entra=" + almacenEntra
                })
                .then(response => response.json())
                .then(data => {
                    if (data.id_generado12) {
                        idGeneradoInput.value = data.id_generado12;
                    }
                    if (data.contador_entra) {
                    contadorEntraInput.value = data.contador_entra; // Asigna el contador al campo correspondiente
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        });
    });
    </script>

    <!-- Script para limpiar los campos del formulario -->
    <script>
    $(document).ready(function() {
        // Detectar cuando cambie el valor del campo 'producto'
        $('#producto').change(function() {
            limpiarCampos(); // Llama a la función que limpia los campos
        });

        // Función para limpiar todos los campos del formulario, excluyendo el campo 'producto'
        function limpiarCampos() {
            // Limpiar todos los inputs de texto, select y textarea, excepto el campo 'producto'
            $('input[type="text"]').not('#id_generado12, #items, #contador_entra').val('');  // Limpiar campos de texto excepto 'producto'
            $('input[type="number"]').val(''); // Limpiar campos numéricos
            $('input[type="file"]').val(''); // Limpiar campo de archivo
            $('select').not('#producto, #almacen_entra, #bodega, #sub_almacen, #almacen_salida_md').val(''); // Limpiar selects excepto 'producto'
            $('textarea').val(''); // Limpiar textareas

            // También puedes vaciar los campos ocultos, si es necesario
            $('input[type="hidden"]').not('#contador_entra').val('');

            // Si tienes algún campo específico que necesitas manejar aparte, puedes hacerlo aquí.
            $('#list').empty(); // Vaciar la lista de imágenes si es necesario
            $('#lista_seriales').not('#items').empty(); // Vaciar la tabla de seriales
            seriales = []; // Reiniciar la lista de seriales (si usas esa variable)
        }
    });

    document.getElementById('pitch').addEventListener('change', function() {
    var pitchId = this.value;

        // Limpiar el campo "campo_referencia" cuando cambie el pitch
        document.getElementById('campo_referencia').value = '';

    // Hacer una solicitud AJAX para obtener los registros filtrados
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get_serie_modulo.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Actualizar el contenido del campo serie_modulo
            document.getElementById('serie_modulo').innerHTML = xhr.responseText;

            // Agregar un evento para detectar cuando cambie la selección
            document.getElementById('serie_modulo').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var selectedId = selectedOption.value; // Obtiene el "id" de la serie seleccionada

                // Asignar el valor del "id" al campo id_serie_modulo
                document.getElementById('id_serie_modulo').value = selectedId;
            });
        }
    };
    xhr.send('pitch_id=' + pitchId);
    });


    document.getElementById('marca_control').addEventListener('change', function() {
        var marcaControlValue = this.value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_referencia_control.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('referencia_control35').innerHTML = xhr.responseText;
            }
        };
        xhr.send('marca_control=' + marcaControlValue);
    });

    document.getElementById('marca_fuente').addEventListener('change', function() {
        var marcaFuenteValue = this.value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_modelo_fuente.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('modelo_fuente35').innerHTML = xhr.responseText;
            }
        };
        xhr.send('marca_fuente=' + marcaFuenteValue);
    });
    </script>

    <!-- Script para añadir y eliminar items en la tabla -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("add_item").addEventListener("click", function () {
        agregarFila(); // Agrega la fila a la tabla
        limpiarCampos(); // Limpia los campos después de agregar
    });

    function agregarFila() {
        // Obtener valores de los inputs y selects, asegurando que si están vacíos, sean ""
        const cantidadEntradaMd = document.querySelector('input[name="entrada_md[]"]').value || "";
        const producto = document.querySelector('select[name="producto[]"] option:checked')?.value || "";
        const pitch = document.querySelector('select[name="pitch[]"] option:checked')?.value || "";
        const serieModulo = document.querySelector('select[name="serie_modulo[]"] option:checked')?.value || "";
        const campoReferencia = document.querySelector('input[name="campo_referencia[]"]')?.value || "";
        const campoSerie = document.getElementById("id_serie_modulo")?.value || "";
        const marcaControl = document.querySelector('select[name="marca_control[]"] option:checked')?.value || "";
        const referenciaControl35 = document.querySelector('select[name="referencia_control35[]"] option:checked')?.value || "";
        const marcaFuente = document.querySelector('select[name="marca_fuente[]"] option:checked')?.value || "";
        const modeloFuente35 = document.querySelector('select[name="modelo_fuente35[]"] option:checked')?.value || "";
        const justificacion = document.querySelector('textarea[name="justificacion[]"]').value || "";

        // Agregar una nueva fila a la tabla
        const tableBody = document.getElementById("table_body");
        const newRow = document.createElement("tr");
        newRow.innerHTML = generarFilaHTML(producto, pitch, serieModulo, campoReferencia, campoSerie, marcaControl, referenciaControl35, marcaFuente, modeloFuente35, cantidadEntradaMd, justificacion);
        tableBody.appendChild(newRow);

        actualizarNumeracion(); // Actualiza los números de las filas
    }

    function generarFilaHTML(producto, pitch, serieModulo, campoReferencia, campoSerie, marcaControl, referenciaControl35, marcaFuente, modeloFuente35, cantidadEntradaMd, justificacion) {
        return `
            <td></td> <!-- Se ajustará el número automáticamente -->
            <td>${producto}</td>
            <td>${pitch}</td>
            <td>${campoSerie}</td>
            <td>${campoReferencia}</td>
            <td>${marcaControl}</td>
            <td>${referenciaControl35}</td>
            <td>${marcaFuente}</td>
            <td>${modeloFuente35}</td>
            <td>${justificacion}</td>
            <td>${cantidadEntradaMd}</td>
            <td>
                <center>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>
                </center>
            </td>
        `;
    }

    function limpiarCampos() {
        document.querySelector('input[name="entrada_md[]"]').value = '';
        document.querySelector('select[name="producto[]"]').selectedIndex = 0;
        document.querySelector('select[name="serie_modulo[]"]').selectedIndex = 0;
        document.querySelector('select[name="pitch[]"]').selectedIndex = 0;
        document.querySelector('input[name="id_serie_modulo[]"]').value = '';
        document.querySelector('input[name="campo_referencia[]"]').value = '';
        document.querySelector('input[name="campo_serie[]"]').value = '';
        document.querySelector('select[name="marca_control[]"]').selectedIndex = 0;
        document.querySelector('select[name="referencia_control35[]"]').selectedIndex = 0;
        document.querySelector('select[name="marca_fuente[]"]').selectedIndex = 0;
        document.querySelector('select[name="modelo_fuente35[]"]').selectedIndex = 0;
        document.querySelector('textarea[name="justificacion[]"]').value = '';
    }

    function actualizarNumeracion() {
        document.querySelectorAll("#table_body tr").forEach((row, index) => {
            row.cells[0].textContent = index + 1; // Ajusta el número de cada fila
        });
    }

    // Función para eliminar la fila
    window.eliminarFila = function (btn) {
        btn.closest("tr").remove();
        actualizarNumeracion();
    };

    // **Código para guardar los datos de la tabla en el campo oculto antes de enviar el formulario**
    document.getElementById('formulario_creacion_producto').addEventListener('submit', function() {
        const rows = document.querySelectorAll('#table_body tr');
        const itemData = [];

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowData = {
                item: cells[0].innerText,
                producto: cells[1].innerText,
                pitch: cells[2].innerText,
                id_serie_modulo: cells[3].innerText,  // 👈 Asegúrate de que la columna correcta lo almacene
                campo_referencia: cells[4].innerText,
                marca_control: cells[5].innerText,
                referencia_control35: cells[6].innerText,
                marca_fuente: cells[7].innerText,
                modelo_fuente35: cells[8].innerText,
                justificacion: cells[9].innerText,
                cantidad_entrada_md: cells[10].innerText
            };
            itemData.push(rowData);
        });

        document.getElementById('item_data').value = JSON.stringify(itemData);
    });
});

    </script>

    <!--Función para limpiar los campos de los items -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tableBody = document.getElementById('table_body');
            var addButton = document.getElementById('add_item');
            var inputs = tableBody.querySelectorAll('input, select');
            var selects = tableBody.querySelectorAll('select');
            var textareas = tableBody.querySelectorAll('textarea');
            var itemNumber = 1;
            var addItemButton = document.getElementById('add_item');
            var itemNumber = 1;
            var clearButton = document.getElementById('clear_items');
            
            clearButton.addEventListener('click', function() {
                // Limpiar los campos de los items
                inputs.forEach(function(input) {
                    input.value = '';
                });
                selects.forEach(function(select) {
                    select.value = '';
                });
                textareas.forEach(function(textarea) {
                    textarea.value = '';
                });
                itemNumber = 1;
            });
            
            addItemButton.addEventListener('click', function() {
                itemNumber++;
            });
        });
    </script>