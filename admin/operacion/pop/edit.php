<?php 
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');


$fecha_tratada_oc = date('Y-m-d'); // Obtiene la fecha actual

$id_get = $_GET['id'];
$query_oc = $pdo->prepare("SELECT pop.*, te.estado_admon, cl.nombre_comercial AS nombre_cliente, tci.ciudad AS nombre_ciudad, oc.oc_resultante AS nombre_id_oc FROM pop LEFT JOIN t_estado AS te ON pop.estado_admon = te.id LEFT JOIN clientes AS cl ON pop.cliente = cl.id LEFT JOIN t_ciudad AS tci ON pop.ciudad = tci.id LEFT JOIN oc ON pop.id_oc = oc.id WHERE pop.id = :id");

$query_oc->bindParam(':id', $id_get, PDO::PARAM_INT);
$query_oc->execute();
$oces = $query_oc->fetchAll(PDO::FETCH_ASSOC);
foreach ($oces as $oc_item) {
    $id_pop = $oc_item['id'];
    $fecha_recepcion = $oc_item['fecha_recibido'];
    $oc = $oc_item['oc'];
    $id_oc = $oc_item['id_oc'];
    $nombre_id_oc = $oc_item['nombre_id_oc'];
    $fecha_inicio = $oc_item['fecha_inicio'];
    $fecha_fin = $oc_item['fecha_fin'];
    $estado_admon = $oc_item['estado_admon'];
    $proyecto = $oc_item['nombre_proyecto'];
    $nom_contacto = $oc_item['contacto'];
    $lugar_instalacion = $oc_item['lugar_instalacion'];
    $items_oc = $oc_item['items_oc'];
    $cliente = $oc_item['nombre_cliente'];
    $num_telefono = $oc_item['telefono'];
    $nom_ciudad = $oc_item['nombre_ciudad'];
    $observacion = $oc_item['observaciones'];
}

// Consultar ítems asociados desde la tabla 'items_oc'
$query_items = $pdo->prepare("SELECT * FROM items_oc WHERE id_oc = :id_oc");
$query_items->bindParam(':id_oc', $id_oc, PDO::PARAM_INT);
$query_items->execute();
$items = $query_items->fetchAll(PDO::FETCH_ASSOC);

// Variable para manejar el contador dinámico
$current_id_pop = null; // Para rastrear cambios en id_pop
$contador_pop = 1;      // Inicializar el contador

// Insertar los ítems en la tabla 'items_pop'
foreach ($items as $item) {
    $id_item = isset($item['id_item']) ? $item['id_item'] : null;

    if ($id_item === null) {
        echo "Error: El campo 'id_item' no puede ser nulo.";
        continue; // Saltar al siguiente ítem si falta 'id_item'
    }

    // Si el id_pop cambia, reiniciar el contador
    if ($current_id_pop !== $id_pop) {
        $contador_pop = 1; // Reiniciar el contador
        $current_id_pop = $id_pop; // Actualizar el id_pop actual
    }

    // Verificar si el registro ya existe en la tabla 'items_pop'
    $query_check = $pdo->prepare("
        SELECT * FROM items_pop 
        WHERE id_oc = :id_oc 
        AND item_oc = :id_item
    ");
    $query_check->bindParam(':id_oc', $item['id_oc'], PDO::PARAM_INT);
    $query_check->bindParam(':id_item', $id_item, PDO::PARAM_INT);
    $query_check->execute();
    $exists = $query_check->fetch(PDO::FETCH_ASSOC);

    // Si el registro no existe, insertar en la tabla 'items_pop'
    if (!$exists) {
        $query_insert = $pdo->prepare("
            INSERT INTO items_pop (id_oc, item_oc, id_pop, instalacion, descripcion, cantidad, contador) 
            VALUES (:id_oc, :id_item, :id_pop, :instalacion, :descripcion_item, :cantidad, :contador)
        ");
        $query_insert->bindParam(':id_oc', $item['id_oc'], PDO::PARAM_INT);
        $query_insert->bindParam(':id_item', $id_item, PDO::PARAM_INT);
        $query_insert->bindParam(':id_pop', $id_pop, PDO::PARAM_INT);
        $query_insert->bindParam(':instalacion', $item['instalacion'], PDO::PARAM_STR);
        $query_insert->bindParam(':descripcion_item', $item['descripcion'], PDO::PARAM_STR);
        $query_insert->bindParam(':cantidad', $item['cantidad'], PDO::PARAM_INT);
        $query_insert->bindParam(':contador', $contador_pop, PDO::PARAM_INT);
        $query_insert->execute();

        $contador_pop++; // Incrementar el contador
    }
}

$query_contador = $pdo->prepare("SELECT MAX(contador) AS ultimo_contador FROM pop");
$query_contador->execute();
$resultado = $query_contador->fetch(PDO::FETCH_ASSOC);

// Verificar si se obtuvo un valor y sumarle 1
$contador_ppal = isset($resultado['ultimo_contador']) ? $resultado['ultimo_contador'] : 0;

?>


<div class="content-wrapper">
    <div class="content-header">
    <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CREACIÓN DE POP</h1>
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
                                    <input type="text" name="fecha_creacion" id="fecha_creacion" value="<?php echo $fecha_recepcion; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="colo-md-1">
                                <div class="form-group">
                                    <label for="pop">POP</label>
                                    <input type="text" name="pop" id="pop" value= "<?php echo "POP".$contador_ppal; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <label for="oc">OC</label>
                                <input type="text" name="oc" id="oc" value="<?php echo $nombre_id_oc; ?>" class="form-control" readonly>
                            </div>

                            <div class="col-md-0" hidden>
                                <div class="form-group">
                                    <label for="id_oc">ID OC</label>
                                    <input type="text" name="id_oc" id="id_oc" value="<?php echo $id_oc; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha Inicio</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?php echo $fecha_inicio; ?>" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_fin">Fecha Fin</label>
                                    <input type="date" name="fecha_fin" id="fecha_fin" value="<?php echo $fecha_fin; ?>" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="estado_admon">Estado Admon</label>
                                    <input type="text" name="estado_admon" id="estado_admon" value="<?php echo $estado_admon; ?>" class="form-control" readonly>
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
                            <div class="col-md-2">
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

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="nom_contacto">Nombre Contacto</label>
                                    <input type="text" name="nom_contacto" id="nom_contacto" value="<?php echo $nom_contacto; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="telefono_contacto">Teléfono Contacto</label>
                                    <input type="text" name="telefono_contacto" id="telefono_contacto" value="<?php echo $num_telefono; ?>" class="form-control" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" name="ciudad" id="ciudad" value="<?php echo $nom_ciudad; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lugar_instalacion">Lugar de Instalación</label>
                                    <input type="text" name="lugar_instalacion" id="lugar_instalacion" value="<?php echo $lugar_instalacion; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="observacion">Observaciones</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control" readonly><?php echo $observacion; ?></textarea>
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
                                        <?php foreach ($items as $item) { ?>
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
                                                        <a href="edit_items.php?id_item=<?php echo $item['id_item']; ?>&id=<?php echo $id_get; ?>" class="btn btn-success btn-sm">EDITAR <i class="fas fa-pen"></i></a>
                                                        <a href="controller_delete_items.php?id_item=<?php echo $item['id_item']; ?>&id=<?php echo $id_get; ?>" onclick="return confirm('¿Seguro de querer eliminar el item?')" class="btn btn-danger btn-sm">ELIMINAR <i class="fas fa-trash"></i></a>
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

<?php include('../../../layout/admin/parte2.php'); ?>