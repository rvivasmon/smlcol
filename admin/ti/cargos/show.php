<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');
include('controller_show.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Visor de Roles</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-info">
                <div class="card-header">
                    Detalle del Rol
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Rol o Cargo</label>
                                <input name="id_cargo" id="id_cargo" class="form-control" value="<?php echo $cargo; ?>" disabled>
                            </div>
                        </div>                            
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-2">
                            <a href="<?php echo $URL."admin/ti/cargos/index.php"; ?>" class="btn btn-default btn-block">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>
