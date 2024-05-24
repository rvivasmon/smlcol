<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');
include('controller_show_tracking_terminado.php');

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
                                                <label for="">Date Finished</label>
                                                <input type="text" name="date_finished" class="form-control" value="<?php echo $date_finished; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Num Envoys</label>
                                                <input type="text" name="num_envoys" class="form-control" value="<?php echo $num_envoys; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Ship</label>
                                                <input type="text" name="ship" class="form-control" value="<?php echo $ship; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="">Guia</label>
                                                <input type="text" name="guia" class="form-control" value="<?php echo $guia; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Fecha Guia</label>
                                                <input type="text" name="fecha_guia" class="form-control" value="<?php echo $fecha_guia; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Observaciones China</label>
                                    <textarea name="obschina" class="form-control" rows="8" disabled><?php echo $obschina; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/administracion/tracking/tracking_chi/index_tracking.php"; ?>" class="btn btn-default btn-block">Volver</a>
                            </div>
                        </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../../layout/admin/parte2.php');?>
