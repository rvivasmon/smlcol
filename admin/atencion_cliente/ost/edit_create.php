<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

?>

<?php include('../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT stc.*, tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_clientes, ciudad.ciudad AS nombre_ciudad, estado.estadostc AS nombre_estado FROM stc JOIN tipo_servicio ON stc.tipo_servicio = tipo_servicio.id JOIN estado ON stc.estado = estado.id JOIN clientes ON stc.cliente = clientes.id JOIN ciudad ON stc.ciudad = ciudad.id WHERE stc.id = :id_get");

$query->execute( [":id_get" => $id_get]);
$stcs = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($stcs as $stc){
    $id = $stc['id'];
    $id_stc = $stc['id_stc'];
    $fecha_ingreso = $stc['fecha_ingreso'];
    $medio_ingreso = $stc['medio_ingreso'];
    $ticket_externo = $stc['ticket_externo'];
    $nombre_servicio = $stc['nombre_servicio'];
    $id_producto = $stc['id_producto'];
    $falla = $stc['falla'];
    $observacion = $stc['observacion'];
    $nombre_cliente = $stc['nombre_clientes'];
    $nombre_ciudad = $stc['nombre_ciudad'];
    $proyecto = $stc['proyecto'];
    $nombre_estado = $stc['nombre_estado'];
    $persona_contacto = $stc['persona_contacto'];
    $medio_contacto = $stc['email_contacto'];
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tratamiento OST</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header" style="background-color: #00A000; color: #ffffff">
                    Modifique la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit_index.php" method="post">
                        
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">ID STC</label>
                                    <input type="text" name="id_stc" value="<?php echo $id_stc;?>" class="form-control" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_ingreso">Fecha Ingreso</label>
                                    <input type="date" name="fecha_ingreso" value="<?php echo $fecha_ingreso;?>" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Medio Ingreso</label>
                                    <input type="text" name="medio_ingreso" value="<?php echo $medio_ingreso;?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Ticket Externo</label>
                                    <input type="text" name="ticket_externo" value="<?php echo $ticket_externo;?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tipo Servicio</label>
                                    <select name="tipo_servicio" id="tipo_servicio" class="form-control" value="<?php echo $tipo_servicio; ?>" required>

                                        <?php
                                            $query_servicio = $pdo->prepare('SELECT * FROM tipo_servicio');
                                            $query_servicio->execute();
                                            $servicios = $query_servicio->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($servicios as $servicio) {
                                                $id_servicio = $servicio['id'];
                                                $nombre_servicio = $servicio['servicio_ost'];
                                                $selected = ($id_servicio == 4) ? 'selected' : '';
                                        ?>                                           
                                            <option value="<?php echo $id_servicio; ?>" <?php echo $selected; ?>><?php echo $nombre_servicio; ?></option>
                                        <?php
                                            }
                                        ?>
                                    
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">ID Producto</label>
                                    <input type="text" name="id_producto" value="<?php echo $id_producto;?>" class="form-control" placeholder="ID Producto" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Proyecto</label>
                                    <input type="text" name="proyecto" value="<?php echo $proyecto;?>" class="form-control" placeholder="Proyecto" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Ciudad</label>
                                    <input type="text" name="ciudad" value="<?php echo $nombre_ciudad; ?>" id="ciudad" class="form-control" readonly>                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <input type="text" name="clientes" value="<?php echo $nombre_cliente; ?>" id="clientes" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Persona Contacto</label>
                                    <input type="text" name="persona_contacto" value="<?php echo $persona_contacto; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Medio de Contacto</label>
                                    <input type="text" name="email_contacto" value="<?php echo $medio_contacto; ?>" class="form-control" readonly>
                                </div>
                            </div>                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Estado</label>
                                    <select name="estado" value="<?php echo $nombre_estado; ?>" id="estado" class="form-control" required>
                                    <?php
                                        $query_estado = $pdo->prepare('SELECT * FROM estado');
                                        $query_estado->execute();
                                        $estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($estados as $estado) {
                                            $id_estado = $estado['id'];
                                            $estado = $estado['estadostc'];
                                            ?>
                                            <option value="<?php echo $id_estado; ?>"><?php echo $estado; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Falla</label>
                                    <textarea name="falla" id="" cols="30" rows="4" class="form-control" readonly><?php echo $falla;?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Observación</label>
                                    <textarea name="observacion" id="" cols="30" rows="4" class="form-control" required><?php echo $observacion;?></textarea>
                                    <input type="text" name="id_usuario" value="<?php echo $id_get;?>" hidden>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="archivo_adjunto">Archivo Adjunto</label>
                                    <input type="file" name="archivo_adjunto[]" id="archivo_adjunto" class="form-control-file" multiple>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/atencion_cliente/ost";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-success btn-block">Activar OST</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>
