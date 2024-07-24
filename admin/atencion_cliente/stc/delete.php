<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

?>

<?php include('../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT stc.*, t_tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_cliente, t_ciudad.ciudad AS nombre_ciudad, t_estado.estadostc AS nombre_estado FROM stc JOIN t_tipo_servicio ON stc.tipo_servicio = t_tipo_servicio.id JOIN clientes ON stc.cliente = clientes.id JOIN t_ciudad ON stc.ciudad = t_ciudad.id JOIN t_estado ON stc.estado = t_estado.id  WHERE stc.id = '$id_get'");

$query->execute();
$stcs = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($stcs as $stc){
    $id = $stc['id'];
    $id_stc = $stc['id_stc'];
    $fecha_ingreso = $stc['fecha_ingreso'];
    $medio_ingreso = $stc['medio_ingreso'];
    $ticket_externo = $stc['ticket_externo'];
    $servicio = $stc['nombre_servicio'];
    $id_producto = $stc['id_producto'];
    $falla = $stc['falla'];
    $observacion = $stc['observacion'];
    $cliente = $stc['nombre_cliente'];
    $ciudad = $stc['nombre_ciudad'];
    $proyecto = $stc['proyecto'];
    $estado = $stc['nombre_estado'];
    $persona_contacto = $stc['persona_contacto'];
    $medio_contacto = $stc['email_contacto'];

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
                    <form action="controller_delete.php" method="post">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">ID STC</label>
                                    <input type="text" name="idstc" class="form-control" value="<?php echo $id_stc; ?>" placeholder="ID STC" readonly>
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
                                    <input type="text" name="medioingreso" class="form-control" value="<?php echo $medio_ingreso; ?>" placeholder="Medio de Ingreso" readonly>
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
                                    <select name="tiposervicio" id="tiposervicio" class="form-control" readonly>
                                        <?php 
                                        $query_servicio = $pdo->prepare('SELECT * FROM t_tipo_servicio');
                                        $query_servicio->execute();
                                        $servicios = $query_servicio->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($servicios as $servicio) {
                                            $id_servicio = $servicio['id'];
                                            $servicio = $servicio['servicio_stc'];
                                            ?>
                                            <option value="<?php echo $id_servicio; ?>"><?php echo $servicio; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
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
                                    <select name="idcliente" id="idcliente" class="form-control" readonly>
                                        <?php 
                                        $query_cliente = $pdo->prepare('SELECT * FROM clientes');
                                        $query_cliente->execute();
                                        $clientes = $query_cliente->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($clientes as $cliente) {
                                            $id_cliente = $cliente['id'];
                                            $cliente = $cliente['nombre_comercial'];
                                            ?>
                                            <option value="<?php echo $id_cliente; ?>"><?php echo $cliente; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Ciudad</label>
                                    <select name="idciudad" id="idciudad" class="form-control" readonly>
                                        <?php 
                                        $query_ciudad = $pdo->prepare('SELECT * FROM t_ciudad');
                                        $query_ciudad->execute();
                                        $ciudades = $query_ciudad->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($ciudades as $ciudad) {
                                            $id_ciudad = $ciudad['id'];
                                            $ciudad = $ciudad['ciudad'];
                                            ?>
                                            <option value="<?php echo $id_ciudad; ?>"><?php echo $ciudad; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
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
                                    <select name="idestado" id="idestado" class="form-control" readonly>
                                        <?php 
                                        $query_estado = $pdo->prepare('SELECT * FROM t_estado');
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
                                <a href="<?php echo $URL."admin/atencion_cliente/stc";?>" class="btn btn-default btn-block">Cancelar</a>
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
