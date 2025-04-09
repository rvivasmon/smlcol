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
                <h1 class="m-0">Clientes SML</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            ACTIVOS
                        </div>
                        <div class="card-tools">
                            <a href="create_tracking.php" class="btn btn-warning"><i class="bi bi-plus-square"></i> Crear nuevo permiso</a>
                        </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="table_tracking" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>En Producción</th>
                                    <th>SHIP</th>
                                    <th>En Transito</th>
                                    <th>Guía</th>
                                    <th>Fecha Guía</th>
                                    <th>Tipo Envío</th>
                                    <th>Observaciones</th>
                                    <th><center>Acciones</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = 0;
                                $query = $pdo->prepare('SELECT * FROM tracking');

                                $query->execute();
                                $trackings = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($trackings as $tracking){
                                    $id = $tracking['id'];
                                    $fecha = $tracking['date'];
                                    $tipo = $tracking['type'];
                                    $descripcion = $tracking['observaciones_china'];
                                    $cantidad = $tracking['quantitly'];
                                    $enproduccion = $tracking['en_produccion'];
                                    $ship = $tracking['ship'];
                                    $entransito = $tracking['num_envoys'];
                                    $guia = $tracking['guia'];
                                    $fechaguia = $tracking['fecha_guia'];
                                    $tipoenvio = $tracking['tipo_envio'];
                                    $observaciones = $tracking['observaciones_colombia'];
                                    $contador = $contador + 1;
                                ?>
                                    <tr>
                                        <td><?php echo $contador; ?></td>
                                        <td><?php echo $fecha; ?></td>
                                        <td><?php echo $tipo; ?></td>
                                        <td><?php echo $descripcion; ?></td>
                                        <td><?php echo $cantidad; ?></td>
                                        <td><?php echo $enproduccion; ?></td>
                                        <td><?php echo $ship; ?></td>
                                        <td><?php echo $entransito; ?></td>
                                        <td><?php echo $guia; ?></td>
                                        <td><?php echo $fechaguia; ?></td>
                                        <td><?php echo $tipoenvio; ?></td>
                                        <td><?php echo $observaciones; ?></td>
                                        <td>
                                            <center>
                                                <a href="show_tracking.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                <a href="edit_tracking.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Editar <i class="fas fa-pen"></i></a>
                                                <a href="delete_tracking.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
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

<?php include('../../../layout/admin/parte2.php');?>

<script>
    $(function () {
        $("#table_tracking").DataTable({
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
        }).buttons().container().appendTo('#table_tracking_wrapper .col-md-6:eq(0)');
    });
</script>