<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

include('../../../../../layout/admin/parte1.php');

// Captura el ID directamente desde la URL
$id_get = $_GET['id'];

$query = $pdo->prepare('SELECT 
                                ap.*,
                                cf.marca_fuente as nombre_marca,
                                cf1.tipo_fuente as nombre_tipo,
                                rf.voltaje_salida as nombre_voltaje,
                                rf.modelo_fuente as nombre_modelo,
                                da.posiciones as nombre_posicion
                            FROM
                                alma_smartled AS ap
                            INNER JOIN 
                                referencias_fuente AS rf ON ap.producto = rf.id_referencias_fuentes
                            LEFT JOIN
                                caracteristicas_fuentes AS cf ON rf.marca_fuente = cf.id_car_fuen
                            LEFT JOIN
                                caracteristicas_fuentes AS cf1 ON rf.tipo_fuente = cf1.id_car_fuen
                            LEFT JOIN
                                distribucion_almacen AS da ON ap.posicion = da.id
                            WHERE
                                ap.id_almacen_principal = :id_get'
                            );

$query->execute(['id_get' => $id_get]);
$almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($almacenes_pricipales as $almacen_pricipal){
    $id = $almacen_pricipal['id_almacen_principal'];
    $marca_fuente = $almacen_pricipal['nombre_marca'];
    $tipo_fuente = $almacen_pricipal['nombre_tipo'];
    $voltaje_salida = $almacen_pricipal['nombre_voltaje'];
    $modelo_fuente = $almacen_pricipal['nombre_modelo'];
    $posicion = $almacen_pricipal['nombre_posicion'];
    $observacion = $almacen_pricipal['observacion'];
    $existencia = $almacen_pricipal['cantidad_plena'];
    $fecha_ingreso = $almacen_pricipal['CREATED_AT'];
    $id_posicion = $almacen_pricipal['posicion'];
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editor de Fuentes</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-success">
                <div class="card-header">
                    Detalle de Fuente
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="marca_fuente">Marca Fuente</label>
                                    <input type="texto" id="marca_fuente" name="marca_fuente" class="form-control" value="<?php echo $marca_fuente; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="tipo_fuente">Tipo Fuente</label>
                                    <input type="texto" id="tipo_fuente" name="tipo_fuente" class="form-control" value="<?php echo $tipo_fuente; ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="voltaje_salida">Voltaje Salida</label>
                                    <input type="texto" id="voltaje_salida" name="voltaje_salida" class="form-control" value="<?php echo $voltaje_salida; ?>" readonly>
                                    <!-- Agregar el ID del módulo como campo oculto -->
                                    <input type="hidden" name="id_fuente21" value="<?php echo $id_get; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="modelo_fuente">Modelo Fuente</label>
                                    <input type="texto" id="modelo_fuente" name="modelo_fuente" class="form-control" value="<?php echo $modelo_fuente; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ubicacion">Ubicación</label>
                                    <select name="ubicacion" id="ubicacion" class="form-control" required>
                                        <option value="<?php echo $id_posicion?>"><?php echo $posicion; ?></option>
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
                            <div class="col-md-0">
                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                    <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="existencia">Existencia</label>
                                    <input type="texto" id="existencia" name="existencia" class="form-control" value="<?php echo $existencia; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <textarea name="observacion21" id="observacion21" cols="30" rows="4" class="form-control"><?php echo htmlspecialchars($observacion); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/almacen/stock/smartled/fuentes"; ?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Asegúrese de diligenciar correctamente los datos')" class="btn btn-success btn-block">Actualizar Fuente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../../../layout/admin/parte2.php');?>
