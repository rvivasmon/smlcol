<?php 

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

include('../../layout/admin/parte1.php');

?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                <h1 class="m-0">Controladoras Creadas</h1>                
                    <div class="card card-blue">
                        <div class="card-header">
                            PRODUCTOS ACTIVOS
                        </div>
                        <hr>
                        <div class="card-tools ml-4">
                            <a href="../almacen/inventario/" class="btn btn-warning"><i class="bi bi-plus-square"></i>REGRESAR</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="table_stcs" class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Marca Control</th>
                                        <th>Funcion Control</th>
                                        <th>referencia Control</th>
                                        <th>Descripción</th>
                                        <th>Fecha Creacion</th>
                                        <th>Habilitado</th>
                                        <th><center>Acciones</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    $query = $pdo->prepare('SELECT
                                                            rc.*,
                                                            cctrl.marca_control AS nombre_marca,
                                                            cctrl1.funcion_control AS nombre_funcion
                                                            FROM
                                                            referencias_control AS rc
                                                            INNER JOIN
                                                            caracteristicas_control AS cctrl ON rc.marca = cctrl.id_car_ctrl
                                                            INNER JOIN
                                                            caracteristicas_control AS cctrl1 ON rc.funcion = cctrl1.id_car_ctrl
                                                            WHERE
                                                            rc.habilitar = "1"
                                                            ');

                                    $query->execute();
                                    $almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($almacenes_pricipales as $almacen_pricipal){
                                        $id = $almacen_pricipal['id_referencia'];
                                        $fecha_ingreso = $almacen_pricipal['CREATED_AT'];
                                        $descripcion = $almacen_pricipal['descripcion'];
                                        $marca_control = $almacen_pricipal['nombre_marca'];
                                        $referencia_control = $almacen_pricipal['referencia'];
                                        $funcion_control = $almacen_pricipal['nombre_funcion'];
                                        $habilitar = $almacen_pricipal['habilitar'];
                                        $contador = $contador + 1;
                                    ?>
                                        <tr>
                                            <td><?php echo $contador; ?></td>
                                            <td><?php echo $marca_control; ?></td>
                                            <td><?php echo $funcion_control; ?></td>
                                            <td><?php echo $referencia_control; ?></td>
                                            <td><?php echo $descripcion; ?></td>
                                            <td><?php echo $fecha_ingreso; ?></td>
                                            <td style="text-align: center; vertical-align: middle;"><input type="checkbox" class="toggle-status" data-id="<?php echo $id; ?>" <?php echo $habilitar == '1' ? 'checked' : ''; ?>></td>
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


<?php include('../../layout/admin/parte2.php'); ?>

<script>
    $(function () {
        $("#table_stcs").DataTable({
            "pageLength": 10,
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

<script>
    $(document).ready(function() {
        $('.toggle-status').change(function() {
            var id = $(this).data('id');
            var habilitado = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: 'actualizar_control1.php',
                method: 'POST',
                data: {
                    id: id,
                    habilitar: habilitado
                },
                success: function(response) {
                    // Puedes manejar la respuesta si es necesario
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
