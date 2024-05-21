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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Fecha</label>
                                    <input type="text" name="fecha" class="form-control" value="<?php echo $fecha; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">OP</label>
                                    <input type="text" name="op" class="form-control" value="<?php echo $op; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Tipo</label>
                                    <input type="text" name="tipo" class="form-control" value="<?php echo $tipo; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Descripcion</label>
                                    <input type="text" name="descripcion" class="form-control" value="<?php echo $descripcion; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Cantidad</label>
                                    <input type="text" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Procesada</label>
                                    <input type="text" name="procesada" class="form-control" value="<?php echo $procesada; ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">En produccion</label>
                                    <input type="text" name="enproduccion" class="form-control" value="<?php echo $enproduccion; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Numero PL</label>
                                    <input type="text" name="numpl" class="form-control" value="<?php echo $numpl; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">SHIP</label>
                                    <input type="text" name="ship" class="form-control" value="<?php echo $ship; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">En transito</label>
                                    <input type="text" name="entransito" class="form-control" value="<?php echo $entransito; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Guia</label>
                                    <input type="text" name="guia" class="form-control" value="<?php echo $guia; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Fecha Guia</label>
                                    <input name="id_cargo" id="fechaguia" class="form-control" value="<?php echo $fechaguia; ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Tipo Envío</label>
                                    <input type="text" name="tipoenvio" class="form-control" value="<?php echo $tipoenvio; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Fecha Llegada</label>
                                    <input type="text" name="fechallegada" class="form-control" value="<?php echo $fechallegada; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Fecha Recibido</label>
                                    <input type="text" name="fecharecibido" class="form-control" value="<?php echo $fecharecibido; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Obs. en Colombia</label>
                                    <textarea name="obscolombia" class="form-control" rows="4" disabled><?php echo $obscolombia; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Obs. en China</label>
                                    <textarea name="obschina" class="form-control" rows="4" disabled><?php echo $obschina; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/administracion/tracking/index_tracking.php"; ?>" class="btn btn-default btn-block">Volver</a>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>
