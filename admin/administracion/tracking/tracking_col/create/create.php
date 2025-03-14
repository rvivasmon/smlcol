<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

include('../../../../../layout/admin/parte1.php');

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
                        <h1 class="m-0">Solicitud Mercancia a China</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                        <div class="card card-blue w_auto">
                            <div class="card-header">
                                Introduzca la información correspondiente
                            </div>
                        
                            <div class="card-body">
                                <form action="procesar.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="fecha">Fecha</label>
                                                                <input type="date" id="fecha" name="fecha[]" class="form-control" readonly>
                                                                <input type="hidden" id="ano_mes" name="ano_mes" class="form-control" value="<?= date('Ym'); ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="solicitante">Solicitante</label>
                                                                <select name="solicitante" id="solicitante" class="form-control" required>
                                                                    <option value="">Seleccione un Solicitante</option>
                                                                        <?php
                                                                        $query_solicitante = $pdo->prepare('SELECT id, siglas FROM almacenes_grupo WHERE siglas IS NOT NULL AND siglas != "" AND habilitar = "1" ORDER BY siglas ASC');
                                                                        $query_solicitante->execute();
                                                                    $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($solicitantes as $solicitud) {
                                                                        echo '<option value="' . $solicitud['id'] . '">' . $solicitud['siglas'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="codigo_generado">Contador de Entrada</label>
                                                                <input type="text" id="codigo_generado" name="codigo_generado" class="form-control" required readonly>
                                                                <input type="hidden" id="contador" name="contador" class="form-control" value="<?php ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="fecha_oc">FECHA OC</label>
                                                                <input type="date" id="fecha_oc" name="fecha_oc" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="origen">OC</label>
                                                                <input type="text" id="origen" name="origen" class="form-control" placeholder="OC" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="origen">CLIENTE</label>
                                                                <select name="solicitante" id="solicitante" class="form-control" required>
                                                                    <option value="">Seleccione un Cliente</option>
                                                                        <?php
                                                                        $query_solicitante = $pdo->prepare('SELECT id, nombre_comercial FROM clientes WHERE nombre_comercial IS NOT NULL AND nombre_comercial != "" ORDER BY nombre_comercial ASC');
                                                                        $query_solicitante->execute();
                                                                    $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach($solicitantes as $solicitud) {
                                                                        echo '<option value="' . $solicitud['id'] . '">' . $solicitud['nombre_comercial'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group cloned-section">
                                                        <!-- PRODUCTO -->
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="producto1">Producto</label>
                                                                    <select name="producto1[]" id="producto1" class="form-control">
                                                                        <option value="">Seleccione una Categoría</option>
                                                                            <?php
                                                                            $query_solicitante = $pdo->prepare('SELECT id_producto, tipo_producto FROM t_productos WHERE tipo_producto IS NOT NULL AND tipo_producto != "" AND habilitar = "1" ORDER BY tipo_producto ASC');
                                                                            $query_solicitante->execute();
                                                                        $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach($solicitantes as $solicitud) {
                                                                            echo '<option value="' . $solicitud['id_producto'] . '">' . $solicitud['tipo_producto'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="cantidad">Cantidad</label>
                                                                    <input type="text" name="cantidad[]" id="cantidad" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="uso">USO</label>
                                                                    <select name="uso[]" id="uso" class="form-control">
                                                                        <option value="">Seleccione una Categoría</option>
                                                                            <?php
                                                                            $query_solicitante = $pdo->prepare('SELECT id_uso, producto_uso FROM t_uso_productos WHERE producto_uso IS NOT NULL AND producto_uso != "" AND categoria_productos = "1" ORDER BY producto_uso ASC');
                                                                            $query_solicitante->execute();
                                                                        $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach($solicitantes as $solicitud) {
                                                                            echo '<option value="' . $solicitud['id_uso'] . '">' . $solicitud['producto_uso'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="modelo">Categoría:</label>
                                                                    <select name="modelo[]" id="modelo" class="form-control">
                                                                        <option value="">Seleccione una Categoría</option>
                                                                            <?php
                                                                            $query_solicitante = $pdo->prepare('SELECT id, siglas FROM almacenes_grupo WHERE siglas IS NOT NULL AND siglas != "" AND habilitar = "1" ORDER BY siglas ASC');
                                                                            $query_solicitante->execute();
                                                                        $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach($solicitantes as $solicitud) {
                                                                            echo '<option value="' . $solicitud['id'] . '">' . $solicitud['siglas'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>                                                        
                                                            </div>
                                                            <div class="col-md-2 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="pitch">Pitch</label>
                                                                    <select name="pitch[]" id="pitch" class="form-control">
                                                                        <option value="">Seleccione una Categoría</option>
                                                                            <?php
                                                                            $query_solicitante = $pdo->prepare('SELECT id, siglas FROM almacenes_grupo WHERE siglas IS NOT NULL AND siglas != "" AND habilitar = "1" ORDER BY siglas ASC');
                                                                            $query_solicitante->execute();
                                                                        $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach($solicitantes as $solicitud) {
                                                                            echo '<option value="' . $solicitud['id'] . '">' . $solicitud['siglas'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- MODULOS -->
                                                        <div class="row">
                                                            <div class="col-md-3 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="modelo_nombre">Modelo / Nombre:</label>
                                                                    <select name="modelo_nombre[]" id="modelo_nombre" class="form-control">
                                                                        <option value="">Seleccione un Modelo</option>
                                                                            <?php
                                                                            $query_solicitante = $pdo->prepare('SELECT id, siglas FROM almacenes_grupo WHERE siglas IS NOT NULL AND siglas != "" AND habilitar = "1" ORDER BY siglas ASC');
                                                                            $query_solicitante->execute();
                                                                        $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach($solicitantes as $solicitud) {
                                                                            echo '<option value="' . $solicitud['id'] . '">' . $solicitud['siglas'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="smd_encapsulado">SMD Encapsulado:</label>
                                                                    <input type="text" name="smd_encapsulado[]" id="" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="x_mm">X mm:</label>
                                                                    <select name="x_mm[]" id="x_mm" class="form-control">
                                                                        <option value="">Seleccione un Tamaño</option>
                                                                            <?php
                                                                            $query_solicitante = $pdo->prepare("SELECT DISTINCT
                                                                                                                        tamano_x 
                                                                                                                    FROM
                                                                                                                        tabla_tamanos_modulos 
                                                                                                                    WHERE
                                                                                                                        tamano_x IS NOT NULL 
                                                                                                                    AND
                                                                                                                        tamano_x <> ''
                                                                                                                    AND
                                                                                                                        habilitar_tamano = '1' 
                                                                                                                    ORDER BY
                                                                                                                        tamano_x ASC;
                                                                                                                ");
                                                                            $query_solicitante->execute();
                                                                        $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach($solicitantes as $solicitud) {
                                                                            echo '<option value="' . $solicitud['id'] . '">' . $solicitud['tamano_x'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>                                                            
                                                            </div>
                                                            <div class="col-md-2 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="y_mm">Y mm:</label>
                                                                    <select name="y_mm[]" id="y_mm" class="form-control">
                                                                    <option value="">Seleccione un Tamaño</option>
                                                                            <?php
                                                                            $query_solicitante = $pdo->prepare("SELECT DISTINCT
                                                                                                                        tamano_y 
                                                                                                                    FROM
                                                                                                                        tabla_tamanos_modulos 
                                                                                                                    WHERE
                                                                                                                        tamano_y IS NOT NULL 
                                                                                                                    AND
                                                                                                                        tamano_y <> ''
                                                                                                                    AND
                                                                                                                        habilitar_tamano = '1' 
                                                                                                                    ORDER BY
                                                                                                                        tamano_y ASC;
                                                                                                                ");
                                                                            $query_solicitante->execute();
                                                                        $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                                                        foreach($solicitantes as $solicitud) {
                                                                            echo '<option value="' . $solicitud['id'] . '">' . $solicitud['tamano_y'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="resol_x">Resol. X::</label>
                                                                    <input type="text" name="resol_x[]" id="resol_x" class="form-control">
                                                                </div>                                                        
                                                            </div>
                                                            <div class="col-md-3 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="resol_y">Resol. Y:</label>
                                                                    <input type="text" name="resol_y[]" id="resol_y"  class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="pixel_modulo">Pixel Módulo:</label>
                                                                    <input type="text" name="pixel_modulo[]" id="pixel_modulo" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="interface_hub">Interface HUB:</label>
                                                                    <input type="text" name="interface_hub[]" id="interface_hub" class="form-control">
                                                                </div>                                                            
                                                            </div>
                                                            <div class="col-md-2 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="grupo_datos"># grupo de datos:</label>
                                                                    <input type="number" name="grupo_datos[]" id="grupo_datos" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="nits_brillo">Estand Prom Nits Brillo cd/m²:</label>
                                                                    <input type="number" name="nits_brillo[]" id="nits_brillo" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 campo Modulo">
                                                                <div class="form-group">
                                                                <label for="corriente_shinkong">Corriente Shin Kong (A):</label>
                                                                <input type="number" name="corriente_shinkong[]" step="0.01" id="corriente_shinkong" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 campo Modulo">
                                                                <div class="form-group">
                                                                <label for="corriente_kinglight">Corriente Kinglight (A):</label>
                                                                <input type="number" name="corriente_kinglight[]" step="0.01" id="corriente_kinglight" class="form-control">
                                                                </div>
                                                            </div>    
                                                            <div class="col-md-3 campo Modulo">
                                                                <div class="form-group">
                                                                <label for="corriente_nationstar">Corriente Nationstar (A):</label>
                                                                <input type="number" name="corriente_nationstar[]" step="0.01" id="corriente_nationstar" class="form-control">
                                                                </div>
                                                            </div>    

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="num_mod_5v40a">5V40A Máx módulos 70%:</label>
                                                                    <input type="number" name="num_mod_5v40a[]" id="num_mod_5v40a" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="num_mod_5v60a">5V60A Máx módulos 70%:</label>
                                                                    <input type="number" name="num_mod_5v60a[]" id="num_mod_5v60a" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="consumo_watts">Consumo Watts Módulos:</label>
                                                                    <input type="number" name="consumo_watts[]" id="consumo_watts" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="referencia_alimentacion">Referencia alimentación 5V:</label>
                                                                    <input type="text" name="referencia_alimentacion[]" id="referencia_alimentacion" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="referencia_cable">Referencia especificación de cable:</label>
                                                                    <input type="text" name="referencia_cable[]" id="referencia_cable" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 campo Modulo">
                                                                <div class="form-group">
                                                                    <label for="estandar_magnet">Estandar magnet Especificaciones:</label>
                                                                    <input type="text" name="estandar_magnet[]" id="estandar_magnet" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- CONTROLADORA -->
                                                        <div class="row">
                                                            <div class="col-md-6 campo Control">
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
                                                            <div class="col-md-6 campo Control">
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
                                                            <div class="col-md-6 campo Fuente">
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
                                                            <div class="col-md-6 campo Fuente">
                                                                    <div class="form-group">
                                                                        <label for="modelo_fuente35" class="d-block mb-0">Modelo</label>
                                                                        <select id="modelo_fuente35" name="modelo_fuente35[]" class="form-control">
                                                                            <option value=""></option>
                                                                        </select>
                                                                    </div>
                                                            </div>
                                                        </div>

                                                        <!-- OBSERVACIÓN -->
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="notas">Notas & Observaciones:</label>
                                                                    <textarea name="notas[]" id="notas" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <!-- BOTÓN -->
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
                                                                <th>Fecha</th>
                                                                <th>Producto</th>
                                                                <th>Marca o Categoría / Modelo o Pitch</th>
                                                                <th>Observaciones</th>
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

<?php include('../../../../../layout/admin/parte2.php');?>

    <script>
        // Obtener la fecha actual en el formato yyyy-mm-dd
        var today = new Date().toISOString().split('T')[0];
        // Establecer el valor del campo de fecha
        document.getElementById('fecha').value = today;

        document.addEventListener('DOMContentLoaded', function() {
            // Ocultar todos los campos al cargar la página
            var campos = document.querySelectorAll('.campo');
            campos.forEach(function(campo) {
                campo.style.display = 'none';
            });

            // Llamar a la función cuando el campo de producto cambia
            document.getElementById('producto1').addEventListener('change', function() {
                actualizarCampos();
            });

            // Función para mostrar/ocultar campos según el producto seleccionado
            function actualizarCampos() {
                var producto = document.getElementById('producto1').value.toLowerCase().trim();
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
    $(document).ready(function() {
        // Detectar cuando cambie el valor del campo 'producto'
        $('#producto1').change(function() {
            limpiarCampos(); // Llama a la función que limpia los campos
        });

    // Función para limpiar todos los campos del formulario, excluyendo el campo 'producto' y 'fecha'
    function limpiarCampos() {
        // Guardar el valor del campo 'fecha'
        var fechaValor = $('#fecha').val();

        // Limpiar todos los inputs de texto, número y archivo, excluyendo 'fecha'
        $('input[type="text"], input[type="number"], input[type="file"]').not('#codigo_generado, #contador_entra, #origen, #ano_mes, #solicitante, #fecha_oc').prop('value', '');

        // Limpiar selects, excluyendo 'producto1' y 'solicitante'
        $('select').not('#producto1, #solicitante').prop('selectedIndex', 0);

        // Limpiar textareas
        $('textarea').prop('value', '');

        // Limpiar campos ocultos si es necesario
        $('input[type="hidden"]').prop('value', '');

        // Limpiar listas específicas
        $('#list').empty(); 
        $('#lista_seriales').empty(); 
        seriales = []; // Reiniciar la lista de seriales

        // Restaurar el valor del campo 'fecha' después de limpiar
        $('#fecha').prop('value', fechaValor);
    }

    });

    document.getElementById('pitch').addEventListener('change', function() {
    var pitchId = this.value;

        // Limpiar el campo "campo_referencia" cuando cambie el pitch
        document.getElementById('campo_referencia').value = '';
        console.log("Pitch seleccionado:", pitchId); // <--- Verificar qué ID se está enviando


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

    <script>
    $(document).ready(function() {
        $('#solicitante').change(function() {
            var solicitante = $(this).val(); // Obtener el solicitante seleccionado

            if (solicitante !== "") {
                $.ajax({
                    url: 'generar_codigo.php',  // Archivo PHP que genera el código
                    type: 'POST',
                    data: { solicitante: solicitante },
                    success: function(response) {
                        $('#codigo_generado').val(response); // Mostrar código en el input
                    },
                    error: function() {
                        alert("Error al generar el código.");
                    }
                });
            } else {
                $('#codigo_generado').val(''); // Limpiar si no hay solicitante seleccionado
            }
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        // Cuando cambia el campo "uso", carga los modelos filtrados
        $('#uso').change(function() {
            var uso = $(this).val();
            console.log("Uso seleccionado:", uso); // <-- Verificar qué se está enviando

            if (uso !== "") {
                $.ajax({
                    url: 'get_modelos.php',  // Archivo PHP que obtiene los modelos
                    type: 'POST',
                    data: { uso: uso },
                    success: function(response) {
                        $('#modelo').html(response);
                        $('#pitch').html('<option value="">Seleccione un pitch</option>'); // Limpiar pitch
                    },
                    error: function() {
                        alert("Error al obtener modelos.");
                    }
                });
            } else {
                $('#modelo').html('<option value="">Seleccione un modelo</option>');
                $('#pitch').html('<option value="">Seleccione un pitch</option>');
            }
        });

        // Cuando cambia el campo "modelo", carga los pitch filtrados
        $('#modelo').change(function() {
            var modelo = $(this).val();

            if (modelo !== "") {
                $.ajax({
                    url: 'get_pitch.php',  // Archivo PHP que obtiene los pitch
                    type: 'POST',
                    data: { modelo: modelo },
                    success: function(response) {
                        $('#pitch').html(response);
                    },
                    error: function() {
                        alert("Error al obtener pitch.");
                    }
                });
            } else {
                $('#pitch').html('<option value="">Seleccione un pitch</option>');
            }
        });
    });
    </script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.getElementById("table_body");
    const addItemButton = document.getElementById("add_item");
    const clearButton = document.getElementById("clear_items");

    addItemButton.addEventListener("click", function () {
        agregarFila();
        limpiarCampos();
    });

    function agregarFila() {
    // Obtener valores de los inputs y selects
    const fecha = document.querySelector('input[name="fecha[]"]')?.value || "";
    const cantidadEntradaMd = document.querySelector('input[name="cantidad[]"]').value.trim() || "0";

    // Función para obtener el texto visible del select dinámico
    function obtenerTextoSelect(selector) {
        const select = document.querySelector(selector);
        return select && select.selectedIndex >= 0 ? select.options[select.selectedIndex].text.trim() : "";
    }

    const producto = obtenerTextoSelect('select[name="producto1[]"]');
    const pitch = obtenerTextoSelect('select[name="pitch[]"]');
    const modelo = obtenerTextoSelect('select[name="modelo[]"]');
    const marcaControl = obtenerTextoSelect('select[name="marca_control[]"]');
    const referenciaControl35 = obtenerTextoSelect('select[name="referencia_control35[]"]');
    const marcaFuente = obtenerTextoSelect('select[name="marca_fuente[]"]');
    const modeloFuente35 = obtenerTextoSelect('select[name="modelo_fuente35[]"]');
    const justificacion = document.querySelector('textarea[name="notas[]"]')?.value.trim() || "";

    // Determinar el valor de "Modelo/Nombre"
    let modeloNombre = "N/A"; // Valor por defecto
    if (modelo && pitch && modelo !== "Seleccione una Categoría") {
        modeloNombre = `${modelo} / ${pitch}`;
    } else if (marcaControl && referenciaControl35 && marcaControl !== "Seleccione una Categoría") {
        modeloNombre = `${marcaControl} / ${referenciaControl35}`;
    } else if (marcaFuente && modeloFuente35 && marcaFuente !== "Seleccione una Categoría") {
        modeloNombre = `${marcaFuente} / ${modeloFuente35}`;
    }

    // Crear una nueva fila y agregarla a la tabla
    const newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td></td> <!-- Se asignará el número correctamente -->
        <td>${fecha}</td>
        <td>${producto}</td>
        <td>${modeloNombre}</td>
        <td>${justificacion}</td>
        <td>${cantidadEntradaMd}</td>
        <td>
            <center>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">Eliminar</button>
            </center>
        </td>
    `;
    tableBody.appendChild(newRow);
    actualizarNumeracion();
}



    function actualizarNumeracion() {
        document.querySelectorAll("#table_body tr").forEach((row, index) => {
            row.cells[0].textContent = index + 1;
        });
    }

    function limpiarCampos() {
        const inputs = document.querySelectorAll('input[name="cantidad[]"]');
        const selects = document.querySelectorAll('select[name="producto1[]"], select[name="pitch[]"], select[name="modelo[]"], select[name="marca_control[]"], select[name="referencia_control35[]"], select[name="marca_fuente[]"], select[name="modelo_fuente35[]"]');
        const textarea = document.querySelector('textarea[name="notas[]"]');

        inputs.forEach(input => input.value = '');
        selects.forEach(select => select.selectedIndex = 0);
        if (textarea) textarea.value = '';
    }

    window.eliminarFila = function (btn) {
        btn.closest("tr").remove();
        actualizarNumeracion();
    };

    // Guardar datos antes de enviar el formulario
    document.getElementById('formulario_creacion_producto').addEventListener('submit', function () {
        const rows = document.querySelectorAll('#table_body tr');
        const itemData = [];

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowData = {
                item: cells[0].innerText,
                fecha: cells[1].innerText,
                producto: cells[2].innerText,
                modelo_nombre: cells[3].innerText,
                justificacion: cells[4].innerText,
                cantidad_entrada_md: cells[5].innerText
            };
            itemData.push(rowData);
        });

        document.getElementById('item_data').value = JSON.stringify(itemData);
    });

    // Limpiar tabla con botón "clear_items"
    if (clearButton) {
        clearButton.addEventListener("click", function () {
            tableBody.innerHTML = ""; // Borra todas las filas
            actualizarNumeracion(); // Se asegura de que el conteo de filas reinicie
        });
    }
});
</script>




    <!-- Script para añadir y eliminar items en la tabla -->
    <!--<script>
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
                <!--<td>${producto}</td>
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
    <!--<script>
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
    </script>-->