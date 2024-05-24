<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT * FROM tracking WHERE id = '$id_get'");

$query->execute();
$trackings = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($trackings as $tracking){
    $id = $tracking['id'];
    $date_finished = $tracking['date_finished'];
    $num_envoys	 = $tracking['num_envoys'];
    $ship = $tracking['ship'];
    $guia = $tracking['guia'];
    $fecha_guia = $tracking['fecha_guia'];
    $obschina = $tracking['observaciones_china'];


}


// Obtén la fecha actual en el formato deseado
$current_date = date('Y-m-d'); // Cambia el formato según tus necesidades

// Si $date_finished está vacío, asigna la fecha actual
if (empty($date_finished)) {
    $date_finished = $current_date;

}
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Finalización de Producto</h1>

                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card">
                <div class="card-header" style="background-color: #00A000; color: #ffffff">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit_tracking.php" method="post">
                    <input type="hidden" name="finished" value="2">


                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Date Finished</label>
                                                <input type="text" name="date_finished" value="<?php echo $date_finished;?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Num Envoys</label>
                                                <input type="text" name="num_envoys" value="<?php echo $num_envoys;?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Ship</label>
                                                <input type="text" name="ship" value="<?php echo $ship;?>" class="form-control" placeholder="SHIP" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="">Guia</label>
                                                <input type="text" name="guia" class="form-control" value="<?php echo $guia;?>" placeholder="GUIA" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Fecha Guia</label>
                                                <input type="date" name="fecha_guia" value="<?php echo $fecha_guia;?>" class="form-control" >
                                                <input type="text" name="id" value="<?php echo $id;?>" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Observaciones China</label>
                                    <textarea type="text" name="obschina" class="form-control" rows="8" required><?php echo $obschina;?></textarea>
                                </div>
                            </div>
                        </div>                        

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/administracion/tracking/tracking_chi/index_tracking.php";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Asegurese de diligenciar correctamente los datos')" class="btn btn-success btn-block">Finalizar Producto</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../../layout/admin/parte2.php');?>
