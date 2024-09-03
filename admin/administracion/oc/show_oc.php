<?php 
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$id_get = $_GET['id'];
$query_oc = $pdo->prepare("SELECT * FROM oc WHERE oc.id = :id");
$query_oc->bindParam(':id', $id_get, PDO::PARAM_INT);
$query_oc->execute();
$oces = $query_oc->fetchAll(PDO::FETCH_ASSOC);
foreach ($oces as $oc_item){
    $id = $oc_item['id'];
    $fecha_creacion = $oc_item['fecha_creacion'];
    $pc = $oc_item['pc'];


    $oc = $oc_item['oc'];
    
    $tipo_oc = $oc_item['tipo_oc'];
    $tipo_pc = $oc_item['tipo_pc'];
    $oc_cliente = $oc_item['oc_cliente'];
    
    $fecha_aprobacion = $oc_item['fecha_aprobacion'];
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
                    <h1 class="m-0">Visor de OC</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-info">
                <div class="card-header">
                    Detalle del Registro
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_creacion">Fecha Creacion</label>
                                <input type="text" name="fecha_creacion" id="fecha_creacion" value="<?php echo $oc_item['fecha_creacion']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="pc">PC</label>
                                <input type="text" name="pc" id="pc" value="<?php echo $oc_item['pc']; ?>"class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_aprobacion">Fecha Aprobación</label>
                                <input type="date" name="fecha_aprobacion" id="fecha_aprobacion" value="<?php echo $oc_item['fecha_aprobacion']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="id_oc">ID OC</label>
                                <input type="text" name="id_oc" id="id_oc" value="<?php echo $id; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario_crea_oc">Usuario Crea OC</label>
                                <input type="text" name="usuario_crea_oc" id="usuario_crea_oc" value="<?php echo $sesion_usuario['nombre']?>" class="form-control" readonly>
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
                                <label for="oc_cliente">OC Cliente</label>
                                <input type="text" name="oc_cliente" id="oc_cliente" value="<?php echo $oc_item['oc_cliente']; ?>" class="form-control" readonly>
                            </div>
                        </div>





                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estado_admon">Estado Admon</label>
                                <input type="text" name="estado_admon" id="estado_admon" value="<?php echo $oc_item['estado_admon']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="vendedor">Vendedor</label>
                                <input type="text" name="vendedor" id="vendedor" value="<?php echo $oc_item['vendedor']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estado_factura">Estado Factura</label>
                                <input type="text" name="estado_factura" id="estado_factura" value="<?php echo $oc_item['estado_factura']; ?>" class="form-control" readonly>
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
                                <label for="acuerdo_pago">Acuerdo Pago</label>
                                <input type="text" name="acuerdo_pago" id="acuerdo_pago" value="<?php echo $oc_item['acuerdo_pago']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nom_contacto_admin">Nom Contacto Admin</label>
                                <input type="text" name="nom_contacto_admin" id="nom_contacto_admin" value="<?php echo $oc_item['nom_contacto_admin']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefono_contacto">Teléfono Contacto</label>
                                <input type="text" name="telefono_contacto" id="telefono_contacto" value="<?php echo $oc_item['telefono_contacto']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nom_cliente">Nom Cliente</label>
                                <input type="text" name="nom_cliente" id="nom_cliente" value="<?php echo $oc_item['nom_cliente']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nom_contacto_cliente">Nom Contacto Cliente</label>
                                <input type="text" name="nom_contacto_cliente" id="nom_contacto_cliente" value="<?php echo $oc_item['nom_contacto_cliente']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="num_telefono">Num Teléfono</label>
                                <input type="text" name="num_telefono" id="num_telefono" value="<?php echo $oc_item['num_telefono']; ?>" class="form-control" readonly>
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
                                <label for="ciudad">Ciudad</label>
                                <input type="text" name="ciudad" id="ciudad" value="<?php echo $oc_item['ciudad']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="lugar_instalacion">Lugar Instalación</label>
                                <input type="text" name="lugar_instalacion" id="lugar_instalacion" value="<?php echo $oc_item['lugar_instalacion']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estado_logistico">Estado Logístico</label>
                                <input type="text" name="estado_logistico" id="estado_logistico" value="<?php echo $oc_item['estado_logistico']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dias_pactados">Días Pactados</label>
                                <input type="text" name="dias_pactados" id="dias_pactados" value="<?php echo $oc_item['dias_pactados']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="observacion">Observación</label>
                                <input type="text" name="observacion" id="observacion" value="<?php echo $oc_item['observacion']; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="num_factura">Num Factura</label>
                                <input type="text" name="num_factura" id="num_factura" value="<?php echo $oc_item['num_factura']; ?>" class="form-control" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="num_items">Num Ítems</label>
                                <input type="text" name="num_items" id="num_items" value="<?php echo $oc_item['num_items']; ?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Ítems asociados -->
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="m-0">Items de OC</h1>
                        </div>
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
                                        </tr>
                                    <?php } ?>
                                <?php else : ?>
                                    <div class="card card-info">
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

                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $URL."admin/administracion/oc/"; ?>" class="btn btn-default btn-block">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../../../layout/admin/parte2.php'); ?>