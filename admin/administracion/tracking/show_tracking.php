<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');
include('controller_show_tracking.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Visor de Solicitudes</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-info">
                <div class="card-header">
                    Detalle de la Solicitud
                </div>
                <div class="card-body">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Fecha</label>
                                                <input type="text" name="fecha" class="form-control" value="<?php echo $fecha; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Origen Solicitud</label>
                                                <input type="text" name="op" class="form-control" value="<?php echo $op; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Tipo Producto</label>
                                                <input type="text" name="tipo" class="form-control" value="<?php echo $tipo; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="">Descripcion</label>
                                                <input type="text" name="descripcion" class="form-control" value="<?php echo $descripcion; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Cantidad</label>
                                                <input type="text" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Obs. en Colombia</label>
                                    <textarea name="obscolombia" class="form-control" rows="8" disabled><?php echo $obscolombia; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/administracion/tracking/index_tracking.php"; ?>" class="btn btn-default btn-block">Volver</a>
                            </div>
                        </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>
