<?php

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

include('../../layout/admin/parte1.php');
include('controller_show.php');	

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">VISOR ID PANTALLAS</h1>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Fecha Creación</label>
                                                <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value="<?php echo $fecha; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">OP</label>
                                                <input type="text" name="op" id="op" class="form-control" value="<?php echo $op; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">POP</label>
                                                <input type="text" name="pop" id="pop" class="form-control" value="<?php echo $pop; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Cliente</label>
                                                <input type="text" name="cliente" id="cliente" class="form-control" value="<?php echo $cliente; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">ID Producto</label>
                                                <input type="text" name="idproducto" id="idproducto" class="form-control" value="<?php echo $id_producto; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">URL</label>
                                                <input type="text" name="url" id="url" class="form-control" value="<?php echo $url; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-0"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input type="text" name="usuario" class="form-control" value="<?php echo $sesion_nombre; ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Proyecto</label>
                                                <input type="text" name="proyecto" id="proyecto" class="form-control" value="<?php echo $proyecto; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Ciudad</label>
                                                <input type="text" name="ciudad" id="ciudad" class="form-control" value="<?php echo $ciudad; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Lugar Instalación</label>
                                                <input type="text" name="lugar_instalacion" id="lugar_instalacion" class="form-control" value="<?php echo $lugar_instalacion; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="archivo_adjunto">Archivo Adjunto</label>
                                    <br>
                                    <!-- Mostrar imagen del QR -->
                                    <?php if (!empty($imagen_qr)): ?>
                                        <img src="<?php echo $imagen_qr; ?>" alt="QR Code" style="width: 230; height: 250; border: 1px solid #ddd;">
                                    <?php else: ?>
                                        <p>No hay imagen del QR disponible.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="<?php echo $URL."admin/planta";?>" class="btn btn-default btn-block">Volver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../../layout/admin/parte2.php');?>