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
                                    oc.oc_resultante AS nombre_oc,
                                    oc1.proyecto AS nombre_proyecto,
                                    pop.observaciones AS nombre_observaciones
                                FROM items_op AS itop
                                INNER JOIN oc ON itop.id_oc = oc.id
                                INNER JOIN oc AS oc1 ON itop.proyecto = oc1.id
                                INNER JOIN pop ON itop.observaciones = pop.id
                                WHERE itop.id = :id_get
                                ");

$query_oc->bindParam(':id_get', $id_get);
$query_oc->execute();
$oces = $query_oc->fetchAll(PDO::FETCH_ASSOC);
foreach ($oces as $oc_item) {
    $id = $oc_item['id'];
    $id_oc = $oc_item['nombre_oc'];
    $id_op = $oc_item['id_op'];
    $id_pop = $oc_item['id_pop'];
    $id_item_pop = $oc_item['id_item_pop'];
    $fecha_recibido = $oc_item['fecha_recibido'];
    $estado = $oc_item['estado'];
    $tipo_estructura = $oc_item['tipo_estructura'];
    $cantidad = $oc_item['cantidad'];
    $proyecto = $oc_item['nombre_proyecto'];
    $observaciones = $oc_item['nombre_observaciones'];
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
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="fecha_creacion">Recepción</label>
                                    <input type="text" name="fecha_creacion" id="fecha_creacion" value="<?php echo $fecha_recibido; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="pop">OP</label>
                                    <input type="text" name="pop" id="pop" value= "<?php echo $id_op; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="oc">OC</label>
                                    <input type="text" name="oc" id="oc" value="<?php echo $id_oc; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="fecha_inicio">POP</label>
                                    <input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo $id_pop; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="estado_admon">Estado OP</label>
                                    <select name="uso_pan" id="uso_pan" class="form-control" required>
                                                <option value="">Seleccione un Estado</option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_admones = $pdo->prepare('SELECT id, estado_tpop FROM t_estado WHERE estado_tpop IS NOT NULL AND estado_tpop != ""');
                                                    $query_admones->execute();
                                                    $admon = $query_admones->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($admon as $admones) {
                                                        $acuerdo_admon = $admones['estado_tpop'];
                                                        $id_admon_loop = $admones['id'];

                                                        // Excluir la opción que ya está seleccionada
                                                        if ($id_admon_loop == $uso) {
                                                            continue; // Salta esta iteración y sigue con la siguiente
                                                        }

                                                ?>
                                                    <option value="<?php echo $id_admon_loop; ?>"><?php echo $acuerdo_admon;?></option>
                                                <?php
                                                    }
                                                ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="items_oc">Cantidad</label>
                                    <input type="text" name="items_oc" id="items_oc" value="<?php echo $cantidad; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="proyecto">Proyecto</label>
                                    <input type="text" name="proyecto" id="proyecto" value="<?php echo $proyecto; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="nom_cliente">Tipo Estructura</label>
                                    <input type="text" name="nom_cliente" id="nom_cliente" value="<?php echo $tipo_estructura; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="lugar_instalacion">MCI</label>
                                    <select name="uso_pan" id="uso_pan" class="form-control" required>
                                                <option value="">Seleccione un Estado</option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_admones = $pdo->prepare('SELECT id, estado_tpop FROM t_estado WHERE estado_tpop IS NOT NULL AND estado_tpop != ""');
                                                    $query_admones->execute();
                                                    $admon = $query_admones->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($admon as $admones) {
                                                        $acuerdo_admon = $admones['estado_tpop'];
                                                        $id_admon_loop = $admones['id'];

                                                        // Excluir la opción que ya está seleccionada
                                                        if ($id_admon_loop == $uso) {
                                                            continue; // Salta esta iteración y sigue con la siguiente
                                                        }

                                                ?>
                                                    <option value="<?php echo $id_admon_loop; ?>"><?php echo $acuerdo_admon;?></option>
                                                <?php
                                                    }
                                                ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="observacion">Ensamble</label>
                                    <select name="uso_pan" id="uso_pan" class="form-control" required>
                                                <option value="">Seleccione un Estado</option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_admones = $pdo->prepare('SELECT id, estado_tpop FROM t_estado WHERE estado_tpop IS NOT NULL AND estado_tpop != ""');
                                                    $query_admones->execute();
                                                    $admon = $query_admones->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($admon as $admones) {
                                                        $acuerdo_admon = $admones['estado_tpop'];
                                                        $id_admon_loop = $admones['id'];

                                                        // Excluir la opción que ya está seleccionada
                                                        if ($id_admon_loop == $uso) {
                                                            continue; // Salta esta iteración y sigue con la siguiente
                                                        }

                                                ?>
                                                    <option value="<?php echo $id_admon_loop; ?>"><?php echo $acuerdo_admon;?></option>
                                                <?php
                                                    }
                                                ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="observacion">Pruebas</label>
                                    <select name="uso_pan" id="uso_pan" class="form-control" required>
                                                <option value="">Seleccione un Estado</option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_admones = $pdo->prepare('SELECT id, estado_tpop FROM t_estado WHERE estado_tpop IS NOT NULL AND estado_tpop != ""');
                                                    $query_admones->execute();
                                                    $admon = $query_admones->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($admon as $admones) {
                                                        $acuerdo_admon = $admones['estado_tpop'];
                                                        $id_admon_loop = $admones['id'];

                                                        // Excluir la opción que ya está seleccionada
                                                        if ($id_admon_loop == $uso) {
                                                            continue; // Salta esta iteración y sigue con la siguiente
                                                        }

                                                ?>
                                                    <option value="<?php echo $id_admon_loop; ?>"><?php echo $acuerdo_admon;?></option>
                                                <?php
                                                    }
                                                ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="observacion">Embalaje</label>
                                    <select name="uso_pan" id="uso_pan" class="form-control" required>
                                                <option value="">Seleccione un Estado</option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_admones = $pdo->prepare('SELECT id, estado_tpop FROM t_estado WHERE estado_tpop IS NOT NULL AND estado_tpop != ""');
                                                    $query_admones->execute();
                                                    $admon = $query_admones->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($admon as $admones) {
                                                        $acuerdo_admon = $admones['estado_tpop'];
                                                        $id_admon_loop = $admones['id'];

                                                        // Excluir la opción que ya está seleccionada
                                                        if ($id_admon_loop == $uso) {
                                                            continue; // Salta esta iteración y sigue con la siguiente
                                                        }

                                                ?>
                                                    <option value="<?php echo $id_admon_loop; ?>"><?php echo $acuerdo_admon;?></option>
                                                <?php
                                                    }
                                                ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="observacion">Entregado</label>
                                    <select name="uso_pan" id="uso_pan" class="form-control" required>
                                                <option value="">Seleccione un Estado</option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_admones = $pdo->prepare('SELECT id, estado_tpop FROM t_estado WHERE estado_tpop IS NOT NULL AND estado_tpop != ""');
                                                    $query_admones->execute();
                                                    $admon = $query_admones->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($admon as $admones) {
                                                        $acuerdo_admon = $admones['estado_tpop'];
                                                        $id_admon_loop = $admones['id'];

                                                        // Excluir la opción que ya está seleccionada
                                                        if ($id_admon_loop == $uso) {
                                                            continue; // Salta esta iteración y sigue con la siguiente
                                                        }

                                                ?>
                                                    <option value="<?php echo $id_admon_loop; ?>"><?php echo $acuerdo_admon;?></option>
                                                <?php
                                                    }
                                                ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="telefono_contacto">Material</label>
                                    <select name="uso_pan" id="uso_pan" class="form-control" required>
                                                <option value="">Seleccione un Estado</option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_admones = $pdo->prepare('SELECT id, estado_tpop FROM t_estado WHERE estado_tpop IS NOT NULL AND estado_tpop != ""');
                                                    $query_admones->execute();
                                                    $admon = $query_admones->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($admon as $admones) {
                                                        $acuerdo_admon = $admones['estado_tpop'];
                                                        $id_admon_loop = $admones['id'];

                                                        // Excluir la opción que ya está seleccionada
                                                        if ($id_admon_loop == $uso) {
                                                            continue; // Salta esta iteración y sigue con la siguiente
                                                        }

                                                ?>
                                                    <option value="<?php echo $id_admon_loop; ?>"><?php echo $acuerdo_admon;?></option>
                                                <?php
                                                    }
                                                ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="ciudad">Suministros</label>
                                    <select name="uso_pan" id="uso_pan" class="form-control" required>
                                                <option value="">Seleccione un Estado</option>
                                                <?php
                                                    // Consulta los estados de la base de datos
                                                    $query_admones = $pdo->prepare('SELECT id, estado_tpop FROM t_estado WHERE estado_tpop IS NOT NULL AND estado_tpop != ""');
                                                    $query_admones->execute();
                                                    $admon = $query_admones->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($admon as $admones) {
                                                        $acuerdo_admon = $admones['estado_tpop'];
                                                        $id_admon_loop = $admones['id'];

                                                        // Excluir la opción que ya está seleccionada
                                                        if ($id_admon_loop == $uso) {
                                                            continue; // Salta esta iteración y sigue con la siguiente
                                                        }

                                                ?>
                                                    <option value="<?php echo $id_admon_loop; ?>"><?php echo $acuerdo_admon;?></option>
                                                <?php
                                                    }
                                                ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nom_contacto">Observaciones</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control" readonly><?php echo $observaciones; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="lugar_instalacion">CONEXIÓN</label>
                                    <input type="text" name="lugar_instalacion" id="lugar_instalacion" value="<?php echo $conexion; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="lugar_instalacion">CONFIGURACIÓN</label>
                                    <input type="text" name="lugar_instalacion" id="lugar_instalacion" value="<?php echo $configuracion; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_tratada">Fecha Tratamiento</label>
                                    <input type="text" name="fecha_tratada" id="fecha_tratada" value="<?php echo $fecha_tratada_oc; ?>" class="form-control" readonly>
                                    <input type="hidden" name="usuario_crea_oc" id="usuario_crea_oc" value="<?php echo $sesion_usuario['nombre']?>" class="form-control" readonly>
                                    <input type="hidden" name="id" id="id" value="<?php echo $id_get; ?>" class="form-control" readonly>
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

                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Item</th>
                                        <th>Proyecto</th>
                                        <th>Observaciones</th>
                                        <th>Tipo Estructura</th>
                                        <th><center>Procesado</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $query_tpop = $pdo->prepare("SELECT ito.*, pop.observaciones AS nombre_observaciones, oc.proyecto AS nombre_proyecto 
                                                                FROM items_op AS ito 
                                                                INNER JOIN pop ON ito.observaciones = pop.id 
                                                                INNER JOIN oc ON ito.proyecto = oc.id 
                                                                WHERE id_item_pop = :id_item_pop");
                                    $query_tpop->bindParam(':id_item_pop', $id_item_pop);
                                    $query_tpop->execute();
                                    $items = $query_tpop->fetchAll(PDO::FETCH_ASSOC);

                                    if (!empty($items)) :
                                        foreach ($items as $item) { 
                                    ?>
                                        <tr>
                                            <td><?php echo $item['contador_item_op'] . "/" . $item['cantidad']; ?></td>
                                            <td><?php echo $item['nombre_proyecto']; ?></td>
                                            <td><?php echo $item['nombre_observaciones']; ?></td>
                                            <td><?php echo $item['tipo_estructura']; ?></td>
                                            <td>
                                                <center>
                                                    <!-- Checkbox para habilitar -->
                                                    <input type="checkbox" class="procesar-checkbox" 
                                                        data-id="<?php echo $item['id']; ?>"
                                                        <?php echo ($item['procesar'] == 1) ? 'checked' : ''; ?>>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php } else : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No hay ítems asociados con este id_item_pop</td>
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
                                        <a href="<?php echo $URL."admin/operacion/pop/op"; ?>" class="btn btn-default btn-block">Cancelar</a>
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
document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".procesar-checkbox");

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            const itemId = this.getAttribute("data-id");
            const procesarValor = this.checked ? 1 : 0; // 1 si está marcado, 0 si se desmarca

            // Petición AJAX para actualizar el campo en la BD
            fetch("update_procesar.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${itemId}&procesar=${procesarValor}`
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Para depuración
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
</script>
