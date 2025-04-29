<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');


include('../../../../layout/admin/parte1.php');


?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                <h1 class="m-0">Solicitudes Mercancía (SMC)</h1>
                      <div class="card card-blue">
                        <div class="card-header">
                          NUEVAS
                        </div>

                        <button id="edit-selected" class="btn btn-warning btn-sm" disabled>Enviar Seleccionados</button>

                        <hr>

                        <div class="row justify-content-center">
                            <!-- Contenedor principal para los botones -->
                            <div class="card-tools d-flex justify-content-center w-100">

                                <!-- Botón existente para regresar -->
                                <div class="form-group mx-2">
                                    <a href="../../../" class="btn btn-secondary">
                                        <i class="bi bi-plus-square"></i> REGRESAR
                                    </a>
                                </div>

                                <!-- Primer botón adicional -->
                                <div class="form-group mx-2">
                                    <a href="../terminar" class="btn btn-success">
                                        <i class="bi bi-plus-square"></i> POR TERMINAR
                                    </a>
                                </div>

                                <!-- Segundo botón adicional -->
                                <div class="form-group mx-2">
                                    <a href="../enviar" class="btn btn-danger">
                                        <i class="bi bi-plus-square"></i> POR ENVIAR
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="card-body">
                          <div class="table-responsive">
                            <table id="table_tracking" class="table table-striped table-hover table-bordered">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Fecha</th>
                                  <th>ID POP</th>
                                  <th>Tipo</th>
                                  <th>Cantidad</th>
                                  <th>Observación</th>
                                  <th>En fabricación</th>
                                  <th>Terminado</th>
                                  <th>Enviado</th>
                                  <th><center>Acciones</center></th>
                                  <th><input type="checkbox" id="select-all"> Envío</th> <!-- Checkbox para seleccionar todos -->
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $contador = 0;
                                $query = $pdo->prepare('SELECT * FROM tracking WHERE status = "2" AND inicio_produccion IS NULL');

                                $query->execute();
                                $trackings = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($trackings as $tracking){
                                  $id = $tracking['id'];
                                  $date = $tracking['date_status'];
                                  $id_solicitud = $tracking['codigo_generado'];
                                  $type = $tracking['producto'];
                                  $category = $tracking['category'];
                                  $quantitly = $tracking['cantidad'];
                                  $obscolombia = $tracking['observaciones_colombia'];
                                  $en_ejecucion = $tracking['en_produccion'];
                                  $finished = $tracking['finished'];
                                  $enviar = $tracking['enviar'];
                                  $contador = $contador + 1;

                                  // Reemplazar el valor numérico por el texto correspondiente
                                  $finished_text = $finished ? ($finished == 1 ? 'SÍ' : 'NO') : '';

                                  //Reemplazo el valorde en_ejecucion por el texto correspondiente
                                  $en_ejecucion_text = $en_ejecucion ? ($en_ejecucion == 1 ? 'SÍ' : 'NO') : '';

                                  // Reemplazo el valor numérico por el texto correspondiente
                                  $enviado_text = $enviar ? ($enviar == 0 ? 'NO' : 'SÍ') : '';

                                  // Determinar si los botones deben estar deshabilitados
                                  $disable_procesar = $en_ejecucion == 1 ? 'disabled' : '';
                                  $disable_terminar = $en_ejecucion != 1 || $finished == 1 ? 'disabled' : '';

                                  // Deshabilitar boton de envíar si ya se envió producto
                                  $disable_enviar = ($finished == 1 && intval($enviar) == 0) ? '' : 'disabled';

                                  // Habilitar y deshabilitar Checkbox
                                  $disable_checkbox = ($en_ejecucion == 1 && intval($enviar) == 0) ? '' : 'disabled';
                                ?>
                                  <tr>
                                      <td><a href="<?php echo $URL; ?>admin/techled/tracking_chi/show.php?id=<?php echo $id; ?>"><?php echo $contador; ?></a></td>
                                      <td><?php echo $date; ?></td>
                                      <td><?php echo $id_solicitud; ?></td>
                                      <td><?php echo $type; ?></td>
                                      <td><?php echo $quantitly; ?></td>
                                      <td><?php echo $obscolombia; ?></td>
                                      <td><?php echo $en_ejecucion_text; ?></td> <!-- Mostrar el texto en_ejecucion -->
                                      <td><?php echo $finished_text; ?></td>
                                      <td><?php echo $enviado_text; ?></td>
                                      <td>
                                        <center>
                                          <button onclick="confirmarProduccion(<?php echo $id; ?>)" class="btn btn-info btn-sm" <?php echo $disable_procesar; ?>>Procesar <i class="fas fa-eye"></i></button>
                                        </center>
                                      </td>
                                      <td>
                                        <input type="checkbox" class="record-checkbox" value="<?php echo $id; ?>" <?php echo $disable_checkbox; ?>>
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

<!-- Modal HTML -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Shipping information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <input type="hidden" id="selectedIds" name="selected_ids">
          <div class="form-group">
            <label for="num_envoys">Num Envoys</label>
            <input type="text" class="form-control" id="num_envoys" name="num_envoys" required>
          </div>
          <div class="form-group">
            <label for="ship">Ship</label>
              <select class="form-control" id="ship" name="ship" required>
                <option value="">Select an option</option>
                <option value="Barco">Boats</option>
                <option value="Avión">Airplane</option>
                <option value="FEDEX">FEDEX</option>
              </select>
          </div>
          <div class="form-group">
            <label for="guia">Guide</label>
            <input type="text" class="form-control" id="guia" name="guia" required>
          </div>
          <div class="form-group">
            <label for="fecha_guia">Guide date</label>
            <input type="date" class="form-control" id="fecha_guia" name="fecha_guia" required>
          </div>
          <div class="form-group">
            <label for="obschina">Observations from China</label>
            <textarea class="form-control" id="obschina" name="obschina" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>


<?php include('../../../../layout/admin/parte2.php');?>

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

        // Select/Deselect all checkboxes
        $('#select-all').click(function() {
        var checked = this.checked;
        $('.record-checkbox').each(function() {
            this.checked = checked;
        });
    });

    function confirmarProduccion(id) {
        if (confirm("Desea iniciar la fabricación del producto?")) {
            // Si el usuario selecciona "SÍ"
            window.location.href = "controller_solicitud.php?id=" + id;
        }
        // Si el usuario selecciona "NO", no se hace nada y permanece en la página
    }

    function terminarProduccion(id, enEjecucion) {
    if (enEjecucion == 1) {
        if (confirm("¿Está seguro de que desea terminar la fabricación del producto?")) {
            // Redirigir a la página que se encarga de actualizar los campos finished y date_finished
            window.location.href = "terminar_produccion.php?id=" + id;
        }
    } else {
        alert("Primero comience la fabricación de las piezas");
    }
}


  document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.record-checkbox');
    const editSelectedButton = document.getElementById('edit-selected');
    const selectedIdsInput = document.getElementById('selectedIds');

    function updateButtonState() {
      const selectedIds = Array.from(checkboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);

      if (selectedIds.length >= 2) {
        editSelectedButton.disabled = false;
      } else {
        editSelectedButton.disabled = true;
      }

      selectedIdsInput.value = selectedIds.join(',');
    }

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', updateButtonState);
    });

    document.getElementById('select-all').addEventListener('change', function () {
      const checked = this.checked;
      checkboxes.forEach(checkbox => {
        checkbox.checked = checked;
      });
      updateButtonState();
    });

    editSelectedButton.addEventListener('click', function () {
      const selectedIds = selectedIdsInput.value;
      if (selectedIds) {
        $('#editModal').modal('show');
      } else {
        alert('Seleccione al menos dos registros para editar.');
      }
    });

    document.getElementById('editForm').addEventListener('submit', function (event) {
      event.preventDefault();

      const formData = new FormData(this);

      fetch('update.php', {
        method: 'POST',
        body: formData,
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Registros actualizados exitosamente.');
          location.reload();
        } else {
          alert('Hubo un error al actualizar los registros.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    });
  });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".btn-danger").forEach(btn => {
            if (btn.hasAttribute("disabled")) {
                btn.classList.add("disabled"); // Agregar clase para deshabilitar
                btn.style.pointerEvents = "none"; // Evita clics
                btn.style.opacity = "0.5"; // Lo hace visualmente deshabilitado
            }
        });
    });
</script>
