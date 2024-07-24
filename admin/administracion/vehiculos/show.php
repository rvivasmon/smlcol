<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');



$id_get = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM vehiculos WHERE vehiculos.id = '$id_get' ");

$query->execute();
$vehiculo = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($vehiculo as $vehiculos){
    $id = $vehiculos['id'];
    $placa = $vehiculos['placa'];
    $propietario = $vehiculos['propietario'];
    $tipo_vehiculo = $vehiculos['tipo_vehiculo'];
    $pico_placa = $vehiculos['pico_placa'];
    $soat_hasta = $vehiculos['soat_hasta'];
    $tecnicomecanica_hasta = $vehiculos['tecnicomecanica_hasta'];
    $tarea_realizar = $vehiculos['tarea_realizar'];
    $clase_tarea = $vehiculos['clase_tarea'];
    $observacion = $vehiculos['observacion'];
}
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Visor de Tareas</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-info">
                <div class="card-header">
                    Detalle del ticket
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="idusuario">Usuario Crea Vehiculo</label>
                                    <input type="text" name="usuario_crea_vehiculo" id="usuario_crea_vehiculo" value="<?php echo $vehiculos['usuario_crea_vehiculo']; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Placa Vehiculo</label>
                                    <input type="text" name="placa"  value="<?php echo $placa;?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="placa">Propietario Del vehículo</label>
                                    <input type="text" name="propietario" id="propietario" value="<?php echo $propietario; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Clase Vehiculo</label>
                                    <input type="text" name="tipo_vehiculo"  value="<?php echo $tipo_vehiculo;?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tiene Pico y Placa</label>
                                    <input type="text" name="pico_placa"  value="<?php echo $pico_placa;?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tiene Soat Hasta</label>
                                    <input type="text" name="soat_hasta"  value="<?php echo $soat_hasta;?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tiene Tecnicomecanica Hasta</label>
                                    <input name="tecnicomecanica_hasta" id="tecnicomecanica_hasta"  value="<?php echo $tecnicomecanica_hasta;?>"class="form-control" readonly>              
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="idusuario">Usuario Crea Tarea</label>
                                    <input type="text" name="usuario_crea_tarea" id="usuario_crea_tarea" value="<?php echo $vehiculos['usuario_crea_tarea']; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="idusuario">Usuario Termina Tarea</label>
                                    <input type="text" name="usuario_termina_tarea" id="usuario_termina_tarea" value="<?php echo $vehiculos['usuario_termina_tarea']; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha Tarea a Realizar</label>
                                    <input  name="fecha_tarea" id="fecha_tarea"  class="form-control"value=" <?php echo $vehiculos['fecha_tarea'];?>" readonly></input>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Clase de Tarea</label>
                                    <input class="form-control"  id="clase_tarea" name="clase_tarea" value="<?php echo $clase_tarea; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tarea Realizar</label>
                                    <textarea type="text" name="tarea_realizar" id="" cols="30" rows="4"  value="" class="form-control" readonly><?php echo $tarea_realizar;?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Observacion</label>
                                    <textarea name="observacion" id="observacion" id="" cols="30" rows="4"  value="" class="form-control" readonly><?php echo $vehiculos['observacion'];?></textarea>              
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?php echo $URL."admin/administracion/vehiculos/index.php"; ?>" class="btn btn-default btn-block">Volver</a>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>