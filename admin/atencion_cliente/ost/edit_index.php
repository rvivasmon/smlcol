<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');


// Obtener el año y el mes actuales en formato YYYYMM
$anio_mes_ost = date('Ym');

// Obtener el último registro de la base de datos ordenado por contador de forma descendente
$query_ultimo_registro_ost = $pdo->prepare('SELECT * FROM ost ORDER BY anio_mes_ost DESC, contador_ost DESC LIMIT 1');
$query_ultimo_registro_ost->execute();
$ultimo_registro_ost = $query_ultimo_registro_ost->fetch(PDO::FETCH_ASSOC);

// Verificar si hay un último registro
if ($ultimo_registro_ost) {
    // Obtener el año y mes del último registro en formato YYYYMM
    $ultimo_anio_mes = $ultimo_registro_ost['anio_mes_ost'];

    // Si el mes y año del último registro son iguales al mes y año actuales, continuar con el contador
    if ($ultimo_anio_mes == $anio_mes_ost) {
        $contador_ost = $ultimo_registro_ost['contador_ost'] + 1;
    } else{

        // Inicializar el contador
        $contador_ost = 1;
    }

}

// Crear el ID OST utilizando el año_mes y el contador
$id_ost = 'OST-' . $anio_mes_ost . '-' . sprintf('%03d', $contador_ost);

// Fin del código para generar el ID OST
$id_get = $_GET['id'];

// Contar cuántas veces se repite el id_stc en la tabla 'ost'
$query_contador = $pdo->prepare("SELECT COUNT(*) as total FROM ost WHERE id_stc = :id_get");
$query_contador->execute([':id_get' => $id_get]);
$contador_result = $query_contador->fetch(PDO::FETCH_ASSOC);

// Incrementar el valor en 1
$casos_ost = $contador_result['total'] + 1;

$query = $pdo->prepare("SELECT stc.*, t_tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_clientes, t_ciudad.ciudad AS nombre_ciudad, t_estado.estadostc AS nombre_estado FROM stc JOIN t_tipo_servicio ON stc.tipo_servicio = t_tipo_servicio.id JOIN t_estado ON stc.estado = t_estado.id JOIN clientes ON stc.cliente = clientes.id JOIN t_ciudad ON stc.ciudad = t_ciudad.id WHERE stc.id = :id_get");

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

include('../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Asignación de OST</h1>
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
                                    <label for="">ID OST</label>
                                    <input type="text" name="id_ost" value="<?php echo $id_ost;?>" class="form-control" readonly>
                                    <input type="hidden" name="id_ost" value="<?php echo $id_ost; ?>">
                                    <input type="hidden" name="id_1" value="<?php echo $id; ?>">
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
                                    <input type="hidden" name="contador_ost" value="<?php echo $contador_ost; ?>">
                                    <input type="hidden" name="casos_ost" value="<?php echo $casos_ost; ?>">

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Ticket Externo</label>
                                    <input type="text" name="ticket_externo" value="<?php echo $ticket_externo;?>" class="form-control" readonly>
                                    <input type="hidden" name="anio_mes_ost" value="<?php echo $anio_mes_ost; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tipo Servicio</label>
                                    <select name="tipo_servicio" id="tipo_servicio" class="form-control" required>
                                        <option value="" disabled selected>Seleccione un Tipo de Servicio</option>
                                        <?php
                                            $query_servicio = $pdo->prepare('SELECT * FROM t_tipo_servicio ORDER BY servicio_ost ASC');
                                            $query_servicio->execute();
                                            $servicios = $query_servicio->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($servicios as $servicio) {
                                                $id_servicio = $servicio['id'];
                                                $nombre_servicio = $servicio['servicio_ost'];
                                        ?>                                           
                                            <option value="<?php echo $id_servicio; ?>"><?php echo $nombre_servicio; ?></option>
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
                                    <input type="text" name="ciudade" value="<?php echo $nombre_ciudad; ?>" id="ciudade" class="form-control" readonly>
                                    <!-- Campo oculto adicional para enviar el valor -->
                                    <input type="hidden" name="ciudad1" value="<?php echo $nombre_ciudad; ?>">                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <input type="text" name="Clientes" value="<?php echo $nombre_cliente; ?>" id="Clientes" class="form-control" readonly>
                                    <!-- Campo oculto adicional para enviar el valor -->
                                    <input type="hidden" name="cliente1" value="<?php echo $nombre_cliente; ?>">
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
                                    <select name="estado" value="" id="estado" class="form-control" required>
                                    <option value="" disabled selected>Seleccione un Estado</option>
                                    <?php
                                        $query_estado = $pdo->prepare('SELECT * FROM t_estado WHERE id = "2"');
                                        $query_estado->execute();
                                        $estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($estados as $estado) {
                                            $id_estado = $estado['id'];
                                            $estado = $estado['estadoost'];
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
