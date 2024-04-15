<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT * FROM cargo WHERE id_cargo = '$id_get'");

$query->execute();
$cargos = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($cargos as $cargo){
    $id = $cargo['id_cargo'];
    $rol = $cargo['descripcion'];

}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edición Usuario</h1>

                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card">
                <div class="card-header" style="background-color: #00A000; color: #ffffff">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit.php" method="post">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Rol o Cargo</label>
                                    <input type="text" name="rol" value="<?php echo $rol;?>" class="form-control" placeholder="Usuario">
                                    <input type="text" name="id_cargo" value="<?php echo $id_get;?>" hidden>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/ti/cargos/";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Asegurese de diligenciar correctamente los datos')" class="btn btn-success btn-block">Actualizar Usuario</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>
