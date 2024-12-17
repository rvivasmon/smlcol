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
                                            cc.marca_control as nombre_marca,
                                            cc1.funcion_control as nombre_funcion,
                                            rfc.referencia as nombre_referencia,
                                            da.posiciones as nombre_posicion
                                        FROM
                                            alma_principal AS ap
                                        INNER JOIN 
                                            referencias_control AS rfc ON ap.producto = rfc.id_referencia
                                        LEFT JOIN
                                            caracteristicas_control AS cc ON rfc.marca = cc.id_car_ctrl
                                        LEFT JOIN
                                            caracteristicas_control AS cc1 ON rfc.funcion = cc1.id_car_ctrl
                                        LEFT JOIN
                                            distribucion_almacen AS da ON ap.posicion = da.id
                            WHERE
                                ap.id_almacen_principal = :id_get'
                            );

$query->execute(['id_get' => $id_get]);
$almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($almacenes_pricipales as $almacen_pricipal){
    $id = $almacen_pricipal['id_almacen_principal'];
    $marca = $almacen_pricipal['nombre_marca'];
    $funcion = $almacen_pricipal['nombre_funcion'];
    $referencia = $almacen_pricipal['nombre_referencia'];
    $posicion = $almacen_pricipal['nombre_posicion'];
    $existencia = $almacen_pricipal['cantidad_plena'];
    $observacion = $almacen_pricipal['observacion'];
    $fecha_ingreso = $almacen_pricipal['CREATED_AT'];
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editor de Controladoras</h1>
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
                                    <label for="marca_control">Marca</label>
                                    <input type="texto" id="marca_control" name="marca_control" class="form-control" value="<?php echo $marca; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="funcion">Función</label>
                                    <input type="texto" id="funcion" name="funcion" class="form-control" value="<?php echo $funcion; ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="referencia">Referencia</label>
                                    <input type="texto" id="referencia" name="referencia" class="form-control" value="<?php echo $referencia; ?>" readonly>
                                    <!-- Agregar el ID del módulo como campo oculto -->
                                    <input type="hidden" name="id_control21" value="<?php echo $id_get; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ubicacion">Ubicación</label>
                                    <select name="ubicacion" id="ubicacion" class="form-control" required>
                                        <option value=""><?php echo $posicion; ?></option>
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="existencia">Existencia</label>
                                    <input type="texto" id="existencia" name="existencia" class="form-control" value="<?php echo $existencia; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-0">
                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                    <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="observacion21">Observación</label>
                                    <textarea name="observacion21" id="observacion21" cols="30" rows="4" class="form-control"><?php echo $observacion; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/almacen/inventario/principal/control";?>" class="btn btn-default btn-block">Cancelar</a>
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
