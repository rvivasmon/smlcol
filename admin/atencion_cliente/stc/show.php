<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');
include('controller_show.php');

// Consulta para obtener los casos relacionados con el id_stc
$casosQuery = $pdo->prepare('SELECT id, id_ost FROM ost WHERE id_stc = :id');
$casosQuery->bindParam(':id', $id, PDO::PARAM_INT);
$casosQuery->execute();
$casos = $casosQuery->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Visor de Órdenes</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-info">
                <div class="card-header">
                    Detalle del Ticket
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Fecha de Ingreso</label>
                                            <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value= "<?php echo $fecha_ingreso; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">ID STC</label>
                                            <input class="form-control"  id="id_stc" name="id_stc" value="<?php echo $id_stc; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">CASOS</label>
                                            <input type="text" name="casos" id="casos" class="form-control" value="<?php echo $casos1; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Ingreso</label>
                                            <input class="form-control"  id="medio_ingreso" name="medio_ingreso" value="<?php echo $medio_ingreso; ?>" disabled>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Tipo de Servicio</label>
                                            <input name="tiposervicio" id="tiposervicio" class="form-control"  value="<?php echo $servicio; ?>" disabled>                                      
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">ID Producto</label>
                                            <input type="text" name="idproducto" class="form-control" value="<?php echo $id_producto; ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-0">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <input type="text" name="idstc" class="form-control" value="<?php echo $id_stc; ?>" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Cliente</label>
                                            <input name="idcliente" id="idcliente" class="form-control" value="<?php echo $cliente; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Ciudad</label>
                                            <input name="idciudad" id="idciudad" class="form-control" value="<?php echo $ciudad; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Proyecto</label>
                                            <input type="text" name="proyecto" class="form-control" value="<?php echo $proyecto; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Estado</label>
                                            <input name="idestado" id="idestado" class="form-control" value="<?php echo $estado; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Persona Contacto</label>
                                            <input type="text" name="personacontacto" class="form-control" value="<?php echo $persona_contacto; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Medio de Contacto</label>
                                            <input type="text" name="medio_contacto" class="form-control" value="<?php echo $medio_contacto; ?>" disabled>
                                        </div>
                                    </div>                            
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Falla</label>
                                            <textarea name="falla" id="" cols="30" rows="4" class="form-control" disabled><?php echo $falla; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Observación</label>
                                            <textarea name="observacion" id="" cols="30" rows="4" class="form-control" disabled><?php echo $observacion; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                        <label for="">Casos Asociados</label>
                                            <ul class="list-group">
                                                <?php foreach ($casos as $caso): ?>
                                                    <li class="list-group-item">
                                                        <a href="detalles_caso.php?id=<?php echo $caso['id']; ?>" target="_blank" onclick="window.open(this.href, 'Detalles del Caso', 'width=600,height=400'); return false;">
                                                            ID: <?php echo $caso['id_ost']; ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="archivo_adjunto">Archivo Adjunto</label>
                                        <center>
                                            <img src="<?php echo $URL."/img_uploads/".$evidencia;?>" width="200%" alt="">
                                        </center>

                                    </div>
                                </div>
                            </div>
                        </div>                      
                    </div>

                        <hr>

                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <a href="<?php echo $URL."admin/atencion_cliente/stc"; ?>" class="btn btn-default btn-block-secondary">Volver</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">                                
                                        <button type="button" class="btn btn-default" onclick="prevImage()">Anterior</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-default" onclick="nextImage()">Siguiente</button>
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

<?php include('../../../layout/admin/parte2.php');?>
