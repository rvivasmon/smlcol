<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

$usuario = $sesion_usuario['nombre'];

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nuevo Tamaño</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create.php" method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tamano">TAMAÑO</label>
                                    <input type="text" name="tamano" id="tamano" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="habilitado">Habilitar?</label>
                                    <select name="habilitado" id="habilitado" class="form-control">
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Este es el campo oculto del ID del usuario seleccionado aquí -->
                        <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $usuario; ?>">
                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/ti/partes_modulos/tamanos/";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Registrar Modulo</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../../../../layout/admin/parte2.php');?>