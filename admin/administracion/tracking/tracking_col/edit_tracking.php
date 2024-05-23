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
    $date = $tracking['date'];
    $origin = $tracking['origin'];
    $type = $tracking['type'];
    $category = $tracking['category'];
    $quantitly = $tracking['quantitly'];
    $obscolombia = $tracking['observaciones_colombia'];


}

?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edición Nueva Solicitud</h1>

                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card">
                <div class="card-header" style="background-color: #00A000; color: #ffffff">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit_tracking.php" method="post">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Date</label>
                                                <input type="text" name="date" value="<?php echo $date;?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Origin</label>
                                                <input type="text" name="origin" value="<?php echo $origin;?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Type</label>
                                                <select class="form-control" id="tipoproducto" name="tipoproducto" required>
                                                    <option value="">Seleccionar Tipo Producto</option>
                                                    <option value="Fuentes" <?php echo ($type == 'Fuentes') ? 'selected' : ''; ?>>Fuentes</option>
                                                    <option value="Modulos" <?php echo ($type == 'Modulos') ? 'selected' : ''; ?>>Modulos</option>
                                                    <option value="Tarjetas" <?php echo ($type == 'Tarjetas') ? 'selected' : ''; ?>>Tarjetas</option>
                                                    <option value="Sistema de Control" <?php echo ($type == 'Sistema de Control') ? 'selected' : ''; ?>>Sistema de Control</option>
                                                    <option value="Video Procesador" <?php echo ($type == 'Video Procesador') ? 'selected' : ''; ?>>Video Procesador</option>
                                                    <option value="LCD" <?php echo ($type == 'LCD') ? 'selected' : ''; ?>>LCD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="">Category</label>
                                                <input type="text" name="descripcion" class="form-control" value="<?php echo $category;?>" placeholder="Nombre Comercial">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Quantitly</label>
                                                <input type="text" name="quantitly" value="<?php echo $quantitly;?>" class="form-control" >
                                                <input type="text" name="id" value="<?php echo $id;?>" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Observaciones Colombia</label>
                                    <textarea type="text" name="obscolombia" class="form-control" rows="8" required><?php echo $obscolombia;?></textarea>
                                </div>
                            </div>
                        </div>                        

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/administracion/tracking/tracking_col/index_tracking.php";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Asegurese de diligenciar correctamente los datos')" class="btn btn-success btn-block">Actualizar Solicitud</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../../layout/admin/parte2.php');?>
