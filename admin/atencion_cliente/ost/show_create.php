<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');
include('controller_show_create.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Visor de Órdenes</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-info">
                <div class="card-header">
                    Detalle del ticket
                </div>
                <div class="card-body">
                <div class="row">
                            <div class="col-md-0">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="text" name="idost" class="form-control" value="<?php echo $id_ost; ?>" hidden>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Fecha de Ingreso</label>
                                    <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value= "<?php echo $fecha_ingreso; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Medio de Ingreso</label>
                                    <input class="form-control"  id="medio_ingreso" name="medio_ingreso" value="<?php echo $medio_ingreso; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Ticket Externo</label>
                                    <input type="text" name="ticketexterno" class="form-control" value="<?php echo $ticket_externo; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Tipo de Servicio</label>
                                    <input name="tiposervicio" id="tiposervicio" class="form-control"  value="<?php echo $servicio; ?>" disabled>                                      
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">ID Producto</label>
                                    <input type="text" name="idproducto" class="form-control" value="<?php echo $id_producto; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">N° OST</label>
                                    <input type="text" name="numost" class="form-control" value="<?php echo $num_ost; ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <input name="idcliente" id="idcliente" class="form-control" value="<?php echo $cliente; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Ciudad</label>
                                    <input name="idciudad" id="idciudad" class="form-control" value="<?php echo $ciudad; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Proyecto</label>
                                    <input type="text" name="proyecto" class="form-control" value="<?php echo $proyecto; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="">Estado</label>
                                    <input name="idestado" id="idestado" class="form-control" value="<?php echo $estado; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Persona Contacto</label>
                                    <input type="text" name="personacontacto" class="form-control" value="<?php echo $persona_contacto; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Medio de Contacto</label>
                                    <input type="text" name="medio_contacto" class="form-control" value="<?php echo $medio_contacto; ?>" disabled>
                                </div>
                            </div>                            
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Falla</label>
                                    <textarea name="falla" class="form-control" rows="4" disabled><?php echo $falla; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Observación</label>
                                    <textarea name="observacion" rows="4" class="form-control" disabled><?php echo $observacion; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/atencion_cliente/ost/index_create.php"; ?>" class="btn btn-default btn-block">Volver</a>
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
