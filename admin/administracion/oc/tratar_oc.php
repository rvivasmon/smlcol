<?php 
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');


$fecha_tratada_oc =  date('Y-m-d'); //Obtiene la fecha actual

$id_get = $_GET['id'];
$query_oc = $pdo->prepare("SELECT * FROM oc WHERE oc.id = :id");
$query_oc->bindParam(':id', $id_get, PDO::PARAM_INT);
$query_oc->execute();
$oces = $query_oc->fetchAll(PDO::FETCH_ASSOC);
foreach ($oces as $oc_item){
    $id = $oc_item['id'];
    $oc = $oc_item['oc'];
    $pc = $oc_item['pc'];
    $tipo_oc = $oc_item['tipo_oc'];
    $tipo_pc = $oc_item['tipo_pc'];
    $oc_cliente = $oc_item['oc_cliente'];
    $fecha_creacion = $oc_item['fecha_creacion'];
    $fecha_aprovacion = $oc_item['fecha_aprovacion'];
    $estado_admon = $oc_item['estado_admon'];
    $vendedor = $oc_item['vendedor'];
    $estado_factura = $oc_item['estado_factura'];
    $num_factura_fecha = $oc_item['num_factura_fecha'];
    $acuerdo_pago = $oc_item['acuerdo_pago'];
    $nom_contacto_admin = $oc_item['nom_contacto_admin'];
    $telefono_contacto = $oc_item['telefono_contacto'];
    $nom_cliente = $oc_item['nom_cliente'];
    $nom_contacto_cliente = $oc_item['nom_contacto_cliente'];
    $num_telefono = $oc_item['num_telefono'];
    $proyecto = $oc_item['proyecto'];
    $ciudad = $oc_item['ciudad'];
    $lugar_instalacion = $oc_item['lugar_instalacion'];
    $estado_logistico = $oc_item['estado_logistico'];
    $dias_pactados = $oc_item['dias_pactados'];
    $observacion = $oc_item['observacion'];
    $num_factura = $oc_item['num_factura'];
    $num_items = $oc_item['num_items'];
}

// Consultar ítems asociados
$query_items = $pdo->prepare("SELECT * FROM tabla_items_oc WHERE id_oc = :id_oc");
$query_items->bindParam(':id_oc', $id_get, PDO::PARAM_INT);
$query_items->execute();
$items = $query_items->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tratar OC</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-green">
            <div class="card-header">
                    <a href="#" class="d-block"><?php echo $sesion_usuario['nombre']?></a>
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_tratar_oc.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="id_oc">ID OC</label>
                                <input type="text" name="id_oc" id="id_oc" value="<?php echo $id; ?>" class="form-control" readonly>
                        </div>
                        </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="usuario_trata_oc">Usuario Trata OC</label>
                                    <input type="text" name="usuario_trata_oc" id="usuario_trata_oc" value="<?php echo $sesion_usuario['nombre']; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="text" name="usuario_crea_oc" id="usuario_crea_oc" value="<?php echo $sesion_usuario['nombre']; ?>" class="form-control" hidden>
                                </div>
                            </div>
                            <div class="col-md-0">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input name="fecha_tratada_oc" id="fecha_tratada_oc" value="<?php echo $fecha_tratada_oc?>" class="form-control" hidden>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="oc">OC</label>
                                    <input type="text" name="oc_resultante" id="oc_resultante" value="<?php echo $oc_item['oc']; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tipo_oc">Tipo OC</label>
                                    <input type="text" name="tipo_oc" id="tipo_oc" value="<?php echo $oc_item['tipo_oc']; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tipo_pc">Tipo Pc</label>
                                    <input type="text" name="tipo_pc" id="tipo_pc" value="<?php echo $oc_item['tipo_pc']; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pc">PC</label>
                                    <input type="text" name="pc" id="pc" value="<?php echo $oc_item['pc']; ?>"class="form-control " readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_creacion">Fecha Creacion</label>
                                    <input type="text" name="fecha_creacion" id="fecha_creacion" value="<?php echo $oc_item['fecha_creacion']; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_aprovacion">Fecha Aprobación</label>
                                    <input type="date" name="fecha_aprovacion" id="fecha_aprovacion" value="<?php echo $oc_item['fecha_aprovacion']; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="num_factura_fecha">Num Factura Fecha</label>
                                    <input type="text" name="num_factura_fecha" id="num_factura_fecha" value="<?php echo $oc_item['num_factura_fecha']; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proyecto">Proyecto</label>
                                    <input type="text" name="proyecto" id="proyecto" value="<?php echo $oc_item['proyecto']; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="num_items">Num Ítems</label>
                                    <input type="text" name="num_items" id="num_items" value="<?php echo $oc_item['num_items']; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="oc_cliente">OC Cliente</label>
                                    <input type="text" name="oc_cliente" id="oc_cliente" value="<?php echo $oc_item['oc_cliente']; ?>" class="form-control">
                                </div>  
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado_admon">Estado Admon</label>
                                    <input type="text" name="estado_admon" id="estado_admon" value="<?php echo $oc_item['estado_admon']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vendedor">Vendedor</label>
                                    <input type="text" name="vendedor" id="vendedor" value="<?php echo $oc_item['vendedor']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado_factura">Estado Factura</label>
                                    <input type="text" name="estado_factura" id="estado_factura" value="<?php echo $oc_item['estado_factura']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Acuerdo Pago</label>
                                    <select name="acuerdo_pago" id="acuerdo_pago" value="<?php echo $oc_item['acuerdo_pago']; ?>" class="form-control" required>
                                        <?php 
                                            $query_prefijos = $pdo->prepare('SELECT acuerdo_pago FROM oc_prefijos LIMIT 3');
                                            $query_prefijos->execute();
                                            $prefi = $query_prefijos->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($prefi as $prefijos) {
                                                $acuerdo_pago = $prefijos['acuerdo_pago'];
                                                echo "<option value='$acuerdo_pago '>$acuerdo_pago</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nom_contacto_admin">Nom Contacto Admin</label>
                                    <input type="text" name="nom_contacto_admin" id="nom_contacto_admin" value="<?php echo $oc_item['nom_contacto_admin']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telefono_contacto">Teléfono Contacto</label>
                                    <input type="text" name="telefono_contacto" id="telefono_contacto" value="<?php echo $oc_item['telefono_contacto']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nom_cliente">Nom Cliente</label>
                                    <input type="text" name="nom_cliente" id="nom_cliente" value="<?php echo $oc_item['nom_cliente']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nom_contacto_cliente">Nom Contacto Cliente</label>
                                    <input type="text" name="nom_contacto_cliente" id="nom_contacto_cliente" value="<?php echo $oc_item['nom_contacto_cliente']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="num_telefono">Num Teléfono</label>
                                    <input type="text" name="num_telefono" id="num_telefono" value="<?php echo $oc_item['num_telefono']; ?>" class="form-control">
                                </div>
                            </div>

                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" name="ciudad" id="ciudad" value="<?php echo $oc_item['ciudad']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lugar_instalacion">Lugar Instalación</label>
                                    <input type="text" name="lugar_instalacion" id="lugar_instalacion" value="<?php echo $oc_item['lugar_instalacion']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado_logistico">Estado Logístico</label>
                                    <input type="text" name="estado_logistico" id="estado_logistico" value="<?php echo $oc_item['estado_logistico']; ?>" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dias_pactados">Días Pactados</label>
                                    <input type="number" name="dias_pactados" id="dias_pactados" value="<?php echo $oc_item['dias_pactados']; ?>" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <input type="text" name="observacion" id="observacion" value="<?php echo $oc_item['observacion']; ?>" class="form-control">
                                </div>
                            </div>

                            
                        </div>
                        <!-- Ítems asociados -->
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Visor de Items</h1>
                            </div>
                        </div> 

                        <hr>

                        <div class="col-md-4">
                            <a type="button" href="<?php echo $URL; ?>admin/nueva_tarea_8-7-24/create_items_oc.php" class="btn btn-primary">INSERTAR UN NUEVO ITEMS</a>
                        </div>
                        
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th readonly>ID Item</th>
                                    <th readonly>Descripción</th>
                                    <th readonly>Cantidad</th>
                                    <th readonly>Instalacion</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php if (!empty($items)) : ?>
                                        <?php foreach ($items as $item) { ?>
                                            <tr>
                                                <td><?php echo $item['id_item']; ?></td>
                                                <td><?php echo $item['descripcion']; ?></td>
                                                <td><?php echo $item['cantidad']; ?></td>
                                                <td><?php echo $item['instalacion']; ?></td>
                                                <td>
                                                    <center>  
                                                        <a href="edit_items_oc.php?id=<?php echo $id;?>" class="btn btn-success btn-sm">EDITAR<i class="fas fa-pen"></i></a>
                                                        <a href="controller_delete_items_oc.php?id_item=<?php echo $item['id_item']; ?>&id=<?php echo $id_get; ?>" onclick="return confirm('¿Seguro de querer eliminar el item?')" class="btn btn-danger btn-sm">ELIMINAR <i class="fas fa-trash"></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php else : ?>
                                        <div class="card card-green">
                                            <div class="card-header">
                                                <center>
                                                    <label>NO HAY ITEMS ASOCIADOS A ESTE OC</label>
                                                </center>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </tbody>
                        </table>
                        <hr>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="<?php echo $URL."admin/nueva_tarea_8-7-24/index_oc.php"; ?>" class="btn btn-default btn-block">Cancelar</a>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" onclick="return confirm('¿Está seguro de haber diligenciado correctamente los datos?')" class="btn btn-success btn-block">Generar POP</button>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('../../../layout/admin/parte2.php'); ?>