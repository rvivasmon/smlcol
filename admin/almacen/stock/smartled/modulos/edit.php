<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

include('../../../../../layout/admin/parte1.php');

// Captura el ID directamente desde la URL
$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT 
                                ap.*,
                                tup.producto_uso as nombre_uso,
                                tp.pitch as nombre_pitch,
                                ttp.modelo_modulo as nombre_modelo,
                                pmc.serie as nombre_serie,
                                ttm.tamanos_modulos as nombre_tamano,
                                ap.CREATED_AT as nombre_fecha,
                                da.posiciones as nombre_posicion
                            FROM
                                alma_smartled AS ap
                            INNER JOIN 
                                producto_modulo_creado AS pmc ON ap.producto = pmc.id
                            LEFT JOIN
                                tabla_pitch AS tp ON pmc.pitch = tp.id
                            LEFT JOIN
                                t_tipo_producto AS ttp ON pmc.modelo = ttp.id
                            LEFT JOIN
                                tabla_tamanos_modulos AS ttm ON pmc.tamano = ttm.id
                            LEFT JOIN
                                t_uso_productos AS tup ON pmc.uso = tup.id_uso
                            LEFT JOIN
                                distribucion_almacen AS da ON ap.posicion = da.id
                            WHERE
                                ap.id_almacen_principal = :id_get");

$query->execute(['id_get' => $id_get]);
$almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($almacenes_pricipales as $almacen_pricipal) {
    $id = $almacen_pricipal['id_almacen_principal'];
    $fecha_ingreso = $almacen_pricipal['nombre_fecha'];
    $uso = $almacen_pricipal['nombre_uso'];
    $pitch = $almacen_pricipal['nombre_pitch'];
    $modelo_modulo = $almacen_pricipal['nombre_modelo'];
    $serie_modulo = $almacen_pricipal['nombre_serie'];
    $tamano = $almacen_pricipal['nombre_tamano'];
    $existencia = $almacen_pricipal['cantidad_plena'];
    $observacion = $almacen_pricipal['observacion'];
    $posicion = $almacen_pricipal['nombre_posicion'];
    $id_posicion = $almacen_pricipal['posicion'];
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editor de Módulo</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-success">
                <div class="card-header">
                    Detalle de Módulo
                </div>
                <div class="card-body">
                    <form action="controller_edit.php" method="POST">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="fecha" id="fecha" name="fecha" class="form-control" value="<?php echo $fecha_ingreso; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="uso">Uso</label>
                                    <input type="uso" id="uso" name="uso" class="form-control" value="<?php echo $uso; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="modelo">Modelo</label>
                                    <input type="modelo" id="modelo" name="modelo" class="form-control" value="<?php echo $modelo_modulo; ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="pitch">Pitch</label>
                                    <input type="pitch" id="pitch" name="pitch" class="form-control" value="<?php echo $pitch; ?>" readonly>
                                    <!-- Agregar el ID del módulo como campo oculto -->
                                    <input type="hidden" name="id_modulo21" value="<?php echo $id_get; ?>">
                                </div>
                            </div>
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="tamano">Tamaño</label>
                                    <input type="tamano" id="tamano" name="tamano" class="form-control" value="<?php echo $tamano; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="serie">Serie</label>
                                    <input type="serie" id="serie" name="serie" class="form-control" value="<?php echo $serie_modulo; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-0">
                                <div class="form-group"> 
                                    <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ubicacion">Ubicación</label>
                                    <select name="ubicacion" id="ubicacion" class="form-control" required>
                                        <option value="<?php echo $id_posicion; ?>"><?php echo $posicion; ?></option>
                                        <?php
                                        $query_posicion = $pdo->prepare('SELECT * FROM distribucion_almacen');
                                        $query_posicion->execute();
                                        $posiciones = $query_posicion->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        foreach($posiciones as $pos) {
                                            $selected = ($pos['id'] == $posicion) ? 'selected' : '';
                                            echo '<option value="' . $pos['id'] . '" ' . $selected . '>' . $pos['posiciones'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="observacion21">Observación</label>
                                    <textarea name="observacion21" id="observacion21" cols="30" rows="4" class="form-control"><?php echo htmlspecialchars($observacion); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/almacen/inventario/principal/modulos";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Asegúrese de diligenciar correctamente los datos')" class="btn btn-success btn-block">Actualizar Módulo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../../../layout/admin/parte2.php');?>
