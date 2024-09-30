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

$today = date("Y-m-d");

if ($soat_hasta < $today || $tecnicomecanica_hasta < $today) {
    $documentos_vencidos = true;
} else {
    $documentos_vencidos = false;
}

$usuario_crea_tarea = $sesion_usuario['nombre'];
$fecha_asignacion_tarea = date('Y-m-d');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nuevo Registro</h1>
                </div>
            </div>

            <div class="card card-blue">
                <div class="card-header" style="background-color: #00A000; color: #ffffff">
                    <a href="#" class="d-block"><?php echo $sesion_usuario['nombre']?></a>
                    Introduzca la información correspondiente
                </div>

                <div class="card-body">
                    <?php if ($documentos_vencidos): ?>
                        <div class="alert alert-danger">
                            Los documentos del vehículo están vencidos. No puede asignar una tarea.
                        </div>
                        <a href="<?php echo $URL . "admin/administracion/vehiculos/index.php"; ?>" class="btn btn-default btn-block">Volver</a>
                    <?php else: ?>
                        <form action="controller_tarea.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="row">
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_ingreso">Fecha Asignacion Tarea</label>
                                    <input name="fecha_asignacion_tarea" value="<?php echo $fecha_asignacion_tarea;?>" class="form-control" readonly>
                                </div>
                            </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="placa">Placa Vehiculo</label>
                                        <input type="text" name="placa" id="placa" value="<?php echo $placa; ?>" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="placa">Propietario del vehículo</label>
                                        <input type="text" name="propietario" id="propietario" value="<?php echo $propietario; ?>" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tipo_vehiculo">Clase Vehículo</label>
                                        <input type="text" name="tipo_vehiculo" id="tipo_vehiculo" value="<?php echo $tipo_vehiculo; ?>" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="pico_placa">Tiene Pico y Placa</label>
                                        <input type="text" name="pico_placa" id="pico_placa" value="<?php echo $pico_placa; ?>" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="soat_hasta">Tiene Soat Hasta</label>
                                        <input type="date" name="soat_hasta" id="soat_hasta" value="<?php echo $soat_hasta; ?>" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tecnicomecanica_hasta">Tienen Técnicomecánica Hasta</label>
                                        <input type="date" name="tecnicomecanica_hasta" id="tecnicomecanica_hasta" value="<?php echo $tecnicomecanica_hasta; ?>" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tecnicomecanica_hasta">Usuario Crea Tarea</label>
                                        <input type="text" name="usuario_crea_tarea" id="usuario_crea_tarea" value="<?php echo $sesion_usuario['nombre']?>" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_tarea">Fecha Tarea a Realizar</label>
                                        <input type="date" name="fecha_tarea" id="fecha_tarea"  class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Clase de Tarea</label>
                                        <select class="form-control"  id="clase_tarea" name="clase_tarea" value="<?php echo $clase_tarea;?>" required>
                                            <option value="">Seleccionar Clase de Tarea</option>
                                            <option value="Transportar">Transportar (Llevar ó Recoger)</option>
                                            <option value="Cambio aceite">Cambio de Aceite y Filtros</option>
                                            <option value="Revision">Revisón (Mantenimiento)</option>
                                            <option value="Lavado">Lavar el Vehiculo</option>
                                            <option value="Otro">OTRO</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tarea_realizar">Tarea a Realizar</label>
                                        <textarea name="tarea_realizar" id="tarea_realizar" cols="30" rows="4" placeholder="Ingrese la tarea a realizar y la fecha" class="form-control" required></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="observacion">Observación</label>
                                        <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control"><?php echo $observacion; ?></textarea>
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
                                            <button type="submit" onclick="return confirm('¿Está seguro de haber diligenciado correctamente los datos?')" class="btn btn-success btn-block">Registrar Tarea</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php  endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../../../layout/admin/parte2.php'); ?>
