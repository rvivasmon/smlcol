<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

?>

<?php include('../../../layout/admin/parte1.php');

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
                    <h1 class="m-0">Eliminación del Usuario</h1>

                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card">
                <div class="card-header" style="background-color: #d92005; color: #ffffff">
                    ¿DESEA ELIMINAR AL USUARIO?
                </div>
                <div class="card-body">
                    <form action="controller_delete.php" method="post">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Rol o Cargo</label>
                                    <input type="text" name="rol" value="<?php echo $rol;?>" class="form-control" readonly>
                                    <input type="text" name='id_cargo' value="<?php echo $id_get;?>" hidden>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/ti/cargos/";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('¿Seguro de querer eliminar al usuario?')" class="btn btn-danger btn-block">Eliminar Usuario</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>
