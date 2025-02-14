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
                                            <th>POP</th>
                                            <th>Item POP</th>
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
                                                op.*,
                                                pop.pop AS nombre_pop,
                                                ipp.contador AS nombre_item_pop,
                                                ipp.item1 AS numero_items
                                            FROM
                                                items_op AS op
                                            INNER JOIN
                                                pop ON op.id_pop = pop.id
                                            INNER JOIN
                                                items_pop AS ipp ON op.id_item_pop = ipp.id
                                        ');

                                        /*
                                        ($query_pop = $pdo->prepare('
                                            SELECT 
                                                op.*,
                                                pop.pop AS nombre_pop,
                                                ipp.contador AS nombre_item_pop,
                                                (SELECT COUNT(*) FROM items_op WHERE id_pop = op.id_pop) AS numero_items
                                            FROM
                                                items_op AS op
                                            INNER JOIN
                                                pop ON op.id_pop = pop.id
                                            INNER JOIN
                                                items_pop AS ipp ON op.id_item_pop = ipp.id
                                            ');)
                                        */

                                        $query_pop->execute();
                                        $popes = $query_pop->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($popes as $pop_item) {

                                            $id = $pop_item['id'];
                                            $id_pop = $pop_item['nombre_pop'];
                                            $op = $pop_item['id_op'];
                                            $item_pop = $pop_item['nombre_item_pop'];
                                            $fecha_recibido = $pop_item['fecha_recibido'];
                                            $tipo_estructura = $pop_item['tipo_estructura'];
                                            $cantidad = $pop_item['cantidad'];
                                            $numero_items = $pop_item['numero_items']; // Número de veces que se repite id_pop
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $fecha_recibido; ?></td>
                                                <td><?php echo $op; ?></td>
                                                <td><?php echo $id_pop; ?></td>
                                                <td><?php echo $item_pop . ' / ' . $numero_items; // Visualización de item_pop y número de repeticiones ?></td>
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
