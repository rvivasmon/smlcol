<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');
include('../../../layout/admin/parte1.php');

$id_get = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM vehiculos WHERE vehiculos.id = :id");
$query->bindParam(':id', $id_get);
$query->execute();
$vehiculo = $query->fetch(PDO::FETCH_ASSOC);

if (!$vehiculo) {
    echo "Vehículo no encontrado";
    exit;
}

$id = $vehiculo['id'];
$placa = $vehiculo['placa'];
$propietario = $vehiculo['propietario'];
$tipo_vehiculo = $vehiculo['tipo_vehiculo'];
$pico_placa = $vehiculo['pico_placa'];
$soat_hasta = $vehiculo['soat_hasta'];
$tecnicomecanica_hasta = $vehiculo['tecnicomecanica_hasta'];
$observacion = $vehiculo['observacion'];
$fecha_terminacion = date("Y-m-d");
$usuario = $sesion_usuario['nombre'];


$usuario_termina_tarea = $sesion_usuario['nombre'];
$fecha_terminacion = date('Y-m-d');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Terminar Tarea</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="card card-blue">
                <div class="card-header" style="background-color: #d92005; color: #ffffff">
                    <a href="#" class="d-block"><?php echo $sesion_usuario['nombre']?></a>
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_terminacion.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha de Terminacion</label>
                                    <input name="fecha_terminacion" id="fecha_terminacion"  value="<?php echo $fecha_terminacion ?>" class="form-control" readonly></input>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="placa">Placa Vehiculo</label>
                                    <input type="text" name="placa" id="placa" value="<?php echo $placa; ?>" class="form-control" readonly>
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
                                    <label for="idusuario">Usuario Que Termina La Tarea</label>
                                    <input type="text" name="usuario_termina_tarea" id="usuario_termina_tarea" value="<?php echo $sesion_usuario['nombre']?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tipo_vehiculo">Clase Vehículo</label>
                                    <input type="text" name="tipo_vehiculo" id="tipo_vehiculo" value="<?php echo $tipo_vehiculo; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pico_placa">Tiene Pico y Placa</label>
                                    <input type="text" name="pico_placa" id="pico_placa" value="<?php echo $pico_placa; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="soat_hasta">Tiene Soat Hasta</label>
                                    <input type="date" name="soat_hasta" id="soat_hasta" value="<?php echo $soat_hasta; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tecnicomecanica_hasta">Tiene Técnicomecánica Hasta</label>
                                    <input type="date" name="tecnicomecanica_hasta" id="tecnicomecanica_hasta" value="<?php echo $tecnicomecanica_hasta; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_terminacion">Fecha de Terminación</label>
                                    <input type="date" name="fecha_terminacion" id="fecha_terminacion" value="<?php echo $fecha_terminacion; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha de la Tarea a Realizar</label>
                                    <input  name="fecha_tarea" id="fecha_tarea"  class="form-control" placeholder="TAREA TERMINADA" readonly></input>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tarea_realizar">Tarea a Realizar</label>
                                    <textarea name="tarea_realizar" id="tarea_realizar" cols="30" rows="4" class="form-control" readonly>TAREA TERMINADA</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control" readonly><?php echo $observacion; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="<?php echo $URL . "admin/administracion/vehiculos/index.php"; ?>" class="btn btn-default btn-block">Cancelar</a>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-danger btn-block">Terminar Tarea</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->
</div><!-- /.content-wrapper -->

<?php include('../../../layout/admin/parte2.php');?>