<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

?>

<?php include('../../../layout/admin/parte1.php'); ?>

<script>
  function optionSelected(option) {
    switch(option) {
      case 1:
        // Acciones para la opción 1
        alert('Nivel 1 seleccionado');
        break;
      case 2:
        // Acciones para la opción 2
        alert('Nivel 2 seleccionado');
        break;
      case 3:
        // Acciones para la opción 3
        alert('Nivel 3 seleccionado');
        break;
      default:
        // Acciones por defecto
        break;
    }
  }
</script>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                <h1 class="m-0">TICKETS STC</h1>                
                    <div class="card card-blue">
                        <div class="card-header">
                            TICKETS ACTIVOS
                        </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="table_stcs" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ID STC</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Medio de Ingreso</th>
                                    <th>Ticket Externo</th>
                                    <th>Tipo de Servicio</th>
                                    <th>ID Producto</th>
                                    <th>Falla</th>
                                    <th>Observación</th>
                                    <th>Cliente</th>
                                    <th>Ciudad</th>
                                    <th>Proyecto</th>
                                    <th>Estado</th>
                                    <th>Persona Contacto</th>
                                    <th>Medio de Contacto</th>
                                    <th><center>Acciones</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = 0;
                                $query = $pdo->prepare('SELECT stc.*, tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_cliente, ciudad.ciudad AS nombre_ciudad, estado.estadostc AS nombre_estado FROM stc JOIN tipo_servicio ON stc.tipo_servicio = tipo_servicio.id JOIN clientes ON stc.cliente = clientes.id JOIN ciudad ON stc.ciudad = ciudad.id JOIN estado ON stc.estado = estado.id WHERE stc.estado_ticket = "1" AND stc.tipo_servicio NOT IN (3, 4)');

                                $query->execute();
                                $stcs = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($stcs as $stc){
                                    $id = $stc['id'];
                                    $id_stc = $stc['id_stc'];
                                    $fecha_ingreso = $stc['fecha_ingreso'];
                                    $medio_ingreso = $stc['medio_ingreso'];
                                    $ticket_externo = $stc['ticket_externo'];
                                    $servicio = $stc['nombre_servicio'];
                                    $id_producto = $stc['id_producto'];
                                    $falla = $stc['falla'];
                                    $observacion = $stc['observacion'];
                                    $cliente = $stc['nombre_cliente'];
                                    $ciudad = $stc['nombre_ciudad'];
                                    $proyecto = $stc['proyecto'];
                                    $estado = $stc['nombre_estado'];
                                    $persona_contacto = $stc['persona_contacto'];
                                    $medio_contacto = $stc['email_contacto'];
                                    $contador = $contador + 1;
                                ?>
                                    <tr>
                                        <td><?php echo $contador; ?></td>
                                        <td><?php echo $id_stc; ?></td>
                                        <td><?php echo $fecha_ingreso; ?></td>
                                        <td><?php echo $medio_ingreso; ?></td>
                                        <td><?php echo $ticket_externo; ?></td>
                                        <td><a href="#" class="servicio-link" data-toggle="modal" data-target="#servicioModal"><?php echo $servicio; ?></a></td>
                                        <td><?php echo $id_producto; ?></td>
                                        <td><?php echo $falla; ?></td>
                                        <td><?php echo $observacion; ?></td>
                                        <td><?php echo $cliente; ?></td>
                                        <td><?php echo $ciudad; ?></td>
                                        <td><?php echo $proyecto; ?></td>
                                        <td><?php echo $estado; ?></td>
                                        <td><?php echo $persona_contacto; ?></td>
                                        <td><?php echo $medio_contacto; ?></td>
                                        <td>
                                            <center>
                                                <a href="show.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Editar <i class="fas fa-pen"></i></a>
                                                <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
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

<div class="modal fade" id="servicioModal" tabindex="-1" role="dialog" aria-labelledby="servicioModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="servicioModalLabel">Detalles del Servicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Aquí puedes agregar contenido adicional relacionado con el servicio -->
        <p>Detalles del nivel seleccionado.</p>
        <p>Seleccione un Nivel</p>
        
        <center>
            <button type="button" class="btn btn-outline-info" onclick="optionSelected(1)">Nivel 1</button>
            <button type="button" class="btn btn-outline-info" onclick="optionSelected(2)">Nivel 2</button>
            <button type="button" class="btn btn-outline-info" onclick="optionSelected(3)">Nivel 3</button>
        </center>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<?php include('../../../layout/admin/parte2.php'); ?>

<script>
    $(function () {
        $("#table_stcs").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando_START_ a _END_ de _TOTAL_ Órdenes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total Órdenes)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Órdenes",
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
        }).buttons().container().appendTo('#table_stcs_wrapper .col-md-6:eq(0)');
    });
</script>



<script>
  $(document).ready(function() {
    $('.servicio-link').click(function() {
      // Abre el modal correspondiente cuando se hace clic en el enlace del servicio
      $('#servicioModal').modal('show');
    });
  });
</script>

