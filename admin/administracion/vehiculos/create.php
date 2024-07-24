<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');
include('../../../layout/admin/parte1.php');

$usuario_crea_vehiculo = $sesion_usuario['nombre'];

$fecha_ingreso = date('Y-m-d'); //Obtiene la fecha actual


?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nuevo Registro</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    <a href="#" class="d-block"><?php echo $sesion_usuario['nombre']?></a>
                    Introduzca la información correspondiente
                </div>

                <div class="card-body">
                    <form action="controller_create.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha de Ingreso</label>
                                    <input name="fecha_ingreso" id="fecha_ingreso"  value="<?php echo $fecha_ingreso?>" class="form-control" readonly></input>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Usuario Que Ingresa el Vehiculo</label>
                                    <input name="usuario_crea_vehiculo" id="usuario_crea_vehiculo"  value="<?php echo $sesion_usuario['nombre']?>" class="form-control" readonly></input>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Placa del Vehiculo</label>
                                    <input type="text" name="placa" id="placa" placeholder="Placa del Vehiculo" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Propietario del Vehículo</label>
                                    <input type="text" name="propietario" id="propietario" placeholder="Nombre del propietario del Vehiculo" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Clase de Vehículo</label>
                                    <Select type="text" name="tipo_vehiculo" id="tipo_vehiculo" class="form-control" required>
                                        <option value="">Seleccionar Clase de Vehiculo</option>
                                        <option value="Carro">Carro</option>
                                        <option value="Moto">Moto</option>
                                    </Select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pico_placa">Tiene Pico y Placa</label>
                                    <Select type="text" name="pico_placa" id="pico_placa" class="form-control" value="<?php echo $pico_placa; ?>" required>
                                        <option value="">Seleccionar el Dia Que Tiene Pico y Placa</option>
                                        <option value="Lunes">Lunes</option>
                                        <option value="Martes">Martes</option>
                                        <option value="MIercoles">MIercoles</option>
                                        <option value="Jueves">Jueves</option>
                                        <option value="Viernes">Viernes</option>
                                    </Select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Hasta cuándo tiene el Soat?</label>
                                    <input type="date" name="soat_hasta" id="soat_hasta" placeholder="SOAT Hasta" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Hasta cuándo tiene la Tecnicomecanica?</label>
                                    <input type="date" name="tecnicomecanica_hasta" id="tecnicomecanica_hasta" placeholder="Técnicomecánica Hasta" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Qué Kilometraje tiene Actualmente el Vehiculo?</label>
                                    <input name="kilometraje_actual" id="kilometraje_actual" placeholder="Cuál es el Kilometraje Actualmente del Vehiculo?" class="form-control" required></input>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Observación</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="4" placeholder="Observación" class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="<?php echo $URL."admin/administracion/vehiculos/index.php";?>" class="btn btn-default btn-block">Cancelar</a>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" onclick="return confirm('¿Está seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Registrar Vehículo</button>
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