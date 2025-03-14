<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

include('../../../../../layout/admin/parte1.php');
include('controller_show.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Visor de Controladoras</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-info">
                <div class="card-header">
                    Detalle de Controladora
                </div>
                <div class="card-body">
                    <form action="controller_show.php" method="POST">
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
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ubicacion">Ubicación</label>
                                    <input type="ubicacion" id="ubicacion" name="ubicacion" class="form-control" value="<?php echo $posicion; ?>" readonly>
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
                                    <label for="observacion">Observación</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control" readonly><?php echo $observacion1; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <a href="<?php echo $URL."admin/almacen/stock/techled/control";?>" class="btn btn-default btn-block">Regresar</a>
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
