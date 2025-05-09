<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');


include('../../../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                <h1 class="m-0">Solicitudes Recibidas TLCH / SMCOL</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            RECIBIDOS
                        </div>

                        <hr>

                        <div class="card-tools ml-4">
                            <a href=".." class="btn btn-warning"><i class="bi bi-plus-square"></i> Regresar</a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_tracking" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Id Solicitud</th>
                                            <th>Origen</th>
                                            <th>Fecha Oc</th>
                                            <th>Producto</th>
                                            <th>Procesado</th>
                                            <th>Fecha Procesado</th>
                                            <th>Observación Colombia</th>
                                            <th>Inicio de Fabricación</th>
                                            <th>Terminado</th>
                                            <th>Enviado</th>
                                            <th>Fecha Envío</th>
                                            <th>Recibido</th>
                                            <th>Documento de China</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT * FROM tracking WHERE recibido = "2"');

                                        $query->execute();
                                        $trackings = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($trackings as $tracking){
                                            $id = $tracking['id'];
                                            $date = $tracking['date'];
                                            $origin = $tracking['codigo_generado'];
                                            $type = $tracking['origen'];
                                            $category = $tracking['fecha_oc'];
                                            $quantitly = $tracking['producto'];
                                            $status = $tracking['status'];
                                            $date_status = $tracking['date_status'];
                                            $obscolombia = $tracking['observaciones_colombia'];
                                            $inicio_prod = $tracking['inicio_produccion'];
                                            $finished = $tracking['date_finished'];
                                            $enviado = $tracking['enviar'];
                                            $fecha_envio = $tracking['fecha_envio'];
                                            $recibido = $tracking['recibido'];
                                            $codigo_chino = $tracking['codigo_chino'];
                                            $contador = $contador + 1;

                                            // convertir el valor de "status" a "NO" o "SÍ"
                                            $statusText = ($status == 1) ? "NO" : (($status == 2) ? "SÍ" : "Desconocido");

                                            // Convertir el valor de "finished" a los valores requeridos
                                            $finishedText = ($finished == 0) ? "" : (($finished == 1) ? "SÍ" : "NO");

                                            // Reemplazo el valor de enviado por el texto correspondiente
                                            $enviado_text = $enviado ? ($enviado == 1 ? 'SÍ' : 'NO') : ''; // Si $enviado es nulo o vacío, dejarlo vacío en el formulario

                                            // Cambiar el valor de "Recibido" por los valores requeridos
                                            $recibido_text = $recibido ? ($recibido == 1 ? 'NO' : 'SÍ') : '';

                                            ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $date; ?></td>
                                                <td><?php echo $origin; ?></td>
                                                <td><?php echo $type; ?></td>
                                                <td><?php echo $category; ?></td>
                                                <td><?php echo $quantitly; ?></td>
                                                <td>
                                                    <input type="checkbox" class="tracking-checkbox" name="tracking_ids[]" value="<?php echo $id; ?>"
                                                    <?php echo ($status == 2) ? 'checked disabled' : ''; ?>>
                                                    <?php echo $statusText; ?>
                                                </td>
                                                <!--<td><a href="#" class="change-status" data-id="<?php echo $id; ?>"><?php echo $statusText; ?></a></td>  LINEA PARA MOSTRAR SÍ O NO EN EL INDEX -->
                                                <td><?php echo $date_status; ?></td>
                                                <td><?php echo $obscolombia; ?></td>
                                                <td><?php echo $inicio_prod; ?></td>
                                                <td><?php echo $finished; ?></td>
                                                <td><?php echo $enviado_text; ?></td>
                                                <td><?php echo $fecha_envio; ?></td>
                                                <td>
                                                    <?php if (!empty($codigo_chino) && $recibido != 2): ?>
                                                        <a href="#" class="btn btn-sm btn-outline-primary marcar-recibido" data-id="<?php echo $id; ?>">
                                                            Recibido
                                                        </a>
                                                    <?php else: ?>
                                                        <?php echo $recibido_text; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $codigo_chino; ?></td>

                                                <td>
                                                    <center>
                                                        <a href="show.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                        <?php if ($status != 2): ?>
                                                            <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">
                                                                Editar <i class="fas fa-pen"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </center>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
</div>

<!-- Modal para cambiar el estado -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalLabel">Cambiar Estado de Procesado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="changeStatusForm" method="post">
                <input type="hidden" name="tracking_ids" id="trackingIds">
                <div class="form-group">
                        <label for="status">PROCESAR?</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="2">Sí</option>
                            <option value="1">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para marcar como recibido -->
<div class="modal fade" id="modalRecibido" tabindex="-1" role="dialog" aria-labelledby="modalRecibidoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formRecibido">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmar Recepción</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_tracking" id="idTrackingRecibido">
          <p>¿Está seguro que desea marcar esta solicitud como <strong>recibida</strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Sí, marcar como Recibido</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>


<?php include('../../../../../layout/admin/parte2.php');?>

<script>
    $(function () {
        $("#table_tracking").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Solicitudes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Solicitudes",
                "infoFiltered": "(Filtrado de _MAX_ total Solicitudes)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Solicitudes",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true, "lengthChange": true, "autoWidth": false,
            buttons: [{
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [{
                    text: 'Copiar',
                    extend: 'copy',
                }, {
                    extend: 'pdf'
                }, {
                    extend: 'csv'
                }, {
                    extend: 'excel'
                }, {
                    text: 'Imprimir',
                    extend: 'print'
                }
                ]
            },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        }).buttons().container().appendTo('#table_tracking_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    $(document).ready(function() {
    // Abrir modal al hacer clic en "Procesar Seleccionados"
    $('#processSelected').click(function() {
        var selectedIds = [];
        $('.tracking-checkbox:checked:not(:disabled)').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            alert('Seleccione al menos una solicitud.');
            return;
        }

        $('#trackingIds').val(selectedIds.join(',')); // Guardar IDs en input oculto
        $('#changeStatusModal').modal('show');
    });

    // Enviar formulario mediante AJAX
    $('#changeStatusForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'change_status.php',
            data: formData,
            success: function(response) {
                location.reload(); // Recargar la página después de actualizar
            },
            error: function() {
                alert('Error al actualizar el estado.');
            }
        });
    });
});
</script>

<script>
    $(document).on('click', '.marcar-recibido', function (e) {
    e.preventDefault();
    const id = $(this).data('id');
    $('#idTrackingRecibido').val(id);
    $('#modalRecibido').modal('show');
});

$('#formRecibido').submit(function (e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.ajax({
        url: 'marcar_recibido.php',
        method: 'POST',
        data: formData,
        success: function (res) {
            $('#modalRecibido').modal('hide');
            location.reload(); // Recargar para mostrar el cambio
        },
        error: function () {
            alert('Error al marcar como recibido.');
        }
    });
});

</script>