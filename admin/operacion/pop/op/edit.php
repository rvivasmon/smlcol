<?php 
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');


$fecha_tratada_oc = date('Y-m-d'); // Obtiene la fecha actual

$id_get = $_GET['id'];
$query_oc = $pdo->prepare("SELECT 
                                    itop.*,
                                    
                                FROM items_op AS itop
                                WHERE id = :id_get
                                ");

$query_oc->bindParam(':id_get', $id_get);
$query_oc->execute();
$oces = $query_oc->fetchAll(PDO::FETCH_ASSOC);
foreach ($oces as $oc_item) {
    $id = $oc_item['id'];
    $id_oc = $oc_item['id_oc'];
    $id_op = $oc_item['id_op'];
    $id_pop = $oc_item['id_pop'];
    $id_item_pop = $oc_item['id_item_pop'];
    $fecha_recibido = $oc_item['fecha_recibido'];
    $estado = $oc_item['estado'];
    $tipo_estructura = $oc_item['tipo_estructura'];
    $cantidad = $oc_item['cantidad'];
    $proyecto = $oc_item['proyecto'];
    $observaciones = $oc_item['observaciones'];
    $material = $oc_item['material'];
    $suministro = $oc_item['suministro'];
    $mci = $oc_item['mci'];
    $ensamble = $oc_item['ensamble'];
    $pruebas = $oc_item['pruebas'];
    $entregado = $oc_item['entregado'];
    $embalaje = $oc_item['embalaje'];
    $avance_op = $oc_item['avance_op'];
    $fecha_procesado = $oc_item['fecha_procesado'];
    $conexion = $oc_item['conexion'];
    $configuracion = $oc_item['configuracion'];
    $usuario = $oc_item['usuario'];
    $contador = $oc_item['contador'];
}

?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CREACIÓN DE OP</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-green">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit.php" method="post" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_creacion">Recepción</label>
                                    <input type="text" name="fecha_creacion" id="fecha_creacion" value="<?php echo $fecha_recibido; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="colo-md-1">
                                <div class="form-group">
                                    <label for="pop">OP</label>
                                    <input type="text" name="pop" id="pop" value= "<?php echo $id_op; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <label for="oc">OC</label>
                                <input type="text" name="oc" id="oc" value="<?php echo $id_oc; ?>" class="form-control" readonly>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_inicio">POP</label>
                                    <input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo $id_pop; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_fin">Item POP</label>
                                    <input type="text" name="fecha_fin" id="fecha_fin" value="<?php echo $id_item_pop; ?>" class="form-control" readonly>                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="estado_admon">Estado Admon</label>
                                    <input type="text" name="estado_admon" id="estado_admon" value="<?php echo $estado; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="items_oc">ITEMS</label>
                                    <input type="text" name="items_oc" id="items_oc" value="<?php echo $items_oc; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="proyecto">Proyecto</label>
                                    <input type="text" name="proyecto" id="proyecto" value="<?php echo $proyecto; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nom_cliente">Nom Cliente</label>
                                    <input type="text" name="nom_cliente" id="nom_cliente" value="<?php echo $cliente; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nom_contacto">Nombre Contacto</label>
                                    <input type="text" name="nom_contacto" id="nom_contacto" value="<?php echo $nom_contacto; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="telefono_contacto">Teléfono Contacto</label>
                                    <input type="text" name="telefono_contacto" id="telefono_contacto" value="<?php echo $num_telefono; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" name="ciudad" id="ciudad" value="<?php echo $nom_ciudad; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="lugar_instalacion">Lugar de Instalación</label>
                                    <input type="text" name="lugar_instalacion" id="lugar_instalacion" value="<?php echo $lugar_instalacion; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="observacion">Observaciones</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control" readonly><?php echo $observacion; ?></textarea>
                                    <input type="hidden" name="id1" id="id1" value="<?php echo $id_get; ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row" hidden>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="usuario_crea_oc">Usuario</label>
                                    <input type="text" name="usuario_crea_oc" id="usuario_crea_oc" value="<?php echo $sesion_usuario['nombre']?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_tratada">Fecha Tratamiento</label>
                                    <input type="text" name="fecha_tratada" id="fecha_tratada" value="<?php echo $fecha_tratada_oc; ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="id">ID Principal</label>
                                    <input type="text" name="id" id="id" value="<?php echo $id_get; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <br>

                        <!-- Ítems asociados -->
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Visor de Items</h1>
                            </div>
                        </div> 

                        <hr>

                        <div class="row mb-4" hidden>  <!-- Agrega margen inferior al botón -->
                            <div class="col-md-4">
                                <a type="button" href="<?php echo $URL; ?>admin/administracion/pop/create_items.php?id=<?php echo $oc_item['id']; ?>" class="btn btn-success">INSERTAR UN NUEVO ITEMS</a>
                            </div>
                        </div>
                        
                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Item</th>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Instalación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($items)) : ?>
                                        <?php foreach ($items as $item) { 
                                            // Consultamos si ya existe un registro en items_pop con tpop = 1
                                            $query_tpop = $pdo->prepare("SELECT id, tpop, item_oc FROM items_pop WHERE item_oc = :id_item AND id_pop = :id_pop");
                                            $query_tpop->bindParam(':id_item', $item['id_item']);
                                            $query_tpop->bindParam(':id_pop', $id_pop);
                                            $query_tpop->execute();
                                            $tpop_status = $query_tpop->fetch(PDO::FETCH_ASSOC);
                                            
                                            // Si hay un resultado, extraemos el id y verificamos tpop
                                            $id_items_pop = $tpop_status['id'] ?? null; // Guarda el ID en una variable
                                            $id_items_oc = $tpop_status['item_oc'] ?? null; // Guarda el ID en una variable

                                            // Verificamos si tpop está a 1
                                            $tpop_active = $tpop_status && $tpop_status['tpop'] == 3;
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $contador_pop++."/".$items_oc; ?>
                                                    <input type="hidden" name="id_item[]" id="id_item" value="<?php echo $contador_pop . "/" . $items_oc; ?>">
                                                <td>
                                                    <?php echo $item['descripcion']; ?>
                                                    <input type="hidden" name="descripcion[]" id="descripcion" value="<?php echo $item['descripcion']; ?>" class="form-control">
                                                </td>
                                                <td>
                                                    <?php echo $item['cantidad']; ?>
                                                    <input type="hidden" name="cantidad[]" id="cantidad" value="<?php echo $item['cantidad']; ?>" class="form-control">
                                                </td>
                                                <td>
                                                    <?php echo $item['instalacion']; ?>
                                                    <input type="hidden" name="instalacion[]" id="instalacion" value="<?php echo $item['instalacion']; ?>">
                                                </td>
                                                <td>
                                                    <center>
                                                        <!-- Mostrar el botón solo si tpop no está activo (es decir, tpop != 3) -->
                                                        <?php if (!$tpop_active): ?>
                                                            <a href="#" onclick="enviarPop(<?php echo $id_items_pop; ?>, <?php echo $id_items_oc; ?>)" class="btn btn-success btn-sm">GENERAR TPOP <i class="fas fa-pen"></i></a>
                                                        <?php else: ?>
                                                            <!-- Si tpop ya está activo, ocultar el botón -->
                                                            <span class="btn btn-success btn-sm" style="pointer-events: none; opacity: 0.5;">GENERAR TPOP <i class="fas fa-pen"></i></span>
                                                        <?php endif; ?>
                                                        <a href="controller_delete_items.php?id_pop=<?php echo $id_items_pop; ?>&id_oc=<?php echo $id_items_oc; ?>" onclick="return confirm('¿Seguro de querer eliminar el item?')" class="btn btn-danger btn-sm">ELIMINAR <i class="fas fa-trash"></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No hay ítems asociados a este OC</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="<?php echo $URL."admin/operacion/pop/"; ?>" class="btn btn-default btn-block">Cancelar</a>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" onclick="return confirm('¿Está seguro de haber diligenciado correctamente los datos?')" class="btn btn-success btn-block">Generar OP</button>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../../../../layout/admin/parte2.php'); ?>

<script>
function enviarPop(id_items_pop, id_items_oc) {
    // Captura el valor del campo 'pop'
    const popValue = document.getElementById('pop').value;

    // Captura el valor de pop_ppal desde el input oculto
    const popPpal = document.getElementById('id1').value;

    // Construye la URL con los parámetros necesarios
    const url = `tpop/create.php?id_pop=${id_items_pop}&id_oc=${id_items_oc}&pop=${encodeURIComponent(popValue)}&pop_ppal=${encodeURIComponent(popPpal)}`;

    // Redirige al usuario a la nueva URL
    window.location.href = url;
}
</script>
