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
                <h1 class="m-0">Inventario General Almacén Importación</h1>                
                    <div class="card card-blue">
                        <div class="card-header">
                            PRODUCTOS ACTIVOS
                        </div>

                        <hr>

                        <div class="row justify-content-center">
                            <!-- Contenedor principal para los botones -->
                            <div class="card-tools d-flex justify-content-center w-100">
                                <!-- Botón existente para crear un nuevo producto -->
                                <div class="form-group mx-2">
                                    <a href="../../../producto/create_producto.php" class="btn btn-warning">
                                        <i class="bi bi-plus-square"></i> Crear Nuevo Producto
                                    </a>
                                </div>

                                <!-- Botón existente para crear un nuevo movimiento -->
                                <div class="form-group mx-2">
                                    <button type="button" class="btn" style="background-color: #20B2AA; color: white; border-color: #20B2AA;" data-toggle="modal" data-target="#movimientoModal">
                                        <i class="bi bi-plus-square"></i> Crear Nuevo Movimiento
                                    </button>
                                </div>
                            </div>
                        </div>



                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="table_stcs" class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo Producto</th>
                                        <th>Producto</th>
                                        <th>Existencia</th>
                                        <th>Fecha Creacion</th>
                                        <th><center>Acciones</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    $query = $pdo->prepare('SELECT 
                                                            al_im.*,
                                                            productomovido.tipo_producto AS nombre_tipo,
                                                            CASE
                                                                when al_im.tipo_producto = 1 then caracmodulos.serie_modulo
                                                                when al_im.tipo_producto = 2 then refecontrol.referencia
                                                                when al_im.tipo_producto = 3 then refefuentes.modelo_fuente
                                                                else null
                                                            end as nombre_producto
                                                            FROM
                                                                alma_importacion AS al_im
                                                            INNER JOIN
                                                                t_productos AS productomovido ON al_im.tipo_producto = productomovido.id_producto
                                                            LEFT JOIN
                                                                caracteristicas_modulos AS caracmodulos ON al_im.producto = caracmodulos.id_car_mod AND al_im.tipo_producto = 1
                                                            LEFT JOIN
                                                                referencias_control AS refecontrol ON al_im.producto = refecontrol.id_referencia AND al_im.tipo_producto = 2
                                                            LEFT JOIN
                                                                referencias_fuente AS refefuentes ON al_im.producto = refefuentes.id_referencias_fuentes AND al_im.tipo_producto = 3;

                                                        ');

                                    $query->execute();
                                    $almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($almacenes_pricipales as $almacen_pricipal){
                                        $id = $almacen_pricipal['id_importacion'];
                                        $fecha_ingreso = $almacen_pricipal['CREATED_AT'];
                                        $tipo_producto = $almacen_pricipal['nombre_tipo'];
                                        $producto = $almacen_pricipal['nombre_producto'];
                                        $existencia = $almacen_pricipal['existencias'];
                                        $contador = $contador + 1;
                                    ?>
                                        <tr>
                                            <td><?php echo $contador; ?></td>
                                            <td><?php echo $tipo_producto; ?></td>
                                            <td><?php echo $producto; ?></td>
                                            <td><?php echo $existencia; ?></td>
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

                                        <!-- Modal -->
                                        <div class="modal fade" id="movimientoModal" tabindex="-1" aria-labelledby="movimientoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="movimientoModalLabel">Seleccionar Tipo de Movimiento</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <button type="button" class="btn btn-primary btn-block" onclick="location.href='<?php echo $URL;?>admin/almacen/mv_diario/movimiento_entrada/create_movimiento_entrada.php'">Movimiento de Entrada</button>
                                                        <button type="button" class="btn btn-secondary btn-block" onclick="location.href='<?php echo $URL;?>admin/almacen/mv_diario/movimiento_salida/create_movimiento_salida.php'">Movimiento de Salida</button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
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
