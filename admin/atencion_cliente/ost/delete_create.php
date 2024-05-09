<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT ost.*, tipo_servicio.servicio_ost AS nombre_servicio, estado.estadoost AS nombre_estado FROM ost JOIN tipo_servicio ON ost.tipo_servicio = tipo_servicio.id JOIN estado ON ost.estado = estado.id  WHERE ost.id = '$id_get'");

$query->execute();
$osts = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($osts as $ost){
    $id = $ost['id'];
    $id_ost = $ost['id_ost'];
    $fecha_ingreso = $ost['fecha_ost'];
    $medio_ingreso = $ost['medio_ingreso'];
    $ticket_externo = $ost['ticket_externo'];
    $servicio = $ost['nombre_servicio'];
    $id_producto = $ost['id_producto'];
    $falla = $ost['falla'];
    $observacion = $ost['observacion'];
    $cliente = $ost['cliente'];
    $ciudad = $ost['ciudad'];
    $proyecto = $ost['proyecto'];
    $estado = $ost['nombre_estado'];
    $persona_contacto = $ost['persona_contacto'];
    $medio_contacto = $ost['email_contacto'];

}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Eliminación de Órdenes</h1>

                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card">
                <div class="card-header" style="background-color: #d92005; color: #ffffff">
                    ¿DESEA ELIMINAR LA ORDEN?
                </div>
                <div class="card-body">
                    <form action="controller_delete_create.php" method="post">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">ID OST</label>
                                    <input type="text" name="idost" class="form-control" value="<?php echo $id_ost; ?>" placeholder="ID OST" readonly>
                                </div>
                            </div>
                            <div class="col-md-1.5">
                                <div class="form-group">
                                    <label for="">Fecha de Ingreso</label>
                                    <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value="<?php echo $fecha_ingreso; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Medio de Ingreso</label>
                                    <input type="text" name="medioingreso" class="form-control" value="<?php echo $medio_ingreso; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Ticket Externo</label>
                                    <input type="text" name="ticketexterno" class="form-control" value="<?php echo $ticket_externo; ?>" placeholder="Ticket Externo" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Tipo de Servicio</label>
                                    <input type="text" name="tiposervicio" class="form-control" value="<?php echo $servicio; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">ID Producto</label>
                                    <input type="text" name="idproducto" class="form-control" value="<?php echo $id_producto; ?>" placeholder="ID Producto" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <input type="text" name="idcliente" class="form-control" value="<?php echo $cliente; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Ciudad</label>
                                    <input type="text" name="idciudad" class="form-control" value="<?php echo $ciudad; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Proyecto</label>
                                    <input type="text" name="proyecto" class="form-control" value="<?php echo $proyecto; ?>" placeholder="Proyecto" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Estado</label>
                                    <input type="text" name="estado" class="form-control" value="<?php echo $estado; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Persona Contacto</label>
                                    <input type="text" name="personacontacto" class="form-control" value="<?php echo $persona_contacto; ?>" placeholder="Persona Contacto" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Medio de Contacto</label>
                                    <input type="text" name="medio_contacto" class="form-control" value="<?php echo $medio_contacto; ?>" placeholder="Medio de Contacto" readonly>
                                </div>
                            </div>                            

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Falla</label>
                                    <input type="text" name="falla" class="form-control" value="<?php echo $falla; ?>" placeholder="Fallas" readonly>
                                    <input type="text" name="id_usuario" value="<?php echo $id_get;?>" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Observación</label>
                                    <input type="text" name="observacion" class="form-control" value="<?php echo $observacion; ?>" placeholder="Observaciones" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/atencion_cliente/ost/index_create.php";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('¿Seguro de querer eliminar el Ticket?')" class="btn btn-danger btn-block">Eliminar STC</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>
