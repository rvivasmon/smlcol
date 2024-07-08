<?php 

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

include('../../layout/admin/parte1.php');

// Obtener el año y el mes actuales en formato YYYYMM
$anio_mes = date('Ym');

// Inicializar el contador
$contador_ppc = 1;

// Obtener el último registro de la base de datos ordenado por año_mes de forma descendente
$query_ultimo_registro = $pdo->prepare('SELECT * FROM ppc ORDER BY anio_mes_ppc DESC, contador_ppc DESC LIMIT 1');
$query_ultimo_registro->execute();
$ultimo_registro_ppc = $query_ultimo_registro->fetch(PDO::FETCH_ASSOC);

// Verificar si hay un último registro
if($ultimo_registro_ppc) {
    // Obtener el año y mes del último registro en formato YYYYMM
    $ultimo_anio_mes = date('Ym', strtotime($ultimo_registro_ppc['fecha']));

    // Si el mes y año del último registro son iguales al mes y año actuales, continuar con el contador
    if ($ultimo_anio_mes == $anio_mes) {
        $contador_ppc = $ultimo_registro_ppc['contador_ppc'] + 1;
    }
}

// Crear el ID PPC utilizando el año_mes y el contador
$id_ppc =  $anio_mes . '-' . sprintf('%03d', $contador_ppc);

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Creación Pre Proyecto</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create.php" method="POST">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fecha">Fecha</label>
                                                <input type="date" id="fecha" name="fecha" class="form-control" placeholder="Fecha" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="hora">Hora</label>
                                                <input type="time" id="hora" name="hora" class="form-control" placeholder="Hora" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tipo_proyecto">Tipo Proyecto</label>
                                                <select name="tipo_proyecto" id="tipo_proyecto" class="form-control" required>
                                                    <option value="">Seleccione tipo</option>
                                                    <option value="PPC">PPC</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_proyecto">Id Proyecto</label>
                                                <input type="text" name="id_proyecto" class="form-control" placeholder="Asignar" value="<?php echo $id_ppc; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-0">
                                            <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                                <label for=""></label>
                                                <input class="form-control" id="idusuario2" name="idusuario2" value="<?php echo $sesion_usuario['id']?>" hidden>                                            
                                            </div>
                                        </div>
                                        <div class="col-md-0">
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input type="hidden" name="anio_mes" value="<?php echo $anio_mes; ?>">
                                                <input type="hidden" name="contador" value="<?php echo $contador_ppc; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 campos Modulo2">
                                            <div class="form-group">
                                                <label for="nombre_proyecto">Proyecto</label>
                                                <input type="text" name="nombre_proyecto" class="form-control" placeholder="Asignar" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 campos Modulo2">
                                            <div class="form-group">
                                                <label for="posi_cliente">Cliente</label>
                                                <input type="text" name="posi_cliente" class="form-control" placeholder="Asignar" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 campos Modulo2">
                                            <div class="form-group">
                                                <label for="contacto_cliente">Contacto</label>
                                                <input type="text" name="contacto_cliente" class="form-control" placeholder="Asignar" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 campos Modulo2">
                                            <div class="form-group">
                                                <label for="telefono_contacto">Teléfono Contacto</label>
                                                <input type="text" name="telefono_contacto" class="form-control" placeholder="Referencia">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 campos Control2">
                                            <div class="form-group">
                                                <label for="asesor_encargado">Asesor Encargado</label>
                                                <input type="text" name="asesor_encargado" class="form-control" value="<?php echo $sesion_usuario['nombre']?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 campos Control2">
                                            <div class="form-group">
                                                <label for="buscador">Busqueda por PPC</label>
                                                <select name="buscador_ppc" id="buscador_ppc" class="form-control">
                                                                
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>

                            <div class="col-md-7" style="border: 0.10px solid #808080; padding: 15px;">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 campos Fuente2">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <select name="estado" id="estado" class="form-control">
                                                <option value="">Seleccione un Estado</option>
                                                    <?php 
                                                    $query_estado = $pdo->prepare('SELECT * FROM estado WHERE estado_ppc IS NOT NULL AND estado_ppc != "" ORDER BY estado_ppc ASC');
                                                    $query_estado->execute();
                                                    $estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);
                                                    
                                                    // Filtrar pitches únicos
                                                    $estados_unicos = [];
                                                    $estados_unicos_keys = [];

                                                    foreach($estados as $estado) {
                                                        if (!in_array($estado['estado_ppc'], $estados_unicos)) {
                                                            $estados_unicos[] = $estado['estado_ppc'];
                                                            $estados_unicos_keys[] = $estado;
                                                        }
                                                    }

                                                    // Generar opciones únicas
                                                    foreach($estados_unicos_keys as $estado_unico) {
                                                        $selected = $estado_unico['id'] == 1 ? 'selected' : '';
                                                        echo '<option value="' . $estado_unico['id'] . '" ' . $selected . '>' . $estado_unico['estado_ppc'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 campos Fuente2">
                                            <div class="form-group">
                                                <label for="cate_prod">Categoría Producto</label>
                                                <select name="cate_prod" id="cate_prod" class="form-control">
                                                    <option value="">Seleccione una Categoría</option>
                                                    <?php 
                                                    $query_producto = $pdo->prepare('SELECT * FROM productos_terminados WHERE categoria IS NOT NULL AND categoria != "" ORDER BY categoria ASC');
                                                    $query_producto->execute();
                                                    $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);
                                                    
                                                    // Filtrar pitches únicos
                                                    $productos_unicos = [];
                                                    $productos_unicos_keys = [];

                                                    foreach($productos as $producto) {
                                                        if (!in_array($producto['categoria'], $productos_unicos)) {
                                                            $productos_unicos[] = $producto['categoria'];
                                                            $productos_unicos_keys[] = $producto;
                                                        }
                                                    }

                                                    // Generar opciones únicas
                                                    foreach($productos_unicos_keys as $producto_unico) {
                                                        echo '<option value="' . $producto_unico['id_prod_terminado '] . '">' . $producto_unico['categoria'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="uso">Uso</label>
                                                <select name="uso" id="uso" class="form-control">
                                                    <option value="">Uso</option>
                                                    <?php 
                                                    $query_leds = $pdo->prepare('SELECT * FROM productos_terminados WHERE uso_leds IS NOT NULL AND uso_leds != "" ORDER BY uso_leds ASC');
                                                    $query_leds->execute();
                                                    $ledses = $query_leds->fetchAll(PDO::FETCH_ASSOC);
                                                    
                                                    // Filtrar pitches únicos
                                                    $ledses_unicos = [];
                                                    $ledses_unicos_keys = [];

                                                    foreach($ledses as $leds) {
                                                        if (!in_array($leds['uso_leds'], $ledses_unicos)) {
                                                            $ledses_unicos[] = $leds['uso_leds'];
                                                            $ledses_unicos_keys[] = $leds;
                                                        }
                                                    }

                                                    // Generar opciones únicas
                                                    foreach($ledses_unicos_keys as $leds_unico) {
                                                        echo '<option value="' . $leds_unico['id_prod_terminado '] . '">' . $leds_unico['uso_leds'] . '</option>';
                                                    }
                                                    ?>                
                                                </select>
                                                <input class="form-control" name="uso" id="uso" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tipo_producto">Tipo Producto</label>
                                                <select name="tipo_producto" id="tipo_producto" class="form-control">
                                                    <option value="">Tipo de Producto</option>
                                                    <?php 
                                                    $query_leds = $pdo->prepare('SELECT * FROM productos_terminados WHERE tipo_producto IS NOT NULL AND tipo_producto != "" ORDER BY tipo_producto ASC');
                                                    $query_leds->execute();
                                                    $ledses = $query_leds->fetchAll(PDO::FETCH_ASSOC);
                                                    
                                                    // Filtrar pitches únicos
                                                    $ledses_unicos = [];
                                                    $ledses_unicos_keys = [];

                                                    foreach($ledses as $leds) {
                                                        if (!in_array($leds['tipo_producto'], $ledses_unicos)) {
                                                            $ledses_unicos[] = $leds['tipo_producto'];
                                                            $ledses_unicos_keys[] = $leds;
                                                        }
                                                    }

                                                    // Generar opciones únicas
                                                    foreach($ledses_unicos_keys as $leds_unico) {
                                                        echo '<option value="' . $leds_unico['id_prod_terminado '] . '">' . $leds_unico['tipo_producto'] . '</option>';
                                                    }
                                                    ?>                
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="pitch">Pitch</label>
                                                <select name="pitch" id="pitch" class="form-control">
                                                    <option value="">Tipo de Pitch</option>
                                                    <?php 
                                                    $query_leds = $pdo->prepare('SELECT * FROM caracteristicas_modulos WHERE pitch IS NOT NULL AND pitch != "" ORDER BY pitch ASC');
                                                    $query_leds->execute();
                                                    $ledses = $query_leds->fetchAll(PDO::FETCH_ASSOC);
                                                    
                                                    // Filtrar pitches únicos
                                                    $ledses_unicos = [];
                                                    $ledses_unicos_keys = [];

                                                    foreach($ledses as $leds) {
                                                        if (!in_array($leds['pitch'], $ledses_unicos)) {
                                                            $ledses_unicos[] = $leds['pitch'];
                                                            $ledses_unicos_keys[] = $leds;
                                                        }
                                                    }

                                                    // Generar opciones únicas
                                                    foreach($ledses_unicos_keys as $leds_unico) {
                                                        echo '<option value="' . $leds_unico['id_car_mod '] . '">' . $leds_unico['pitch'] . '</option>';
                                                    }
                                                    ?>                
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="entrada_md">X disponible en mm.</label>
                                                <input type="text" class="form-control" name="almacen_entrada_md_id" id="almacen_entrada_md_id" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="entrada_md">Y disponible en mm.</label>
                                                <input type="text" class="form-control" name="almacen_entrada_md_id" id="almacen_entrada_md_id" >
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-3 campos Fuente2">
                                            <div class="form-group">
                                                <label for="contador">Contador</label>
                                                <input type="text" name="contador" class="form-control" placeholder="Contador">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campos Fuente2">
                                            <div class="form-group">
                                                <label for="cantidad">Cantidad</label>
                                                <input type="text" name="cantidad" class="form-control" placeholder="Cantidad">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-success btn-block" onclick="duplicarFormulario()">+</button>
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
                                    <a href="<?php echo $URL."admin/crm";?>" class="btn btn-default btn-block">Cancelar</a>
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

    // Función para duplicar el formulario
    function duplicarFormulario() {
        // Obtener el formulario original
        var formularioOriginal = document.querySelector('.card-body form');
        // Clonar el formulario
        var formularioClonado = formularioOriginal.cloneNode(true);

        // Reiniciar los valores de los campos en el formulario clonado
        var inputs = formularioClonado.querySelectorAll('input, select');
        inputs.forEach(function(input) {
            if (input.type !== 'hidden') {
                input.value = '';
            }
        });

        // Agregar el formulario clonado al final del contenedor
        formularioOriginal.parentNode.appendChild(formularioClonado);
    }

</script>

<?php include('../../layout/admin/parte2.php');?>

