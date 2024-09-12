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
    $fecha_creacion = $oc_item['fecha_creacion'];
    $pc = $oc_item['id_pc'];
    $pc_combinado = $oc_item['pc'] . '-' . $oc_item['tipo_pc'];
    $oc = $oc_item['oc'];
    $tipo_oc = $oc_item['tipo_oc'];
    $oc_cliente = $oc_item['oc_cliente'];
    $oc_final = $oc_item['oc_resultante'];
    $fecha_aprobacion = $oc_item['fecha_aprobacion'];
    $estado_admon = $oc_item['estado_admon'];
    $vendedor = $oc_item['vendedor'];
    $estado_factura = $oc_item['estado_factura'];
    $factura_fecha = $oc_item['factura_fecha'];
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
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_tratar_oc.php" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="fecha_creacion">Creacion</label>
                                <input type="text" name="fecha_creacion" id="fecha_creacion" value="<?php echo $oc_item['fecha_creacion']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="id_pc">ID PC</label>
                                <input type="text" name="id_pc" id="id_pc" value="<?php echo $oc_item['id_pc']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="pc">PC</label>
                                <input type="text" name="pc" id="pc" value="<?php echo $pc_combinado; ?>"class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="id_oc">ID OC</label>
                                <input type="text" name="id_oc" id="id_oc" value="<?php echo $oc_final; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="oc_cliente">OC Cliente</label>
                                <input type="text" name="oc_cliente" id="oc_cliente" value="<?php echo $oc_item['oc_cliente']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_aprobacion">Fecha Aprobación</label>
                                <input type="date" name="fecha_aprobacion" id="fecha_aprobacion" value="<?php echo $oc_item['fecha_aprobacion']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="estado_admon">Estado Admon</label>
                                <input type="text" name="estado_admon" id="estado_admon" value="<?php echo $estado_admon ?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="factura_fecha"> Fecha Factura</label>
                                <input type="text" name="factura_fecha" id="factura_fecha" value="<?php echo $oc_item['factura_fecha']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="num_factura">Num Factura</label>
                                <input type="text" name="num_factura" id="num_factura" value="<?php echo $oc_item['num_factura']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="estado_factura">Estado Factura</label>
                                <input type="text" name="estado_factura" id="estado_factura" value="<?php echo $oc_item['estado_factura']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="acuerdo_pago">Acuerdo Pago</label>
                                <input type="text" name="acuerdo_pago" id="acuerdo_pago" value="<?php echo $oc_item['acuerdo_pago']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="dias_pactados">Días Pactados de Entrega</label>
                                <input type="text" name="dias_pactados" id="dias_pactados" value="<?php echo $oc_item['dias_pactados']; ?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nom_cliente">Nom Cliente</label>
                                <input type="text" name="nom_cliente" id="nom_cliente" value="<?php echo $oc_item['nom_cliente']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nom_contacto_admin">Nom Contacto Admin</label>
                                <input type="text" name="nom_contacto_admin" id="nom_contacto_admin" value="<?php echo $oc_item['nom_contacto_admin']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="telefono_contacto">Teléfono Contacto</label>
                                <input type="text" name="telefono_contacto" id="telefono_contacto" value="<?php echo $oc_item['telefono_contacto']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nom_contacto_cliente">Nom Contacto Cliente</label>
                                <input type="text" name="nom_contacto_cliente" id="nom_contacto_cliente" value="<?php echo $oc_item['nom_contacto_cliente']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="num_telefono">Num Teléfono</label>
                                <input type="text" name="num_telefono" id="num_telefono" value="<?php echo $oc_item['num_telefono']; ?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="num_items">Num Ítems</label>
                                <input type="text" name="num_items" id="num_items" value="<?php echo $oc_item['num_items']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="proyecto">Proyecto</label>
                                <input type="text" name="proyecto" id="proyecto" value="<?php echo $oc_item['proyecto']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ciudad">Ciudad</label>
                                <input type="text" name="ciudad" id="ciudad" value="<?php echo $oc_item['ciudad']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="lugar_instalacion">Lugar Instalación</label>
                                <input type="text" name="lugar_instalacion" id="lugar_instalacion" value="<?php echo $oc_item['lugar_instalacion']; ?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="estado_logistico">Estado Logístico</label>
                                <input type="text" name="estado_logistico" id="estado_logistico" value="<?php echo $oc_item['estado_logistico']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="vendedor">Vendedor</label>
                                <input type="text" name="vendedor" id="vendedor" value="<?php echo $vendedor ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="observacion">Observación</label>
                                <input type="text" name="observacion" id="observacion" value="<?php echo $oc_item['observacion']; ?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="usuario_crea_oc">Usuario</label>
                                <input type="text" name="usuario_crea_oc" id="usuario_crea_oc" value="<?php echo $sesion_usuario['nombre']?>" class="form-control" readonly>
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

                        <div class="row mb-4">  <!-- Agrega margen inferior al botón -->
                            <div class="col-md-4">
                                <a type="button" href="<?php echo $URL; ?>admin/nueva_tarea_8-7-24/create_items_oc.php" class="btn btn-primary">INSERTAR UN NUEVO ITEMS</a>
                            </div>
                        </div>
                        
                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th readonly>ID Item</th>
                                        <th readonly>Descripción</th>
                                        <th readonly>Cantidad</th>
                                        <th readonly>Instalacion</th>
                                        <th readonly>Acciones</th>
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
                        </div>

                        <hr>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="<?php echo $URL."admin/administracion/oc/"; ?>" class="btn btn-secondary btn-block">Cancelar</a>
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