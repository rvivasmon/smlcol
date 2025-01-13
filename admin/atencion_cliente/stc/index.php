<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0">TICKETS STC A TRATAR</h1>

                    <div class="card card-blue">
                        <div class="card-header">
                            TICKETS ABIERTOS
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_stcs21" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha Ingreso</th>
                                            <th>ID STC</th>
                                            <th>Casos</th>
                                            <th>Cliente</th>
                                            <th>Ciudad</th>
                                            <th>Proyecto</th>
                                            <th>Estado</th>
                                            <th>Tipo Servicio</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT 
                                                                        stc.*,
                                                                        t_tipo_servicio.servicio_stc AS nombre_servicio,
                                                                        clientes.nombre_comercial AS nombre_cliente,
                                                                        t_ciudad.ciudad AS nombre_ciudad,
                                                                        t_estado.estadostc AS nombre_estado,
                                                                        oc_admin.lugar_instalacion AS nombre_proyecto
                                                                    FROM
                                                                        stc
                                                                    JOIN
                                                                        t_tipo_servicio ON stc.tipo_servicio = t_tipo_servicio.id 
                                                                    JOIN
                                                                        clientes ON stc.cliente = clientes.id
                                                                    JOIN
                                                                        t_ciudad ON stc.ciudad = t_ciudad.id
                                                                    JOIN
                                                                        t_estado ON stc.estado = t_estado.id
                                                                    JOIN
                                                                        oc_admin ON stc.proyecto = oc_admin.id
                                                                    WHERE
                                                                        stc.estado_ticket IN (1)
                                                                    ');  // Esto se quitó de esta misma línea, del final:    (AND stc.tipo_servicio NOT IN (3, 4) AND stc.estado <> 5)

                                        $query->execute();
                                        $stcs = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($stcs as $stc){
                                            $id = $stc['id'];
                                            $id_stc = $stc['id_stc'];
                                            $fecha_ingreso = $stc['fecha_ingreso'];
                                            $medio_ingreso = $stc['medio_ingreso'];
                                            $servicio = $stc['nombre_servicio'];
                                            $id_producto = $stc['id_producto'];
                                            $falla = $stc['falla'];
                                            $observacion = $stc['observacion'];
                                            $cliente = $stc['nombre_cliente'];
                                            $ciudad = $stc['nombre_ciudad'];
                                            $proyecto = $stc['nombre_proyecto'];
                                            $estado = $stc['nombre_estado'];
                                            $persona_contacto = $stc['persona_contacto'];
                                            $medio_contacto = $stc['email_contacto'];
                                            $evidencia = $stc['evidencias'];
                                            $tipo_servicio = $stc['tipo_servicio'];
                                            $casos = $stc['contador_casos'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $fecha_ingreso; ?></td>
                                                <td><?php echo $id_stc; ?></td>
                                                <td><?php echo $casos; ?></td>
                                                <td><?php echo $cliente; ?></td>
                                                <td><?php echo $ciudad; ?></td>
                                                <td><?php echo $proyecto; ?></td>
                                                <td><?php echo $estado; ?></td>
                                                <td><a href="#" class="servicio-link" data-toggle="modal" data-target="#servicioModal"><?php echo $servicio; ?></a></td>
                                                <!--<td><td><?php echo $id_producto; ?></td>
                                                <td><?php echo $falla; ?></td>
                                                <td><?php echo $observacion; ?></td>                                                
                                                <td><?php echo $persona_contacto; ?></td>
                                                <td><?php echo $medio_contacto; ?></td>
                                                <?php echo $evidencia; ?></td>-->
                                                <!--<td><img src="<?php echo $URL."/img_uploads/". $stc['evidencias'];?>" width="50px" alt=""></td>-->
                                                <td>
                                                    <center>
                                                        <a href="show.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>

                                                        <?php if ($tipo_servicio != 3): // Solo se muestran los botones si $servicio, no es igual a 3 ?>
                                                        <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Tratar <i class="fas fa-pen"></i></a>
                                                        <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
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

                    <div class="card card-blue">
                        <div class="card-header">
                            TICKETS EN TRATAMIENTO
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_stcs61" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha Ingreso</th>
                                            <th>ID STC</th>
                                            <th>Casos</th>
                                            <th>Cliente</th>
                                            <th>Ciudad</th>
                                            <th>Proyecto</th>
                                            <th>Estado</th>
                                            <th>Tipo Servicio</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT stc.*, t_tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_cliente, t_ciudad.ciudad AS nombre_ciudad, t_estado.estadostc AS nombre_estado, oc_admin.lugar_instalacion AS nombre_proyecto FROM stc JOIN t_tipo_servicio ON stc.tipo_servicio = t_tipo_servicio.id JOIN clientes ON stc.cliente = clientes.id JOIN t_ciudad ON stc.ciudad = t_ciudad.id JOIN t_estado ON stc.estado = t_estado.id JOIN oc_admin ON stc.proyecto = oc_admin.id WHERE stc.estado_ticket IN (1) AND stc.tipo_servicio IN (1, 2, 7) AND stc.estado IN(2,4)');  // Esto se quitó de esta misma línea, del final:    (AND stc.tipo_servicio NOT IN (3, 4) AND stc.estado <> 5)

                                        $query->execute();
                                        $stcs = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($stcs as $stc){
                                            $id = $stc['id'];
                                            $id_stc = $stc['id_stc'];
                                            $fecha_ingreso = $stc['fecha_ingreso'];
                                            $medio_ingreso = $stc['medio_ingreso'];
                                            $servicio = $stc['nombre_servicio'];
                                            $id_producto = $stc['id_producto'];
                                            $falla = $stc['falla'];
                                            $observacion = $stc['observacion'];
                                            $cliente = $stc['nombre_cliente'];
                                            $ciudad = $stc['nombre_ciudad'];
                                            $proyecto = $stc['nombre_proyecto'];
                                            $estado = $stc['nombre_estado'];
                                            $persona_contacto = $stc['persona_contacto'];
                                            $medio_contacto = $stc['email_contacto'];
                                            $evidencia = $stc['evidencias'];
                                            $tipo_servicio = $stc['tipo_servicio'];
                                            $casos = $stc['contador_casos'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $fecha_ingreso; ?></td>
                                                <td><?php echo $id_stc; ?></td>
                                                <td><?php echo $casos; ?></td>
                                                <td><?php echo $cliente; ?></td>
                                                <td><?php echo $ciudad; ?></td>
                                                <td><?php echo $proyecto; ?></td>
                                                <td><?php echo $estado; ?></td>
                                                <td><a href="#" class="servicio-link" data-toggle="modal" data-target="#servicioModal"><?php echo $servicio; ?></a></td>
                                                <!--<td><td><?php echo $id_producto; ?></td>
                                                <td><?php echo $falla; ?></td>
                                                <td><?php echo $observacion; ?></td>                                                
                                                <td><?php echo $persona_contacto; ?></td>
                                                <td><?php echo $medio_contacto; ?></td>
                                                <?php echo $evidencia; ?></td>-->
                                                <!--<td><img src="<?php echo $URL."/img_uploads/". $stc['evidencias'];?>" width="50px" alt=""></td>-->
                                                <td>
                                                    <center>
                                                        <a href="show.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>

                                                        <?php if ($tipo_servicio != 3): // Solo se muestran los botones si $servicio, no es igual a 3 ?>
                                                        <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Tratar <i class="fas fa-pen"></i></a>
                                                        <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
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

                    <div class="card card-blue">
                        <div class="card-header">
                            TICKETS CERRADOS
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_stcs" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha Ingreso</th>
                                            <th>ID STC</th>
                                            <th>Casos</th>
                                            <th>Cliente</th>
                                            <th>Ciudad</th>
                                            <th>Proyecto</th>
                                            <th>Estado</th>
                                            <th>Tipo Servicio</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT
                                                                        stc.*,
                                                                        t_tipo_servicio.servicio_stc AS nombre_servicio,
                                                                        clientes.nombre_comercial AS nombre_cliente,
                                                                        t_ciudad.ciudad AS nombre_ciudad,
                                                                        t_estado.estadostc AS nombre_estado,
                                                                        oc_admin.lugar_instalacion AS nombre_proyecto
                                                                    FROM
                                                                        stc
                                                                    JOIN
                                                                        t_tipo_servicio ON stc.tipo_servicio = t_tipo_servicio.id
                                                                    JOIN
                                                                        clientes ON stc.cliente = clientes.id
                                                                    JOIN
                                                                        t_ciudad ON stc.ciudad = t_ciudad.id
                                                                    JOIN
                                                                        t_estado ON stc.estado = t_estado.id
                                                                    JOIN
                                                                        oc_admin ON stc.proyecto = oc_admin.id
                                                                    WHERE
                                                                        stc.estado_ticket IN (2)
                                                                ');

                                        $query->execute();
                                        $stcs = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($stcs as $stc){
                                            $id = $stc['id'];
                                            $id_stc = $stc['id_stc'];
                                            $fecha_ingreso = $stc['fecha_ingreso'];
                                            $medio_ingreso = $stc['medio_ingreso'];
                                            $servicio = $stc['nombre_servicio'];
                                            $id_producto = $stc['id_producto'];
                                            $falla = $stc['falla'];
                                            $observacion = $stc['observacion'];
                                            $cliente = $stc['nombre_cliente'];
                                            $ciudad = $stc['nombre_ciudad'];
                                            $proyecto = $stc['nombre_proyecto'];
                                            $estado = $stc['nombre_estado'];
                                            $persona_contacto = $stc['persona_contacto'];
                                            $medio_contacto = $stc['email_contacto'];
                                            $casos = $stc['contador_casos'];
                                            $evidencia = $stc['evidencias'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                            <td><?php echo $contador; ?></td>
                                                <td><?php echo $fecha_ingreso; ?></td>
                                                <td><?php echo $id_stc; ?></td>
                                                <td><?php echo $casos; ?></td>
                                                <td><?php echo $cliente; ?></td>
                                                <td><?php echo $ciudad; ?></td>
                                                <td><?php echo $proyecto; ?></td>
                                                <td><?php echo $estado; ?></td>
                                                <td><a href="#" class="servicio-link" data-toggle="modal" data-target="#servicioModal"><?php echo $servicio; ?></a></td>
                                                <!--<td><td><?php echo $id_producto; ?></td>
                                                <td><?php echo $falla; ?></td>
                                                <td><?php echo $observacion; ?></td>                                                
                                                <td><?php echo $persona_contacto; ?></td>
                                                <td><?php echo $medio_contacto; ?></td>
                                                <?php echo $evidencia; ?></td>-->
                                                <!--<td><img src="<?php echo $URL."/img_uploads/". $stc['evidencias'];?>" width="50px" alt=""></td>-->
                                                <td>
                                                    <center>
                                                        <a href="show.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
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
        
        <!-- Agregar un campo oculto para almacenar el tipo de servicio -->
        <input type="hidden" id="tipo_servicio" name="tipo_servicio">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- Agregar un boton de aceptar-->
        <button type="button" class="btn btn-primary" onclick="aceptarNivel()">Aceptar</button>
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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Órdenes",
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
    $(function () {
        $("#table_stcs21").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Órdenes",
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
        }).buttons().container().appendTo('#table_stcs21_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    $(function () {
        $("#table_stcs61").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Órdenes",
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
        }).buttons().container().appendTo('#table_stcs61_wrapper .col-md-6:eq(0)');
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

<script>

  function optionSelected(option) {
    // Establecer el valor del campo "tipo_servicio" según la opción seleccionada
    document.getElementById('tipo_servicio').value = option;
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
        // Acciones para la opción 3, enviar una solicitud AJAX para actualizar el estado del servicio
        var id_servicio = <?php echo $id; ?>;
        var nuevo_estado = '3'; // Estado para Nivel 3
        $.ajax({
          url: 'update_service_status.php',
          type: 'POST',
          data: {id_servicio: id_servicio, nuevo_estado: nuevo_estado},
          dataType: 'json',
          success: function(response) {
            if(response.success) {
              // Éxito: Cerrar el modal y realizar otras accionessi es necesario
              $('#servicioModl').modal('hide');
            }else{
              // Error: Mostrar mensaje de error si es necesario
              alert('Error al actulizar el estado del servicio.');
            }
          },
          error: function(xhr, status, error) {
            // Error: Mostrar mensaje de error si es necesario
            alert('Error en la solicitud AJAX.');
          }
        });
        break;
      default:
        // Acciones por defecto
        break;

        }
  }
</script>

<script>
function aceptarNivel() {
    // Cerrar el modal
    $('#servicioModal').modal('hide');

    // Obtener el valor del campo tipo_servicio
    var tipoServicio = document.getElementById('tipo_servicio').value;

    // Actualizar el estado del servicio en función del tipo de servicio seleccionado
    switch(tipoServicio) {
        case '3':
        // Aquí puedes enviar una solicitud AJAX para actualizar el estado del servicio a "3" u "OST"
        // Por ahora, solo mostraremos un mensaje de alrta
        alert('Estado del servicio actualizado a "3" u "OST"');
        break;
    }
}
</script>