<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout_techled/admin/sesion.php');
include('../../../../layout_techled/admin/datos_sesion_user.php');

include('../../../../layout_techled/admin/parte1_techled.php');

?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                <h1 class="m-0">Inventario Principal</h1>                
                    <div class="card card-blue">
                        <div class="card-header">
                            PRODUCTOS ACTIVOS
                        </div>
                        <hr>
                        <div class="card-tools ml-4">
                            <a href="create.php" class="btn btn-warning"><i class="bi bi-plus-square"></i> Ingresar Nuevo Producto</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="table_stcs" class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Existencia</th>
                                        <th>Marca Fuente</th>
                                        <th>Modelo Fuente</th>
                                        <th>Tipo Fuente</th>
                                        <th>Voltaje Salida</th>
                                        <th>Fecha Creacion</th>
                                        <th><center>Acciones</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    $query = $pdo->prepare('SELECT 
                                        ap.*,
                                        t_productos.tipo_producto as nombre_producto,

                                        cf.marca_fuente as fuen_marc,
                                        cft.tipo_fuente as fuen_tipo
                                    FROM
                                        alma_smartled AS ap
                                    LEFT JOIN t_productos ON ap.tipo_producto = t_productos.id_producto

                                    LEFT JOIN caracteristicas_fuentes AS cf ON ap.marca_fuente = cf.id_car_fuen
                                    LEFT JOIN caracteristicas_fuentes AS cft ON ap.tipo_fuente = cft.id_car_fuen
                                    WHERE
                                        ap.tipo_producto = 3
                                    ');

                                    $query->execute();
                                    $almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($almacenes_pricipales as $almacen_pricipal){
                                        $id = $almacen_pricipal['id_almacen_principal'];
                                        $fecha_ingreso = $almacen_pricipal['fecha_ingreso'];
                                        $producto = $almacen_pricipal['nombre_producto'];
                                        $marca_fuente = $almacen_pricipal['fuen_marc'];
                                        $modelo_fuente = $almacen_pricipal['modelo_fuente'];
                                        $tipo_fuente = $almacen_pricipal['fuen_tipo'];
                                        $voltaje = $almacen_pricipal['voltaje_salida'];
                                        $existencia = $almacen_pricipal['cantidad_plena'];
                                        $contador = $contador + 1;
                                    ?>
                                        <tr>
                                            <td><?php echo $contador; ?></td>
                                            <td><?php echo $producto; ?></td>
                                            <td><?php echo $existencia; ?></td>
                                            <td><?php echo $marca_fuente; ?></td>
                                            <td><?php echo $modelo_fuente; ?></td>
                                            <td><?php echo $tipo_fuente; ?></td>
                                            <td><?php echo $voltaje; ?></td>
                                            <td><?php echo $fecha_ingreso; ?></td>
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


<?php include('../../../../layout_techled/admin/parte2_techled.php'); ?>

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
