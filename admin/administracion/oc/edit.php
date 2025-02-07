<?php 
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');


$fecha_tratada_oc =  date('Y-m-d'); //Obtiene la fecha actual

$id_get = $_GET['id'];
$query_oc = $pdo->prepare("SELECT oc.*, cl.nombre_comercial AS nombre_cliente, tes.estado_admon AS nombre_admon, usu.nombre AS nombre_vendedor, tes1.estado_factura AS nombre_factura, ocp.acuerdo_pago AS nombre_acuerdo, tci.ciudad AS nombre_ciudad FROM oc LEFT JOIN clientes AS cl ON oc.nom_cliente = cl.id LEFT JOIN t_estado AS tes ON oc.estado_admon = tes.id LEFT JOIN usuarios AS usu ON oc.vendedor = usu.id LEFT JOIN t_estado AS tes1 ON oc.estado_factura = tes1.id LEFT JOIN oc_prefijos AS ocp ON oc.acuerdo_pago = ocp.id LEFT JOIN t_ciudad AS tci ON oc.ciudad = tci.id WHERE oc.id = :id");
$query_oc->bindParam(':id', $id_get, PDO::PARAM_INT);
$query_oc->execute();
$oces = $query_oc->fetchAll(PDO::FETCH_ASSOC);
foreach ($oces as $oc_item9){
    $id = $oc_item9['id'];
    $fecha_creacion = $oc_item9['fecha_creacion'];
    $pc = $oc_item9['id_pc'];
    $pc_combinado = $oc_item9['pc'] . '-' . $oc_item9['tipo_pc'];
    $oc = $oc_item9['oc'];
    $tipo_oc = $oc_item9['tipo_oc'];
    $oc_cliente = $oc_item9['oc_cliente'];
    $oc_final = $oc_item9['oc_resultante'];
    $fecha_aprobacion = $oc_item9['fecha_aprobacion'];
    $estado_admon = $oc_item9['nombre_admon'];
    $vendedor = $oc_item9['nombre_vendedor'];
    $cliente_oc = $oc_item9['nom_cliente'];
    $estado_administracion = $oc_item9['estado_admon'];
    $nombre_vendedor_oc = $oc_item9['vendedor'];
    $estado_acuerdo_pago = $oc_item9['acuerdo_pago'];
    $id_estado_factura = $oc_item9['estado_factura'];
    $id_estado_ciudad = $oc_item9['ciudad'];
    $estado_factura = $oc_item9['nombre_factura'];
    $factura_fecha = $oc_item9['factura_fecha'];
    $acuerdo_pago = $oc_item9['nombre_acuerdo'];
    $nom_contacto_admin = $oc_item9['nom_contacto_admin'];
    $telefono_contacto = $oc_item9['telefono_contacto'];
    $nom_cliente = $oc_item9['nombre_cliente'];
    $nom_contacto_cliente = $oc_item9['nom_contacto_cliente'];
    $num_telefono = $oc_item9['num_telefono'];
    $proyecto = $oc_item9['proyecto'];
    $ciudad = $oc_item9['nombre_ciudad'];
    $lugar_instalacion = $oc_item9['lugar_instalacion'];
    $estado_logistico = $oc_item9['estado_logistico'];
    $dias_pactados = $oc_item9['dias_pactados'];
    $observacion12 = $oc_item9['observacion'];
    $num_factura = $oc_item9['num_factura'];
    $num_items = $oc_item9['num_items'];
    $contador = 1;
}

// Consultar ítems asociados
$query_items = $pdo->prepare("SELECT * FROM items_oc WHERE id_oc = :id_oc");
$query_items->bindParam(':id_oc', $id_get, PDO::PARAM_INT);
$query_items->execute();
$items = $query_items->fetchAll(PDO::FETCH_ASSOC);

$fecha_fin = isset($fecha_fin) ? $fecha_fin : ''; 

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
                    <form action="controller_edit.php" method="post" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_creacion">Creacion</label>
                                    <input type="text" name="fecha_creacion" id="fecha_creacion" value="<?php echo $oc_item9['fecha_creacion']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="id_pc">PC</label>
                                    <input type="text" name="id_pc" id="id_pc" value="<?php echo $oc_item9['id_pc']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-1" hidden>
                                <div class="form-group">
                                    <label for="pc">ID PC</label>
                                    <input type="text" name="pc" id="pc" value="<?php echo $pc_combinado; ?>"class="form-control">
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="id_oc">OC Interna</label>
                                    <input type="text" name="id_oc" id="id_oc" value="<?php echo $oc_final; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="oc_cliente">OC Cliente</label>
                                    <input type="text" name="oc_cliente" id="oc_cliente" value="<?php echo $oc_item9['oc_cliente']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_aprobacion">Fecha Aprobación</label>
                                    <input type="date" name="fecha_aprobacion" id="fecha_aprobacion" value="<?php echo $oc_item9['fecha_aprobacion']; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="estado_admon">Estado Admon</label>
                                    <select name="estado_admon" id="estado_admon" class="form-control" required onchange="updateIdAdmon()">
                                        <option value="<?php echo $estado_administracion; ?>" selected>
                                            <?php echo $estado_admon; ?>
                                        </option>
                                        <?php
                                            // Consulta los estados de la base de datos
                                            $query_admones = $pdo->prepare('SELECT id, estado_admon FROM t_estado WHERE estado_admon IS NOT NULL AND estado_admon <> ""');
                                            $query_admones->execute();
                                            $admon = $query_admones->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($admon as $admones) {
                                                $acuerdo_admon = $admones['estado_admon'];
                                                $id_admon_loop = $admones['id'];

                                                // Excluir la opción que ya está seleccionada por defecto
                                                if ($id_admon_loop != $estado_administracion) {
                                                    echo "<option value='$id_admon_loop'>$acuerdo_admon</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <!-- Campo oculto que almacena dinámicamente el ID seleccionado -->
                                    <input type="hidden" name="id_admon" id="id_admon" value="<?php echo $estado_administracion; ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nom_cliente">Nombre Cliente</label>
                                    <input type="text" name="nom_cliente" id="nom_cliente" value="<?php echo $oc_item9['nombre_cliente']; ?>" class="form-control">
                                    <input type="hidden" name="id_nom_cliente" id="id_nom_cliente" value="<?php echo $oc_item9['nom_cliente']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="nom_contacto_admin">Nom Contacto Admin</label>
                                    <input type="text" name="nom_contacto_admin" id="nom_contacto_admin" value="<?php echo $oc_item9['nom_contacto_admin']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="telefono_contacto">Teléfono Contacto</label>
                                    <input type="text" name="telefono_contacto" id="telefono_contacto" value="<?php echo $oc_item9['telefono_contacto']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="nom_contacto_cliente">Nom Contacto Cliente</label>
                                    <input type="text" name="nom_contacto_cliente" id="nom_contacto_cliente" value="<?php echo $oc_item9['nom_contacto_cliente']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="num_telefono">Num Teléfono</label>
                                    <input type="text" name="num_telefono" id="num_telefono" value="<?php echo $oc_item9['num_telefono']; ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="factura_fecha"> Fecha Factura</label>
                                    <input type="date" name="factura_fecha" id="factura_fecha" value="<?php echo $oc_item9['factura_fecha']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="num_factura">Num Factura</label>
                                    <input type="text" name="num_factura" id="num_factura" value="<?php echo $oc_item9['num_factura']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="estado_factura">Estado Factura</label>
                                    <select name="estado_factura" id="estado_factura" class="form-control" required onchange="updateIdFactura()">
                                        <!-- Opción por defecto -->
                                        <option value="<?php echo $id_estado_factura; ?>" selected>
                                            <?php echo $estado_factura; ?>
                                        </option>
                                        <!-- Opciones dinámicas -->
                                        <?php 
                                            $query_estados = $pdo->prepare('SELECT id, estado_factura FROM t_estado WHERE estado_factura IS NOT NULL AND estado_factura <> ""');
                                            $query_estados->execute();
                                            $estado = $query_estados->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($estado as $estados) {
                                                $acuerdo_estado = $estados['estado_factura'];
                                                $id_estado = $estados['id'];

                                                // Excluir la opción ya seleccionada por defecto
                                                if ($id_estado != $id_estado_factura) {
                                                    echo "<option value='$id_estado'>$acuerdo_estado</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <!-- Campo oculto que almacena dinámicamente el ID seleccionado -->
                                    <input type="hidden" name="id_factura1" id="id_factura1" value="<?php echo $id_estado_factura; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="acuerdo_pago">Acuerdo Pago</label>
                                    <select name="acuerdo_pago" id="acuerdo_pago" class="form-control" required onchange="updateIdAcuerdo()">
                                        <!-- Opción por defecto -->
                                        <option value="<?php echo $estado_acuerdo_pago; ?>" selected><?php echo $acuerdo_pago; ?></option>
                                        <!-- Opciones dinámicas -->
                                        <?php 
                                            $query_prefijos = $pdo->prepare('SELECT id, acuerdo_pago FROM oc_prefijos');
                                            $query_prefijos->execute();
                                            $prefi = $query_prefijos->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($prefi as $prefijos) {
                                                $acuerdo_pago = $prefijos['acuerdo_pago'];
                                                $id_pago = $prefijos['id'];

                                                // Excluir la opción ya seleccionada por defecto
                                                if ($id_pago != $estado_acuerdo_pago) {
                                                    echo "<option value='$id_pago'>$acuerdo_pago</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <!-- Campo oculto que almacena dinámicamente el ID seleccionado -->
                                    <input type="hidden" name="id_acuerdo1" id="id_acuerdo1" value="<?php echo $estado_acuerdo_pago; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="dias_pactados">Días Pactados de Entrega</label>
                                    <input type="text" name="dias_pactados" id="dias_pactados" value="<?php echo $oc_item9['dias_pactados']; ?>" class="form-control" disabled required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="num_items">Num Ítems</label>
                                    <input type="text" name="num_items" id="num_items" value="<?php echo $num_items; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proyecto">Proyecto</label>
                                    <input type="text" name="proyecto" id="proyecto" value="<?php echo $oc_item9['proyecto']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" name="ciudad" id="ciudad" value="<?php echo $oc_item9['nombre_ciudad']; ?>" class="form-control">
                                    <input type="hidden" name="id_ciudad" id="id_ciudad" value="<?php echo $oc_item9['ciudad']; ?>" class="form-control">

                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="lugar_instalacion">Lugar Instalación</label>
                                    <input type="text" name="lugar_instalacion" id="lugar_instalacion" value="<?php echo $oc_item9['lugar_instalacion']; ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="estado_logistico">Estado Logístico</label>
                                    <input type="text" name="estado_logistico" id="estado_logistico" value="<?php echo $oc_item9['estado_logistico']; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vendedor">Vendedor</label>
                                    <input type="text" name="vendedor" id="vendedor" value="<?php echo $vendedor; ?>" class="form-control">
                                    <input type="hidden" name="id_vendedor" id="id_vendedor" value="<?php echo $nombre_vendedor_oc; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="1" class="form-control"><?php echo $oc_item9['observacion']; ?></textarea>
                                    <input type="hidden" name="fecha_fin" id="fecha_fin" value="<?php echo isset($fecha_fin) ? $fecha_fin : ''; ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row" hidden>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="usuario_crea_oc">Usuario</label>
                                    <input type="text" name="usuario_crea_oc" id="usuario_crea_oc" value="<?php echo $sesion_usuario['nombre']?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_tratada">Fecha Tratamiento</label>
                                    <input type="text" name="fecha_tratada" id="fecha_tratada" value="<?php echo $fecha_tratada_oc; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="id">ID Principal</label>
                                    <input type="text" name="id" id="id" value="<?php echo $id; ?>" class="form-control">                                    
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
                                <a type="button" href="<?php echo $URL; ?>admin/administracion/oc/create_items.php?id=<?php echo $oc_item9['id']; ?>" class="btn btn-success">INSERTAR UN NUEVO ITEMS</a>
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
                                                <td><?php echo $contador++; ?></td>
                                                <td><?php echo $item['descripcion']; ?></td>
                                                <td><?php echo $item['cantidad']; ?></td>
                                                <td><?php echo $item['instalacion']; ?></td>
                                                <td>
                                                    <center>  
                                                        <a href="edit_items.php?id=<?php echo $item['id_item']; ?>" class="btn btn-success btn-sm">EDITAR<i class="fas fa-pen"></i></a>
                                                        <a href="controller_delete_items.php?id_item=<?php echo $item['id_item']; ?>&id=<?php echo $id_get; ?>" onclick="return confirm('¿Seguro de querer eliminar el item?')" class="btn btn-danger btn-sm">ELIMINAR <i class="fas fa-trash"></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php else : ?>
                                        <div class="card card-warning">
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

                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="<?php echo $URL."admin/administracion/oc/"; ?>" class="btn btn-default btn-block">Cancelar</a>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" onclick="return confirm('¿Está seguro de haber diligenciado correctamente los datos?')" class="btn btn-success btn-block">Actualizar y/o Generar POP</button>
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

<script>
    // Actualiza dinámicamente el campo ID cuando cambia el estado
    function updateIdAdmon() {
        const estadoAdmonSelect = document.getElementById('estado_admon');
        const idAdmonInput = document.getElementById('id_admon');
        idAdmonInput.value = estadoAdmonSelect.value;
    };

    // Actualiza dinámicamente el campo ID cuando cambia el estado
    function updateIdFactura() {
        const estadoFacturaSelect = document.getElementById('estado_factura');
        const idFacturaInput = document.getElementById('id_factura1');
        idFacturaInput.value = estadoFacturaSelect.value;
    };

    // Actualiza dinámicamente el campo ID cuando cambia el estado
    function updateIdAcuerdo() {
        const estadoAcuerdoSelect = document.getElementById('acuerdo_pago');
        const idAcuerdoInput = document.getElementById('id_acuerdo1');
        idAcuerdoInput.value = estadoAcuerdoSelect.value;
    };
</script>

<script>
    // Función que se ejecuta cuando cambia el valor de "estado_admon"
    document.getElementById('estado_admon').addEventListener('change', function() {
        var estadoAdmon = this.value;  // Obtiene el valor seleccionado en el select
        var fechaAprobacion = document.getElementById('fecha_aprobacion'); // El campo de la fecha de aprobación

        // Si el valor seleccionado es "1", asigna la fecha actual al campo "fecha_aprobacion"
        if (estadoAdmon == '1') {
            var today = new Date();
            var day = ("0" + today.getDate()).slice(-2);
            var month = ("0" + (today.getMonth() + 1)).slice(-2); // Los meses van de 0 a 11
            var year = today.getFullYear();
            var formattedDate = year + '-' + month + '-' + day;

            fechaAprobacion.value = formattedDate; // Asigna la fecha al campo "fecha_aprobacion"
        }
    });
</script>

<script>
    function calcularFechaFin() {
        var fechaAprobacion = document.getElementById("fecha_aprobacion").value;
        var diasPactados = parseInt(document.getElementById("dias_pactados").value, 10);
        var fechaFinInput = document.getElementById("fecha_fin");

        if (!fechaAprobacion || isNaN(diasPactados) || diasPactados <= 0) {
            fechaFinInput.value = "";
            return;
        }

        // Convertir la fecha de aprobación en un objeto Date
        var fecha = new Date(fechaAprobacion);

        // Sumar días sin contar sábados ni domingos
        var diasAgregados = 0;
        while (diasAgregados < diasPactados) {
            fecha.setDate(fecha.getDate() + 1); // Avanza un día
            var diaSemana = fecha.getDay(); // 0 = Domingo, 6 = Sábado
            if (diaSemana !== 0 && diaSemana !== 6) {
                diasAgregados++;
            }
        }

        // Formatear fecha a YYYY-MM-DD
        var year = fecha.getFullYear();
        var month = ("0" + (fecha.getMonth() + 1)).slice(-2);
        var day = ("0" + fecha.getDate()).slice(-2);
        var fechaFin = `${year}-${month}-${day}`;

        // Asignar la fecha calculada al campo fecha_fin
        fechaFinInput.value = fechaFin;
    }

    // Ejecutar cuando cambian los valores
    document.getElementById("fecha_aprobacion").addEventListener("change", calcularFechaFin);
    document.getElementById("dias_pactados").addEventListener("input", calcularFechaFin);

    // Función que habilita o deshabilita el campo "dias_pactados" según el valor de "estado_admon"
function toggleDiasPactados() {
    var estadoAdmon = document.getElementById("estado_admon").value;
    var diasPactados = document.getElementById("dias_pactados");

    // Si estado_admon es igual a 1, habilitar "dias_pactados", si no, deshabilitarlo
    if (estadoAdmon == "1") {
        diasPactados.disabled = false;  // Habilitar campo
    } else {
        diasPactados.disabled = true;   // Deshabilitar campo
    }
}

// Ejecutar la función cuando cambie el valor de "estado_admon"
document.getElementById("estado_admon").addEventListener("change", toggleDiasPactados);

// Ejecutar la función también al cargar la página para verificar el estado inicial del campo
window.addEventListener("load", toggleDiasPactados);

</script>
