<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

?>

<?php include('../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT * FROM permisos WHERE id_permisos = '$id_get'");

$query->execute();
$permisos = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($permisos as $permiso){
    $id = $permiso['id_permisos'];
    $nombre_url = $permiso['nombre_url'];
    $url = $permiso['url'];

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
                                    <label for="">Nombre de la URL</label>
                                    <input type="text" name="nombre_url" value="<?php echo $nombre_url;?>" class="form-control" readonly>
                                    <input type="text" name="id_permisos" value="<?php echo $id_get;?>" hidden>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">URL</label>
                                    <input type="text" name="url" value="<?php echo $url;?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/ti/permisos/";?>" class="btn btn-default btn-block">Cancelar</a>
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
