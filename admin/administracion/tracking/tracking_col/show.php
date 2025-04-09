<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT * FROM tracking WHERE id = '$id_get'");

$query->execute();
$trackings = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($trackings as $tracking){
    $id = $tracking['id'];
    $date = $tracking['date'];
    $solicitante = $tracking['solicitante'];
    $item = $tracking['codigo_generado'];
    $fecha_oc = $tracking['fecha_oc'];
    $origen = $tracking['origen'];
    $origen_cliente = $tracking['origen_cliente'];
    $producto = $tracking['producto'];
    $cantidad = $tracking['cantidad'];
    $uso = $tracking['uso'];
    $pitch = $tracking['pitch'];
    $modelo_nombre = $tracking['modelo_nombre'];
    $category = $tracking['category'];
    $x_mm = $tracking['x_mm'];
    $y_mm = $tracking['y_mm'];
    $resol_x = $tracking['resol_x'];
    $resol_y = $tracking['resol_y'];
    $pixel_modulo = $tracking['pixel_modulo'];
    $marca_control = $tracking['marca_control'];
    $ref_control = $tracking['ref_control'];
    $marca_fuente = $tracking['marca_fuente'];
    $modelo_fuente = $tracking['modelo_fuente'];
    $observaciones_colombia = $tracking['observaciones_colombia'];

    $smd_encapsulado = $tracking['smd_encapsulado'];
    $interface_hub = $tracking['interface_hub'];
    $grupo_datos = $tracking['grupo_datos'];
    $nits_brillo = $tracking['nits_brillo'];
    $corriente_shinkong = $tracking['corriente_shinkong'];
    $corriente_kinglight = $tracking['corriente_kinglight'];
    $corriente_nationstar = $tracking['corriente_nationstar'];
    $num_mod_5v40a = $tracking['num_mod_5v40a'];
    $num_mod_5v60a = $tracking['num_mod_5v60a'];
    $consumo_watts = $tracking['consumo_watts'];
    $cantidad_ic_control = $tracking['cantidad_ic_control'];
    $mls = $tracking['mls'];
    $ref_alim_5v = $tracking['ref_alim_5v'];
    $referencia_cable = $tracking['referencia_cable'];
    $estan_magnet = $tracking['estandar_magnet'];

}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Visor de Solicitudes</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-info" style="width: 120rem;">
                    <div class="card-header">
                        Introduzca la información correspondiente
                    </div>
                    <div class="card-body">
                        <form action="controller_edit_tracking.php" method="post">
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group cloned-section">
                                                <div class="row">
                                                    <div class="col-md-2 items_pre">
                                                        <div class="form-group">
                                                            <label for="items" class="d-block mb-0">Item</label>
                                                            <input type="text" id="items" name="items" class="form-control" value="<?php echo $item; ?>" readonly>
                                                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $sesion_nombre; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="producto" class="d-block mb-0">Producto</label>
                                                            <select id="producto" name="producto" class="form-control" disabled>
                                                                <option value="">Seleccione un Producto</option>
                                                                <?php
                                                                $query_producto = $pdo->prepare('SELECT id_producto, tipo_producto FROM t_productos WHERE tipo_producto IS NOT NULL AND tipo_producto != "" AND habilitar = "1" ORDER BY tipo_producto ASC');
                                                                $query_producto->execute();
                                                                $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach ($productos as $prod) { // Cambiamos $producto por $prod para evitar conflictos
                                                                    $selected = ($prod['tipo_producto'] == $producto) ? 'selected' : ''; // Compara con la variable $producto
                                                                    echo '<option value="' . $prod['id_producto'] . '" ' . $selected . '>' . $prod['tipo_producto'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="entrada_md" class="d-block mb-0">Cantidad</label>
                                                            <input type="number" id="entrada_md" name="entrada_md" class="form-control" value="<?php echo $cantidad; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- MODULO -->

                                                <div class="row">
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="uso">USO</label>
                                                            <select id="uso" name="uso" class="form-control" disabled>
                                                                <option value=""></option>
                                                                    <?php
                                                                    $query_solicitante = $pdo->prepare('SELECT id_uso, producto_uso FROM t_uso_productos WHERE producto_uso IS NOT NULL AND producto_uso != "" AND categoria_productos = "1" ORDER BY producto_uso ASC');
                                                                    $query_solicitante->execute();
                                                                    $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach($solicitantes as $solu) {
                                                                    $selected1 = ($solu['producto_uso'] == $uso) ? 'selected' : '';
                                                                    echo '<option value="' . $solu['id_uso'] . '" ' . $selected1 . '>' . $solu['producto_uso'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="modelo">Categoría:</label>
                                                            <select id="uso" name="uso" class="form-control" disabled>
                                                                <option value=""></option>
                                                                    <?php
                                                                    $query_modelo = $pdo->prepare('SELECT id, modelo_modulo FROM t_tipo_producto WHERE modelo_modulo IS NOT NULL AND modelo_modulo != "" ORDER BY modelo_modulo ASC');
                                                                    $query_modelo->execute();
                                                                    $modelos = $query_modelo->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach($modelos as $modu) {
                                                                    $selected2 = ($modu['modelo_modulo'] == $category) ? 'selected' : '';
                                                                    echo '<option value="' . $modu['id'] . '" ' . $selected2 . '>' . $modu['modelo_modulo'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="pitch">Pitch</label>
                                                            <select id="pitch" name="pitch" class="form-control pitch" disabled>
                                                                <option value=""></option>
                                                                <?php 
                                                                $query_pitch = $pdo->prepare('SELECT id, pitch FROM tabla_pitch ORDER BY pitch ASC');
                                                                $query_pitch->execute();
                                                                $pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach ($pitches as $pit) {
                                                                $selected3 = ($pit['pitch'] == $pitch) ? 'selected' : ''; 
                                                                    echo '<option value="' . $pit['id'] . '" ' . $selected3 . '>' . $pit['pitch'] . '</option>';

                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="x_mm">X mm:</label>
                                                            <select id="x_mm" name="x_mm" class="form-control x_mm" disabled>
                                                                <option value=""></option>
                                                                    <?php
                                                                    $query_solicitante = $pdo->prepare("SELECT DISTINCT tamano_x FROM tabla_tamanos_modulos WHERE tamano_x IS NOT NULL AND tamano_x <> '' AND habilitar_tamano = '1' ORDER BY tamano_x ASC;");
                                                                    $query_solicitante->execute();
                                                                $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach($solicitantes as $soli4) {
                                                                $selected4 = ($soli4['tamano_x'] == $x_mm) ? 'selected' : '';
                                                                    echo '<option value="' . $soli4['id'] . '" ' . $selected4 . '>' . $soli4['tamano_x'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>                                                            
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="y_mm">Y mm:</label>
                                                            <select id="y_mm" name="y_mm" class="form-control y_mm" disabled>
                                                            <option value=""></option>
                                                                <?php
                                                                $query_solicitante = $pdo->prepare("SELECT DISTINCT tamano_y FROM tabla_tamanos_modulos WHERE tamano_y IS NOT NULL AND tamano_y <> '' AND habilitar_tamano = '1' ORDER BY tamano_y ASC;");
                                                                $query_solicitante->execute();
                                                                $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach($solicitantes as $soli5) {
                                                                $selected5 = ($soli5['tamano_y'] == $y_mm) ? 'selected' : '';
                                                                    echo '<option value="' . $soli5['id'] . '" ' . $selected5 . '>' . $soli5['tamano_y'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 items_pre campoModulo">
                                                                    <div class="form-group">
                                                                        <label for="resol_x">Resol. X:</label>
                                                                        <input type="text" id="resol_x" name="resol_x" class="form-control resol_x" value="<?php echo $resol_x; ?>" readonly>
                                                                    </div>                                                        
                                                    </div>
                                                    <div class="col-md-3 items_pre campoModulo">
                                                                    <div class="form-group">
                                                                        <label for="resol_y">Resol. Y:</label>
                                                                        <input type="text" id="resol_y" name="resol_y" class="form-control resol_y" value="<?php echo $resol_y; ?>" readonly>
                                                                    </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                                    <div class="form-group">
                                                                        <label for="pixel_modulo">Pixel Módulo:</label>
                                                                        <input type="text" id="pixel_modulo" name="pixel_modulo" class="form-control pixel_modulo" value="<?php echo $pixel_modulo; ?>" readonly>
                                                                    </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="smd_ancap">SMD Encapsulado</label>
                                                            <input type="text" id="smd_ancap" name="smd_ancap" class="form-control smd_ancap" value="<?php echo $smd_encapsulado; ?>" readonly>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="interface_h">Interface Hub</label>
                                                            <input type="text" id="interface_h" name="interface_h" class="form-control interface_h" value="<?php echo $interface_hub; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="grupo_datos">Grupo Datos</label>
                                                            <input type="text" id="grupo_datos" name="grupo_datos" class="form-control grupo_datos" value="<?php echo $grupo_datos; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="nits">Nits Brillo</label>
                                                            <input type="text" id="nits" name="nits" class="form-control nits" value="<?php echo $nits_brillo; ?>" readonly>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="c_shinkong">Corriente Shinkong</label>
                                                            <input type="text" id="c_shinkong" name="c_shinkong" class="form-control c_" value="<?php echo $corriente_shinkong; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="c_king">Corriente Kinglight</label>
                                                            <input type="text" id="c_king" name="c_king" class="form-control c_" value="<?php echo $corriente_kinglight; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="c_nation">Corriente Nationstar</label>
                                                            <input type="text" id="c_nation" name="c_nation" class="form-control c_" value="<?php echo $corriente_nationstar; ?>" readonly>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="num_mod_5v40a">Num Mod 5v40a</label>
                                                            <input type="text" id="num_mod_5v40a" name="num_mod_5v40a" class="form-control num_mod_5v40a" value="<?php echo $num_mod_5v40a; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="num_mod_5v60a">Num Mod 5v60a</label>
                                                            <input type="text" id="num_mod_5v60a" name="num_mod_5v60a" class="form-control num_mod_5v60a" value="<?php echo $num_mod_5v60a; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="num_ic_control">Cantidad IC control</label>
                                                            <input type="text" id="num_ic_control" name="num_ic_control" class="form-control num_ic_control" value="<?php echo $cantidad_ic_control; ?>" readonly>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="mls">MLS</label>
                                                            <input type="text" id="mls" name="mls" class="form-control mls" value="<?php echo $mls; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="consumo_watts">Consumo Watts</label>
                                                            <input type="text" id="consumo_watts" name="consumo_watts" class="form-control consumo_watts" value="<?php echo $consumo_watts; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="ref_5v">Referencia 5v</label>
                                                            <input type="text" id="ref_5v" name="ref_5v" class="form-control ref_5v" value="<?php echo $ref_alim_5v; ?>" readonly>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="refe_cable">Referencia cable</label>
                                                            <input type="text" id="refe_cable" name="refe_cable" class="form-control refe_cable" value="<?php echo $referencia_cable; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 items_pre campoModulo">
                                                        <div class="form-group">
                                                            <label for="estan_magnet">Standard magnet</label>
                                                            <input type="text" id="estan_magnet" name="estan_magnet" class="form-control estan_magnet" value="<?php echo $estan_magnet; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- CONTROLADORA -->

                                                <div class="row">
                                                    <div class="col-md-6 items_pre campoControl">
                                                        <div class="form-group">
                                                            <label for="marca_control" class="d-block mb-0">Marca Control</label>
                                                            <select id="marca_control" name="marca_control" class="form-control" disabled>
                                                                <option value=""></option>
                                                                <?php 
                                                                $query_marca_control = $pdo->prepare('SELECT id_car_ctrl, marca_control FROM caracteristicas_control WHERE marca_control IS NOT NULL AND marca_control != "" ORDER BY marca_control ASC');
                                                                $query_marca_control->execute();
                                                                $marcas_controles = $query_marca_control->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach ($marcas_controles as $mar_control) {
                                                                $selected6 = ($mar_control['marca_control'] == $marca_control) ? 'selected' : '';
                                                                    echo '<option value="' . $mar_control['id_car_ctrl'] . '" ' . $selected6 . '>' . $mar_control['marca_control'] . '</option>'; 
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 items_pre campoControl">
                                                        <div class="form-group">
                                                            <label for="referencia_control35" class="d-block mb-0">Referencia Control</label>
                                                            <select id="referencia_control35" name="referencia_control35" class="form-control" disabled>
                                                                <option value=""></option>
                                                                <?php 
                                                                $query_referencia_control = $pdo->prepare('SELECT id_referencia, referencia FROM referencias_control WHERE referencia IS NOT NULL AND referencia != "" ORDER BY referencia ASC');
                                                                $query_referencia_control->execute();
                                                                $referencias_control = $query_referencia_control->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach ($referencias_control as $refere_control) {
                                                                $selected7 = ($refere_control['referencia'] == $ref_control) ? 'selected' : '';
                                                                    echo '<option value="' . $refere_control['id_referencia'] . '" ' . $selected7 . '>' . $refere_control['referencia'] . '</option>';
                                                                } 
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- FUENTE -->

                                                <div class="row">
                                                    <div class="col-md-6 items_pre campoFuente">
                                                            <div class="form-group">
                                                                <label for="marca_fuente" class="d-block mb-0">Marca</label>
                                                                <select id="marca_fuente" name="marca_fuente" class="form-control" disabled>
                                                                    <option value=""></option>
                                                                    <?php 
                                                                    $query_marca_fuente = $pdo->prepare('SELECT id_car_fuen, marca_fuente FROM caracteristicas_fuentes WHERE marca_fuente IS NOT NULL AND marca_fuente != ""  ORDER BY marca_fuente ASC');
                                                                    $query_marca_fuente->execute();
                                                                    $marcas_fuentes = $query_marca_fuente->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($marcas_fuentes as $marc_fuente) {
                                                                    $selected8 = ($marc_fuente['marca_fuente'] == $marca_fuente) ? 'selected' : ''; 
                                                                        echo '<option value="' . $marc_fuente['id_car_fuen'] . '" ' . $selected8 . '>' . $marc_fuente['marca_fuente'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                    </div>
                                                    <div class="col-md-6 items_pre campoFuente">
                                                            <div class="form-group">
                                                                <label for="modelo_fuente35" class="d-block mb-0">Modelo</label>
                                                                <select id="modelo_fuente35" name="modelo_fuente35" class="form-control" disabled>
                                                                    <option value=""></option>
                                                                    <?php 
                                                                    $query_modelo_fuente = $pdo->prepare('SELECT id_referencias_fuentes, modelo_fuente FROM referencias_fuente WHERE modelo_fuente IS NOT NULL AND modelo_fuente != ""  ORDER BY modelo_fuente ASC');
                                                                    $query_modelo_fuente->execute();
                                                                    $modelos_fuentes = $query_modelo_fuente->fetchAll(PDO::FETCH_ASSOC);

                                                                    foreach ($modelos_fuentes as $mod_fuente) {
                                                                    $selected9 = ($mod_fuente['modelo_fuente'] == $modelo_fuente) ? 'selected' : '';
                                                                        echo '<option value="' . $mod_fuente['id_referencias_fuentes'] . '" ' . $selected9 . '>' . $mod_fuente['modelo_fuente'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="">Observaciones Colombia</label>
                                        <textarea type="text" name="obscolombia" class="form-control" rows="8" readonly><?php echo $observaciones_colombia;?></textarea>
                                    </div>
                                </div>
                            </div>                        

                            <hr>

                            <div class="row">
                                <div class="col-md-2">
                                    <a href="<?php echo $URL."admin/administracion/tracking/tracking_col/index.php";?>" class="btn btn-default btn-block">Cancelar</a>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" onclick="return confirm('Asegurese de diligenciar correctamente los datos')" class="btn btn-info btn-block">Actualizar Solicitud</button>
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
    document.addEventListener("DOMContentLoaded", function () {
    const selectProducto = document.getElementById("producto");
    const modulos = document.querySelectorAll(".campoModulo");
    const control = document.querySelectorAll(".campoControl");
    const fuentes = document.querySelectorAll(".campoFuente");

    function actualizarCampos() {
        let valor = selectProducto.value;
        
        // Ocultar todos los grupos
        modulos.forEach(e => e.style.display = "none");
        control.forEach(e => e.style.display = "none");
        fuentes.forEach(e => e.style.display = "none");

        // Mostrar el grupo correspondiente según el valor seleccionado
        if (valor === "1") {
            modulos.forEach(e => e.style.display = "block");
        } else if (valor === "2") {
            control.forEach(e => e.style.display = "block");
        } else if (valor === "3") {
            fuentes.forEach(e => e.style.display = "block");
        }
    }

    // Ejecutar al cargar la página por si hay un valor preseleccionado
    actualizarCampos();

    // Evento para cuando el usuario cambia el producto
    selectProducto.addEventListener("change", actualizarCampos);
});

</script>
