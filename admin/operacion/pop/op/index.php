<?php

// Incluir archivos necesarios
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
                <h1 class="m-0">OP's por procesar</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            <a href="#" class="d-block invisible"><?php echo $sesion_usuario['nombre'] ?></a>
                        </div>

                        <hr>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_pop" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha Recibido</th>
                                            <th>OP</th>
                                            <th>OC</th>
                                            <th>POP</th>
                                            <th>Proyecto</th>
                                            <th>Tipo Estructura</th>
                                            <th>Cantidad</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        // Ajustada la consulta para contar las repeticiones de id_pop

                                        $query_pop = $pdo->prepare('
                                            SELECT
                                                iop.*,
                                                oc.oc_resultante AS nombre_oc,
                                                oc1.proyecto AS nombre_proyecto
                                            FROM
                                                items_op AS iop
                                            INNER JOIN oc ON iop.id_oc = oc.id
                                            INNER JOIN oc AS oc1 ON iop.proyecto = oc1.id
                                            WHERE iop.habilitar = 0 AND iop.contador_item_op = 1
                                        ');

                                        $query_pop->execute();
                                        $popes = $query_pop->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($popes as $op_items) {

                                            $id = $op_items['id'];
                                            $id_pop = $op_items['id_pop'];
                                            $oc = $op_items['nombre_oc'];
                                            $op = $op_items['id_op'];
                                            $fecha_recibido = $op_items['fecha_recibido'];
                                            $tipo_estructura = $op_items['tipo_estructura'];
                                            $cantidad = $op_items['cantidad'];
                                            $proyecto = $op_items['nombre_proyecto'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $fecha_recibido; ?></td>
                                                <td><?php echo $op; ?></td>
                                                <td><?php echo $oc; ?></td>
                                                <td><?php echo $id_pop; ?></td>
                                                <td><?php echo $proyecto; // Visualización de item_pop y número de repeticiones ?></td>
                                                <td><?php echo $tipo_estructura; ?></td>
                                                <td><?php echo $cantidad; ?></td>
                                                <td>
                                                    <center>
                                                        <a href="show.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                        <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Procesar <i class="fas fa-pen"></i></a>
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


<?php include('../../../../layout/admin/parte2.php');?>


<script>
    $(function () {
        $("#table_pop").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Usuarios",
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
        }).buttons().container().appendTo('#table_pop_wrapper .col-md-6:eq(0)');
    });
</script>
