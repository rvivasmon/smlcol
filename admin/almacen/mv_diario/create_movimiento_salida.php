<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Movimientos de Envío</h1>
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
                                    <select name="producto2" id="producto2" class="form-control" required>
                                        <option value="">Seleccione un Producto</option>
                                        <?php 
                                        $query_producto = $pdo->prepare('SELECT id_producto, tipo_producto FROM productos ORDER BY tipo_producto ASC');
                                        $query_producto->execute();
                                        $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($productos as $producto) {
                                            echo '<option value="' . $producto['id_producto'] . '">' . $producto['tipo_producto'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <input class="form-control" name="id_producto_seleccionado" id="id_producto_seleccionado" hidden>
                                </div>
                            </div>
                            <div class="col-md-0">
                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                    <label for=""></label>
                                    <input class="form-control" id="idusuario2" name="idusuario2" value="<?php echo $sesion_usuario['nombre']?>" hidden>                                            
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 campos Modulo2">
                                            <div class="form-group">
                                                <label for="pitch">Pitch</label>
                                                <select name="pitch2" id="pitch2" class="form-control">
                                                    <option value="">Seleccione un Pitch</option>
                                                    <?php 
                                                    $query_pitch = $pdo->prepare('SELECT alma_principal.id_almacen_principal, caracteristicas_modulos.pitch FROM alma_principal INNER JOIN caracteristicas_modulos ON alma_principal.pitch = caracteristicas_modulos.id_car_mod ORDER BY caracteristicas_modulos.pitch ASC');
                                                    $query_pitch->execute();
                                                    $pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);
                                                    
                                                    // Filtrar pitches únicos
                                                    $pitches_unicos = [];
                                                    $pitches_unicos_keys = [];

                                                    foreach($pitches as $pitch) {
                                                        if (!in_array($pitch['pitch'], $pitches_unicos)) {
                                                            $pitches_unicos[] = $pitch['pitch'];
                                                            $pitches_unicos_keys[] = $pitch;
                                                        }
                                                    }

                                                    // Generar opciones únicas
                                                    foreach($pitches_unicos_keys as $pitch_unico) {
                                                        echo '<option value="' . $pitch_unico['id_almacen_principal'] . '">' . $pitch_unico['pitch'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 campos Modulo2">
                                            <div class="form-group">
                                                <label for="modelo_modulo1">Modelo</label>
                                                <select name="modelo_modulo2" id="modelo_modulo2" class="form-control">
                                                    <option value="">Seleccione un Modelo</option>
                                                    <?php 
                                                    $query_modelo = $pdo->prepare('SELECT alma_principal.id_almacen_principal, caracteristicas_modulos.modelo_modulo FROM alma_principal INNER JOIN caracteristicas_modulos ON alma_principal.modelo_modulo = caracteristicas_modulos.id_car_mod ORDER BY caracteristicas_modulos.modelo_modulo ASC');
                                                    $query_modelo->execute();
                                                    $modelos = $query_modelo->fetchAll(PDO::FETCH_ASSOC);

                                                    // Filtrar modelos únicos
                                                    $modelos_unicos = [];
                                                    $modelos_unicos_keys = [];

                                                    foreach($modelos as $modelo) {
                                                        if (!in_array($modelo['modelo_modulo'], $modelos_unicos)) {
                                                            $modelos_unicos[] = $modelo['modelo_modulo'];
                                                            $modelos_unicos_keys[] = $modelo;
                                                        }
                                                    }

                                                    // Generar opciones únicas
                                                    foreach($modelos_unicos_keys as $modelo_unico) {
                                                        echo '<option value="' . $modelo_unico['id_almacen_principal'] . '">' . $modelo_unico['modelo_modulo'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 campos Modulo2">
                                            <div class="form-group">
                                                <label for="serie_modulo">Serie</label>
                                                <select name="serie_modulo2" id="serie_modulo2" class="form-control">
                                                    <option value="">Seleccione la Serie</option>
                                                    <?php
                                                        $query_serie = $pdo->prepare('SELECT * FROM alma_principal WHERE serie_modulo IS NOT NULL AND serie_modulo != ""');
                                                        $query_serie->execute();
                                                        $series = $query_serie->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($series as $serie) {
                                                            $id_almacen_principal = $serie['id_almacen_principal'];
                                                            $serie_modulo = $serie['serie_modulo'];
                                                    ?>
                                                            <option value="<?php echo $id_almacen_principal; ?>"><?php echo $serie_modulo; ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 campos Modulo2">
                                            <div class="form-group">
                                                <label for="referencia_modulo">Referencia</label>
                                                <input type="text" name="referencia_modulo2" class="form-control" placeholder="Referencia">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 campos Control2">
                                            <div class="form-group">
                                                <label for="marca_control1">Marca</label>
                                                <select name="marca_control2" id="marca_control2" class="form-control">
                                                    <option value="">Seleccione una Marca</option>
                                                    <?php 
                                                    $query_marca_control = $pdo->prepare('SELECT alma_principal.id_almacen_principal, caracteristicas_control.marca_control FROM alma_principal INNER JOIN caracteristicas_control ON alma_principal.marca_control = caracteristicas_control.id_car_ctrl ORDER BY caracteristicas_control.marca_control ASC');
                                                    $query_marca_control->execute();
                                                    $marca_controles = $query_marca_control->fetchAll(PDO::FETCH_ASSOC);
                                                    
                                                    // Filtrar marcas únicas
                                                    $marcas_unicas = [];
                                                    $marcas_unicas_keys = [];

                                                    foreach($marca_controles as $marca_control) {
                                                        if (!in_array($marca_control['marca_control'], $marcas_unicas)) {
                                                            $marcas_unicas[] = $marca_control['marca_control'];
                                                            $marcas_unicas_keys[] = $marca_control;
                                                        }
                                                    }

                                                    // Generar opciones únicas
                                                    foreach($marcas_unicas_keys as $marca_unica) {
                                                        echo '<option value="' . $marca_unica['id_almacen_principal'] . '">' . $marca_unica['marca_control'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 campos Control2">
                                            <div class="form-group">
                                                <label for="serie_control">Referencia</label>
                                                <select name="serie_control2" id="serie_control2" class="form-control">
                                                    <option value="">Seleccione la Referencia</option>
                                                    <?php
                                                        $query_control1 = $pdo->prepare('SELECT * FROM alma_principal WHERE serie_control IS NOT NULL AND serie_control != ""');
                                                        $query_control1->execute();
                                                        $controles = $query_control1->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($controles as $control1) {
                                                            $id_almacen_principal_control = $control1['id_almacen_principal'];
                                                            $serie_control1 = $control1['serie_control'];
                                                    ?>
                                                            <option value="<?php echo $id_almacen_principal_control; ?>"><?php echo $serie_control1; ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 campos Control2">
                                            <div class="form-group">
                                                <label for="funcion_control">Función</label>
                                                <select name="funcion_control2" id="funcion_control2" class="form-control">
                                                    <option value="">Seleccione una Función</option>
                                                    <?php 
                                                    $query_funcion_control = $pdo->prepare('SELECT alma_principal.id_almacen_principal, caracteristicas_control.funcion_control FROM alma_principal INNER JOIN caracteristicas_control ON alma_principal.funcion_control = caracteristicas_control.id_car_ctrl ORDER BY caracteristicas_control.funcion_control ASC');
                                                    $query_funcion_control->execute();
                                                    $funcion_controles = $query_funcion_control->fetchAll(PDO::FETCH_ASSOC);

                                                    // Filtrar funciones únicas
                                                    $funciones_unicas = [];
                                                    $funciones_unicas_keys = [];

                                                    foreach($funcion_controles as $funcion_control) {
                                                        if (!in_array($funcion_control['funcion_control'], $funciones_unicas)) {
                                                            $funciones_unicas[] = $funcion_control['funcion_control'];
                                                            $funciones_unicas_keys[] = $funcion_control;
                                                        }
                                                    }

                                                    // Generar opciones únicas
                                                    foreach($funciones_unicas_keys as $funcion_unica) {
                                                        echo '<option value="' . $funcion_unica['id_almacen_principal'] . '">' . $funcion_unica['funcion_control'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 campos Fuente2">
                                            <div class="form-group">
                                                <label for="marca_fuente">Marca</label>
                                                <select name="marca_fuente2" id="marca_fuente2" class="form-control">
                                                    <option value="">Seleccione una Marca</option>
                                                    <?php 
                                                    $query_marca_fuente = $pdo->prepare('SELECT alma_principal.id_almacen_principal, caracteristicas_fuentes.marca_fuente FROM alma_principal INNER JOIN caracteristicas_fuentes ON alma_principal.marca_fuente = caracteristicas_fuentes.id_car_fuen ORDER BY caracteristicas_fuentes.marca_fuente ASC');
                                                    $query_marca_fuente->execute();
                                                    $marca_fuentes = $query_marca_fuente->fetchAll(PDO::FETCH_ASSOC);
                                                    
                                                    // Filtrar marcas únicas
                                                    $marcas_fuente_unicas = [];
                                                    $marcas_fuente_unicas_keys = [];

                                                    foreach($marca_fuentes as $marca_fuente) {
                                                        if (!in_array($marca_fuente['marca_fuente'], $marcas_fuente_unicas)) {
                                                            $marcas_fuente_unicas[] = $marca_fuente['marca_fuente'];
                                                            $marcas_fuente_unicas_keys[] = $marca_fuente;
                                                        }
                                                    }

                                                    // Generar opciones únicas
                                                    foreach($marcas_fuente_unicas_keys as $marca_fuente_unica) {
                                                        echo '<option value="' . $marca_fuente_unica['id_almacen_principal'] . '">' . $marca_fuente_unica['marca_fuente'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 campos Fuente2">
                                            <div class="form-group">
                                                <label for="modelo_fuente">Modelo</label>
                                                <select name="modelo_fuente2" id="modelo_fuente2" class="form-control">
                                                    <option value="">Seleccione el Modelo</option>
                                                    <?php
                                                        $query_modelfuente = $pdo->prepare('SELECT * FROM alma_principal WHERE modelo_fuente IS NOT NULL AND modelo_fuente != ""');
                                                        $query_modelfuente->execute();
                                                        $modelosfuentes = $query_modelfuente->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($modelosfuentes as $modelfuente) {
                                                            $id_principal_modelfuente = $modelfuente['id_almacen_principal'];
                                                            $serie_modelfuente = $modelfuente['modelo_fuente'];
                                                    ?>
                                                            <option value="<?php echo $id_principal_modelfuente; ?>"><?php echo $serie_modelfuente; ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 campos Fuente2">
                                            <div class="form-group">
                                                <label for="tipo_fuente">Tipo</label>
                                                <select name="tipo_fuente2" id="tipo_fuente2" class="form-control">
                                                    <option value="">Seleccione un Tipo</option>
                                                    <?php 
                                                    $query_tipo_fuente  = $pdo->prepare('SELECT alma_principal.id_almacen_principal, caracteristicas_fuentes.tipo_fuente FROM alma_principal INNER JOIN caracteristicas_fuentes ON alma_principal.tipo_fuente = caracteristicas_fuentes.id_car_fuen ORDER BY caracteristicas_fuentes.tipo_fuente ASC');
                                                    $query_tipo_fuente->execute();
                                                    $tipo_fuentes = $query_tipo_fuente->fetchAll(PDO::FETCH_ASSOC);
                                                    
                                                    // Filtrar tipos únicos
                                                    $tipos_fuente_unicos = [];
                                                    $tipos_fuente_unicos_keys = [];

                                                    foreach($tipo_fuentes as $tipo_fuente) {
                                                        if (!in_array($tipo_fuente['tipo_fuente'], $tipos_fuente_unicos)) {
                                                            $tipos_fuente_unicos[] = $tipo_fuente['tipo_fuente'];
                                                            $tipos_fuente_unicos_keys[] = $tipo_fuente;
                                                        }
                                                    }

                                                    // Generar opciones únicas
                                                    foreach($tipos_fuente_unicos_keys as $tipo_fuente_unico) {
                                                        echo '<option value="' . $tipo_fuente_unico['id_almacen_principal'] . '">' . $tipo_fuente_unico['tipo_fuente'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="entrada_md">Almacén Destino</label>
                                                <select name="almacen_entrada_md" id="almacen_entrada_md" class="form-control" required>
                                                    <option value="">Almacén Destino</option>
                                                    <?php
                                                    $query_almacen_entra = $pdo->prepare('SELECT * FROM asignar_todos_almacenes');
                                                    $query_almacen_entra->execute();
                                                    $almacenes_entras = $query_almacen_entra->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($almacenes_entras as $almacen_entra) {
                                                        $id_almacen = $almacen_entra['id_asignacion'];
                                                        $almacenentra = $almacen_entra['nombre_almacen'];
                                                    ?>
                                                    <option value="<?php echo $id_almacen; ?>"><?php echo $almacenentra; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <input class="form-control" name="almacen_entrada_md_id" id="almacen_entrada_md_id" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="entrada_md">Entrada</label>
                                                <input type="text" name="entrada_md" class="form-control" placeholder="Cantidad Entrada" required>
                                                <input type="hidden" name="pitch3" value="<?php echo $pitch_unico['pitch']; ?>">
                                                <input type="hidden" name="marca_control3" value="<?php echo $marca_unica['marca_control']; ?>">
                                                <input type="hidden" name="marca_fuente3" value="<?php echo $marca_fuente_unica['marca_fuente']; ?>">
                                                <input type="hidden" name="serie_modulo3" value="<?php echo $serie['serie_modulo']; ?>">
                                                <input type="hidden" name="serie_control3" value="<?php echo $control1['serie_control']; ?>">
                                                <input type="hidden" name="modelo_fuente3" value="<?php echo $modelfuente['modelo_fuente']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7" hidden>
                                            <div class="form-group">
                                                <label for="salida_md">Almacén Salida</label>
                                                <select name="almacen_salida_md" id="almacen_salida_md" class="form-control" >
                                                    <option value="">Almacén Origen</option>
                                                    <?php 
                                                    $query_almacen  = $pdo->prepare('SELECT * FROM asignar_todos_almacenes');
                                                    $query_almacen->execute();
                                                    $almacenes = $query_almacen->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($almacenes as $almacen) {
                                                        $selected = ($almacen['id_asignacion'] == 3) ? 'selected' : '';
                                                        echo '<option value="' . $almacen['id_asignacion'] . '" ' . $selected . '>' . $almacen['nombre_almacen'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input class="form-control" name="almacen_salida_md_id" id="almacen_salida_md_id" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-3" hidden>
                                            <div class="form-group">
                                                <label for="salida_md">Salida</label>
                                                <input type="text" name="salida_md" class="form-control" placeholder="Cantidad Salida">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
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

<script>

document.addEventListener('DOMContentLoaded', function() {
    // Ocultar campos inicialmente
    const camposModulo = document.querySelectorAll('.campos.Modulo2');
    const camposControl = document.querySelectorAll('.campos.Control2');
    const camposFuente = document.querySelectorAll('.campos.Fuente2');

    // Inicialmente ocultar todos los campos
    camposModulo.forEach(campo => campo.style.display = 'none');
    camposControl.forEach(campo => campo.style.display = 'none');
    camposFuente.forEach(campo => campo.style.display = 'none');

    // Mostrar/ocultar campos según la categoría seleccionada
    const selectProducto = document.getElementById('producto2');
    selectProducto.addEventListener('change', function() {
        const categoriaSeleccionada = this.options[this.selectedIndex].text;

        // Ocultar todos los campos
        camposModulo.forEach(campo => campo.style.display = 'none');
        camposControl.forEach(campo => campo.style.display = 'none');
        camposFuente.forEach(campo => campo.style.display = 'none');

        // Mostrar los campos correspondientes según la categoría seleccionada
        if (categoriaSeleccionada.includes('Control')) {
            camposControl.forEach(campo => campo.style.display = 'block');
        } else if (categoriaSeleccionada.includes('Módulo')) {
            camposModulo.forEach(campo => campo.style.display = 'block');
        } else if (categoriaSeleccionada.includes('Fuente')) {
            camposFuente.forEach(campo => campo.style.display = 'block');
        }
    });

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
});

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

// visualizar el campo categoria
document.addEventListener('DOMContentLoaded', function() {
        // Función para actualizar el valor del campo del ID del producto seleccionado
        function actualizarIdProductoSeleccionado() {
            const selectProducto = document.getElementById('producto2');
            const idProductoSeleccionado = selectProducto.value; // Obtener el valor del option seleccionado
            document.getElementById('id_producto_seleccionado').value = idProductoSeleccionado;
        }

        // Evento para actualizar el ID del producto seleccionado cuando cambia el producto
        const selectProducto = document.getElementById('producto2');
        selectProducto.addEventListener('change', actualizarIdProductoSeleccionado);

        // Llama a la función inicialmente para establecer el valor correcto
        actualizarIdProductoSeleccionado();
    });

    document.addEventListener('DOMContentLoaded', function() {
    const selectProducto = document.getElementById('producto2');
    const pitchInput = document.getElementsByName('pitch3')[0];
    const marcaControlInput = document.getElementsByName('marca_control3')[0];
    const marcaFuenteInput = document.getElementsByName('marca_fuente3')[0];
    const serieModuloInput = document.getElementsByName('serie_modulo3')[0];
    const serieControlInput = document.getElementsByName('serie_control3')[0];
    const modeloFuenteInput = document.getElementsByName('modelo_fuente3')[0];

    // Función para actualizar los campos de acuerdo al producto seleccionado
    function actualizarCamposProducto() {
        // Obtener el valor seleccionado del producto
        const productoSeleccionado = selectProducto.options[selectProducto.selectedIndex].text;

        // Actualizar los valores de los campos según el producto seleccionado
        if (productoSeleccionado.includes('Módulo')) {
            pitchInput.value = document.getElementById('pitch2').options[document.getElementById('pitch2').selectedIndex].text;
            serieModuloInput.value = document.getElementById('serie_modulo2').options[document.getElementById('serie_modulo2').selectedIndex].text;
            marcaControlInput.value = '';
            marcaFuenteInput.value = '';
            serieControlInput.value = '';
            modeloFuenteInput.value = '';
        } else if (productoSeleccionado.includes('Control')) {
            pitchInput.value = '';
            serieModuloInput.value = '';
            marcaControlInput.value = document.getElementById('marca_control2').options[document.getElementById('marca_control2').selectedIndex].text;
            serieControlInput.value = document.getElementById('serie_control2').options[document.getElementById('serie_control2').selectedIndex].text;
            marcaFuenteInput.value = '';
            modeloFuenteInput.value = '';
        } else if (productoSeleccionado.includes('Fuente')) {
            pitchInput.value = '';
            serieModuloInput.value = '';
            marcaControlInput.value = '';
            serieControlInput.value = '';
            marcaFuenteInput.value = document.getElementById('marca_fuente2').options[document.getElementById('marca_fuente2').selectedIndex].text;
            modeloFuenteInput.value = document.getElementById('modelo_fuente2').options[document.getElementById('modelo_fuente2').selectedIndex].text;
        } else {
            // Si no se selecciona ningún producto, establecer todos los campos en blanco
            pitchInput.value = '';
            serieModuloInput.value = '';
            marcaControlInput.value = '';
            serieControlInput.value = '';
            marcaFuenteInput.value = '';
            modeloFuenteInput.value = '';
        }
    }

    // Escuchar cambios en el select de producto y actualizar los campos
    selectProducto.addEventListener('change', actualizarCamposProducto);

    // Escuchar cambios en el select de pitch y actualizar el campo correspondiente
    const selectPitch = document.getElementById('pitch2');
    selectPitch.addEventListener('change', function() {
        pitchInput.value = selectPitch.options[selectPitch.selectedIndex].text;
    });

    // Escuchar cambios en el select de marca de control y actualizar el campo correspondiente
    const selectMarcaControl = document.getElementById('marca_control2');
    selectMarcaControl.addEventListener('change', function() {
        marcaControlInput.value = selectMarcaControl.options[selectMarcaControl.selectedIndex].text;
    });

    // Escuchar cambios en el select de marca de fuente y actualizar el campo correspondiente
    const selectMarcaFuente = document.getElementById('marca_fuente2');
    selectMarcaFuente.addEventListener('change', function() {
        marcaFuenteInput.value = selectMarcaFuente.options[selectMarcaFuente.selectedIndex].text;
    });

    // Escuchar cambios en el select de marca de fuente y actualizar el campo correspondiente
    const selectSerieModulo = document.getElementById('serie_modulo2');
    selectSerieModulo.addEventListener('change', function() {
        serieModuloInput.value = selectSerieModulo.options[selectSerieModulo.selectedIndex].text;
    });

    // Escuchar cambios en el select de marca de fuente y actualizar el campo correspondiente
    const selectSerieControl = document.getElementById('serie_control2');
    selectSerieControl.addEventListener('change', function() {
        serieControlInput.value = selectSerieControl.options[selectSerieControl.selectedIndex].text;
    });

    // Escuchar cambios en el select de marca de fuente y actualizar el campo correspondiente
    const selectModeloFuente = document.getElementById('modelo_fuente2');
    selectModeloFuente.addEventListener('change', function() {
        modeloFuenteInput.value = selectModeloFuente.options[selectModeloFuente.selectedIndex].text;
    });

    // Llamar a la función inicialmente para establecer los valores correctos
    actualizarCamposProducto();
});


document.addEventListener('DOMContentLoaded', function() {
    // Tu código existente...

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
        const entradaMdInput = document.getElementsByName('entrada_md')[0];
        const salidaMdInput = document.getElementsByName('salida_md')[0];

        // Función para actualizar el campo de salida_md
        function actualizarSalidaMd() {
            salidaMdInput.value = entradaMdInput.value; // Establecer el mismo valor que entrada_md
        }

        // Escuchar cambios en el campo entrada_md y llamar a la función actualizarSalidaMd
        entradaMdInput.addEventListener('input', actualizarSalidaMd);
    });


</script>

<?php include('../../../layout/admin/parte2.php');?>

