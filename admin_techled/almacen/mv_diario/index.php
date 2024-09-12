<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout_techled/admin/sesion.php');
include('../../../layout_techled/admin/datos_sesion_user.php');

include('../../../layout_techled/admin/parte1_techled.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                <h1 class="m-0">Movimiento Diario General</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            Movimientos
                        </div>

                        <hr>

                        <div clase="row">
                            <div class="card-tools ml-4">
                                <div class="form-group">
                                    <a href="../../producto/create_producto.php" class="btn btn-warning"><i class="bi bi-plus-square"></i> Crear Nuevo Producto</a>
                                </div>
                            </div>

                            <div class="card-tools ml-4">
                                <div class="form-group">
                                    <button type="button" class="btn" style="background-color: #20B2AA; color: white; border-color: #20B2AA;" data-toggle="modal" data-target="#movimientoModal">
                                        <i class="bi bi-plus-square"></i> Crear Nuevo Movimiento
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Producto</th>
                                            <th>Referencia 1</th>
                                            <th>Referencia 2</th>
                                            <th>Almacén Origen</th>
                                            <th>Almacén Destino</th>
                                            <th>Destino</th>
                                            <th>Cantidad</th>
                                            <th>Descripción</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT
                                                                mvdt.*,
                                                                productomovido.tipo_producto AS nombre_producto,
                                                                almacen_origen.nombre_almacen AS almacenes_origen,
                                                                almacen_destino.nombre_almacen AS almacenes_destino,
                                                                CASE
                                                                    WHEN mvdt.tipo_producto = 1 THEN caracmod.pitch
                                                                    WHEN mvdt.tipo_producto = 2 THEN caraccon.marca_control
                                                                    WHEN mvdt.tipo_producto = 3 THEN caracfuen.marca_fuente
                                                                    ELSE NULL
                                                                END AS nombre_referencia_1,
                                                                CASE
                                                                    WHEN mvdt.tipo_producto = 1 THEN caracmodulos.serie_modulo
                                                                    WHEN mvdt.tipo_producto = 2 THEN caraccontrol.referencia
                                                                    WHEN mvdt.tipo_producto = 3 THEN caracfuentes.modelo_fuente
                                                                    ELSE NULL
                                                                END AS nombre_referencia_2
                                                            FROM
                                                                movimiento_diario_techled AS mvdt
                                                            INNER JOIN
                                                                t_productos AS productomovido ON mvdt.tipo_producto = productomovido.id_producto
                                                            INNER JOIN
                                                                t_asignar_todos_almacenes AS almacen_origen ON mvdt.almacen_origen1 = almacen_origen.id_asignacion
                                                            INNER JOIN
                                                                t_asignar_todos_almacenes AS almacen_destino ON mvdt.almacen_destino1 = almacen_destino.id_asignacion
                                                            LEFT JOIN
                                                                caracteristicas_modulos AS caracmod ON mvdt.referencia_1 = caracmod.id_car_mod AND mvdt.tipo_producto = 1
                                                            LEFT JOIN
                                                                caracteristicas_control AS caraccon ON mvdt.referencia_1 = caraccon.id_car_ctrl AND mvdt.tipo_producto = 2
                                                            LEFT JOIN
                                                                caracteristicas_fuentes AS caracfuen ON mvdt.referencia_1 = caracfuen.id_car_fuen AND mvdt.tipo_producto = 3
                                                            LEFT JOIN
                                                                caracteristicas_modulos AS caracmodulos ON mvdt.referencia_2 = caracmodulos.id_car_mod AND mvdt.tipo_producto = 1
                                                            LEFT JOIN
                                                                referencias_control AS caraccontrol ON mvdt.referencia_2 = caraccontrol.id_referencia AND mvdt.tipo_producto = 2
                                                            LEFT JOIN
                                                                referencias_fuente AS caracfuentes ON mvdt.referencia_2 = caracfuentes.id_referencias_fuentes AND mvdt.tipo_producto = 3;
                                                            ');
                                        $query->execute();
                                        $movidiarios = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($movidiarios as $movidiario){
                                            $id = $movidiario['id_movimiento_diario'];
                                            $fecha = $movidiario['fecha'];
                                            $producto = $movidiario['nombre_producto'];
                                            $referencia1 = $movidiario['nombre_referencia_1'];
                                            $referencia2 = $movidiario['nombre_referencia_2'];
                                            $almacen_origen1 = $movidiario['almacenes_origen'];
                                            $almacen_destino1 = $movidiario['almacenes_destino'];
                                            $destino = $movidiario['op'];
                                            $cantidades = $movidiario['cantidad_entrada'];
                                            $observaciones = $movidiario['observaciones'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $fecha; ?></td>
                                                <td><?php echo $producto; ?></td>
                                                <td><?php echo $referencia1; ?></td>
                                                <td><?php echo $referencia2; ?></td>
                                                <td><?php echo $almacen_origen1; ?></td>
                                                <td><?php echo $almacen_destino1; ?></td>
                                                <td><?php echo $destino; ?></td>
                                                <td><?php echo $cantidades; ?></td>
                                                <td><?php echo $observaciones; ?></td>
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
                                                        <button type="button" class="btn btn-primary btn-block" onclick="location.href='<?php echo $URL;?>admin_techled/almacen/mv_diario/movimiento_entrada/create_movimiento_entrada.php'">Movimiento de Entrada</button>
                                                        <button type="button" class="btn btn-secondary btn-block" onclick="location.href='<?php echo $URL;?>admin_techled/almacen/mv_diario/movimiento_salida/create_movimiento_salida.php'">Movimiento de Salida</button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




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

<?php include('../../../layout_techled/admin/parte2_techled.php'); ?>

<script>
    $(function () {
        $("#table_usuarios").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Técnicos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Técnicos",
                "infoFiltered": "(Filtrado de _MAX_ total Técnicos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Técnicos",
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
        }).buttons().container().appendTo('#table_usuarios_wrapper .col-md-6:eq(0)');
    });
</script>