<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nueva Ciudad</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-blue">
                        <div class="card-header">
                            Introduzca la información correspondiente
                        </div>
                        <div class="card-body">
                            <form action="controller_create_ciudad.php" method="post">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Ciudad</label>
                                            <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Departamento/Provincia/Estado</label>
                                            <input type="text" name="departamento" class="form-control" placeholder="Departamento" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">País</label>
                                            <input type="text" name="pais" class="form-control" placeholder="País" required>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="<?php echo $URL."admin/ti/ciudades";?>" class="btn btn-default btn-block">Cancelar</a>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Registrar Ciudad</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>
