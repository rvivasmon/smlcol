<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

// Obtén la fecha actual
$fecha_creacion = date('Y-m-d');

// Obtener el último registro OC
$query_co = $pdo->prepare('SELECT * FROM oc ORDER BY id DESC LIMIT 1');
$query_co->execute();
$last_oc = $query_co->fetch(PDO::FETCH_ASSOC);

// Calcular el número de factura
$num_factura = ($last_oc) ? $last_oc['num_factura'] + 1 : 1;
$num_factura_fecha = str_pad($num_factura, 3, '0', STR_PAD_LEFT) . ' - ' . date('Ymd');

// Obtener opciones dinámicas
$query_taunion = $pdo->prepare('SELECT id, consecutivo_primero_oc FROM oc_prefijos LIMIT 2');
$query_taunion->execute();
$unionesa = $query_taunion->fetchAll(PDO::FETCH_ASSOC);

// Obtener el valor de 'tipo_proyecto_visor' de la tabla 'proyecto'
$query_proyecto = $pdo->prepare('SELECT * FROM oc_proyecto WHERE id_proyec = :id_proyec');
$query_proyecto->bindParam(':id_proyec', $id_proyec, PDO::PARAM_INT);
$query_proyecto->execute();
$proyecto = $query_proyecto->fetch(PDO::FETCH_ASSOC);

// Obtener el valor de 'tipo_proyecto_visor'
$tipo_proyecto_visor = $proyecto['tipo_proyecto_visor'] ?? '';

// Generar el valor inicial de 'pc'
$pc = $tipo_proyecto_visor ? 'PC-' . $tipo_proyecto_visor : '';


// Obtener los valores de $pc y $sml_psi_tl desde la base de datos o formulario
$pc = $_POST['pc'] ?? '';
$sml_psi_tl = $_POST['sml_psi_tl'] ?? '';
$oci_oc = $_POST['oci_oc'] ?? '';

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nuevo Registro</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    <a href="#" class="d-block"><?php echo $sesion_usuario['nombre']?></a>
                    Introduzca la información correspondiente
                </div>

                <div class="card-body">
                    <form action="controller_create_oc.php" method="post" enctype="multipart/form-data">

                    <!-- Campos del formulario -->

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Fecha</label>
                                    <input type="text" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha_creacion; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">PC</label>
                                    <select name="pc" id="pc" class="form-control" required onchange="updateTipoPC()">
                                        <option value="">Seleccione el PC</option>
                                        <?php 
                                            $query_proyecto = $pdo->prepare('SELECT id_proyecto_visor, tipo_proyecto_visor FROM oc_proyecto LIMIT 2');
                                            $query_proyecto->execute();
                                            $proyectos = $query_proyecto->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($proyectos as $proyecto) {
                                                $id_proyecto_visor = $proyecto['id_proyecto_visor'];
                                                $tipo_proyecto_visor = $proyecto['tipo_proyecto_visor'];
                                                echo "<option value='$id_proyecto_visor' data-tipo='$tipo_proyecto_visor'>$id_proyecto_visor</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Tipo PC</label>
                                    <input type="text" class="form-control" name="tipo_pc" id="tipo_pc" value="" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="oci_oc">Orden de Compra</label>
                                    <select name="oci_oc" id="oci_oc" class="form-control" required onchange="validateAndUpdateCounter()">
                                        <option value="">Seleccione el OCI-OC</option>
                                        <?php foreach ($unionesa as $prefijos): ?>
                                            <option value="<?php echo $prefijos['consecutivo_primero_oc']; ?>"><?php echo $prefijos['consecutivo_primero_oc']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Tipo OC</label>
                                    <select name="sml_psi_tl" id="sml_psi_tl" class="form-control" required onchange="validateAndUpdateCounter()">
                                        <option value="">Seleccione el SML-PSI-TL</option>
                                        <?php 
                                            $query_proyecto = $pdo->prepare('SELECT tipo_proyecto_visor FROM oc_proyecto LIMIT 3');
                                            $query_proyecto->execute();
                                            $proyectos = $query_proyecto->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($proyectos as $proyecto) {
                                                $tipo_proyecto_visor = $proyecto['tipo_proyecto_visor'];
                                                echo "<option value='$tipo_proyecto_visor'>$tipo_proyecto_visor</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">OC Resultante</label>
                                    <input type="Text" name="oc_resultante" id="oc_resultante" value="<?php echo $oc_resultante ?? ''; ?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="oc_cliente">OC Cliente</label>
                                    <input type="text" name="oc_cliente" id="oc_cliente" placeholder="OC Cliente" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="nom_cliente">Nombre del Cliente</label>
                                    <input type="text" name="nom_cliente" id="nom_cliente" placeholder="Nombre del Cliente" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="nom_contacto_admin">Contacto Admin</label>
                                    <input type="text" name="nom_contacto_admin" id="nom_contacto_admin" placeholder="Nombre Contacto Admin" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="telefono_contacto">Telefono Contacto</label>
                                    <input type="text" name="telefono_contacto" id="telefono_contacto" placeholder="Telefono Contacto" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="nom_contacto_cliente">Contacto Cliente</label>
                                    <input type="text" name="nom_contacto_cliente" id="nom_contacto_cliente" placeholder="Nombre del Contacto Cliente" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="num_telefono">Numero de Telefono</label>
                                    <input type="text" name="num_telefono" id="num_telefono" placeholder="Numero de Telefono" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_aprobacion">Fecha Aprobación</label>
                                    <input type="date" name="fecha_aprobacion" id="fecha_aprobacion" placeholder="Fecha Aprobación" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="estado_admon">Estado Admon</label>
                                    <input type="text" name="estado_admon" id="estado_admon" placeholder="Estado Admon" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="vendedor">Vendedor</label>
                                    <input type="text" name="vendedor" id="vendedor" placeholder="Vendedor" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="estado_factura">Estado Factura</label>
                                    <input type="text" name="estado_factura" id="estado_factura" placeholder="Estado Factura" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Número de Factura</label>
                                    <input type="text" name="num_factura_fecha" id="num_factura_fecha" value="<?php echo $num_factura_fecha; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Acuerdo Pago</label>
                                    <select name="acuerdo_pago" id="acuerdo_pago" class="form-control" required>
                                    <option value="">Seleccione el Acuerdo de Pago</option>
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
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Número de Factura</label>
                                    <input type="text" name="num_factura" id="num_factura" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" name="ciudad" id="ciudad" placeholder="Ciudad" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="lugar_instalacion">Lugar Instalación</label>
                                    <input type="text" name="lugar_instalacion" id="lugar_instalacion" placeholder="Lugar Instalación" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="estado_logistico">Estado Logístico</label>
                                    <input type="text" name="estado_logistico" id="estado_logistico" placeholder="Estado Logístico" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="dias_pactados">Días Pactados</label>
                                    <input type="number" name="dias_pactados" id="dias_pactados" placeholder="Días Pactados" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="proyecto">Proyecto</label>
                                    <input type="text" name="proyecto" id="proyecto" placeholder="Proyecto" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="4" placeholder="Observación" class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Num Items</label>
                                    <input type="text" name="num_items" id="num_items" value="<?php echo $num_items ?? ''; ?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <h3>Items</h3>
                                <button type="button" id="addItem" class="btn btn-primary">Agregar Ítem</button>
                            </div>

                            <div id="itemsContainer" class="row"></div> 

                            <!-- Modal -->
                            <div class="modal fade" id="itemWarningModal" tabindex="-1" aria-labelledby="itemWarningModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="itemWarningModalLabel">Advertencia</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Debes agregar al menos un ítem antes de registrar el OC.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Los campos de elementos dinámicos se agregarán aquí -->
                            <input type="hidden" name="num_factura" value="<?php echo $num_factura; ?>">
                        </div>
                        
                        <hr>
                        
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="<?php echo $URL."admin/administracion/oc/";?>" class="btn btn-default btn-block">Cancelar</a>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit"  id="registerOcButton" onclick="return confirm('¿Está seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Registrar OC</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->
</div><!-- /.content-wrapper -->

<?php include('../../../layout/admin/parte2.php');?>

<script>
// Inicializa el contador de ítems
let itemCounter = 0;
const numItemsInput = document.getElementById('num_items');

// Función para actualizar el contador de ítems
function updateItemCounter() {
    itemCounter = document.getElementById('itemsContainer').children.length / 5; // Cada ítem tiene 5 columnas
    numItemsInput.value = itemCounter;
}

// Evento para agregar un ítem
document.getElementById('addItem').addEventListener('click', function() {
    const container = document.getElementById('itemsContainer');
    const itemIndex = container.children.length / 5; // Cada ítem tiene 5 columnas
    const itemHTML = `
      <div class="col-12">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="descripcion_${itemIndex}">Descripción</label>
              <input type="text" name="descripcion[]" id="descripcion_${itemIndex}" placeholder="Descripción" class="form-control" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="cantidad_${itemIndex}">Cantidad</label>
              <input type="number" name="cantidad[]" id="cantidad_${itemIndex}" placeholder="Cantidad" class="form-control" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="instalacion_${itemIndex}">Instalación</label>
              <select name="instalacion[]" id="instalacion_${itemIndex}" class="form-control" required>
                <option value="">Instalación?</option>
                <?php 
                  $query_tabla_union = $pdo->prepare('SELECT id, consecutivo_instalacion_oc FROM oc_prefijos LIMIT 2');
                  $query_tabla_union->execute();
                  $uniones = $query_tabla_union->fetchAll(PDO::FETCH_ASSOC);
                  foreach($uniones as $prefijos) {
                    $consecutivo_instalacion_oc = $prefijos['consecutivo_instalacion_oc'];
                    echo "<option value='$consecutivo_instalacion_oc'>$consecutivo_instalacion_oc</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm delete-item">Eliminar</button>
          </div>
        </div>
        <hr>
      </div>
    `;
    container.insertAdjacentHTML('beforeend', itemHTML);

    // Incrementar el contador de ítems
    itemCounter++;  
    numItemsInput.value = itemCounter;  // Actualizar el input con el contador actual
    saveItemCounter(itemCounter);  // Guardar el contador actualizado en la base de datos

    // Agregar el evento de eliminación a los nuevos botones
    const newDeleteButton = container.querySelector('.col-12:last-child .delete-item');
    newDeleteButton.addEventListener('click', function() {
        const itemContainer = this.closest('.col-12');
        itemContainer.remove();

        // Decrementar el contador de ítems después de eliminar
        itemCounter--;
        numItemsInput.value = itemCounter;
        saveItemCounter(itemCounter);  // Guardar el contador actualizado en la base de datos después de eliminar
    });
});

// Agregar eventos de eliminación a los ítems ya existentes (si hay)
document.querySelectorAll('.delete-item').forEach(button => {
    button.addEventListener('click', function() {
        const itemContainer = this.closest('.col-12');
        itemContainer.remove();

        // Decrementar el contador de ítems después de eliminar
        itemCounter--;
        numItemsInput.value = itemCounter;
        saveItemCounter(itemCounter);  // Guardar el contador actualizado en la base de datos después de eliminar
    });
});

// Inicializar el contador de ítems al cargar la página
updateItemCounter();

// Función para guardar el contador de ítems en la base de datos
function saveItemCounter(counter) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_item_counter.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('counter=' + counter);
}

// Evento para validar antes de enviar el formulario
document.getElementById('registerOcButton').addEventListener('click', function(event) {
    if (itemCounter === 0) {
        event.preventDefault();
        // Mostrar el modal
        $('#itemWarningModal').modal('show');
    }
});
</script>

<script>
function updateTipoPC() {
    // Obtén el valor seleccionado del campo "pc"
    const pcSelect = document.getElementById('pc');
    const selectedPC = pcSelect.options[pcSelect.selectedIndex].value;

    // Verifica si se ha seleccionado un valor
    if (selectedPC) {
        // Realiza una solicitud AJAX para obtener el valor de "tipo_proyecto_visor"
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_tipo_pc.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Actualiza el campo "tipo_pc" con el valor recibido
                document.getElementById('tipo_pc').value = xhr.responseText;
            }
        };
        xhr.send('id_proyecto_visor=' + selectedPC);
    } else {
        // Si no se ha seleccionado un valor, limpia el campo "tipo_pc"
        document.getElementById('tipo_pc').value = '';
    }
}
</script>

<script>
// Función para obtener el nuevo contador y actualizar el campo "oc_resultante"
function updateOcResultante() {
    const ociOc = document.getElementById('oci_oc').value;
    const smlPsiTl = document.getElementById('sml_psi_tl').value;

    if (ociOc && smlPsiTl) {
        // Hacer una solicitud para obtener el nuevo contador basado en la combinación
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_new_counter.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const newCounter = xhr.responseText.trim(); // Obtén el nuevo contador del servidor
                const ocResultante = `${ociOc}-${smlPsiTl}-${newCounter}`;
                document.getElementById('oc_resultante').value = ocResultante;
            }
        };
        xhr.send(`oci_oc=${ociOc}&sml_psi_tl=${smlPsiTl}`);
    }
}

// Agregar eventos para actualizar el campo "oc_resultante" cuando cambien "oci_oc" o "sml_psi_tl"
document.getElementById('oci_oc').addEventListener('change', updateOcResultante);
document.getElementById('sml_psi_tl').addEventListener('change', updateOcResultante);
</script>