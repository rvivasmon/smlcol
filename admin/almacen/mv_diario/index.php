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
                <h1 class="m-0">Movimiento Diario</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            Movimientos
                        </div>
                        <hr>
                        <div class="card-tools ml-4">
                            <a href="create.php" class="btn btn-warning"><i class="bi bi-plus-square"></i> Crear Nuevo Movimiento</a>
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
                                            <th>Cantidas</th>
                                            <th>Descripción</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT * FROM movimiento_diario');
                                        $query->execute();
                                        $movidiarios = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($movidiarios as $movidiario){
                                            $id = $movidiario['id_movimiento_diario'];
                                            $fecha = $movidiario['fecha'];
                                            $producto = $movidiario['producto'];
                                            $referencia1 = $movidiario['referencia_1'];
                                            $referencia2 = $movidiario['referencia_2'];
                                            $almacen_origen = $movidiario['almacen_origen'];
                                            $almacen_destino = $movidiario['almacen_destino'];
                                            $destino = $movidiario['op'];
                                            $cantidades = $movidiario['cantidad_salida'];
                                            $observaciones = $movidiario['observaciones'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $fecha; ?></td>
                                                <td><?php echo $producto; ?></td>
                                                <td><?php echo $referencia1; ?></td>
                                                <td><?php echo $referencia2; ?></td>
                                                <td><?php echo $almacen_origen; ?></td>
                                                <td><?php echo $almacen_destino; ?></td>
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

<?php include('../../../layout/admin/parte2.php'); ?>

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