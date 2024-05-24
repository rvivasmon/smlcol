<?php 

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
                <h1 class="m-0">Solicitudes SML / TL</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            ACTIVAS
                        </div>

                        <hr>

                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="table_tracking" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th> <!-- Checkbox para seleccionar todos -->
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Observación</th>
                                    <th>Terminado</th>
                                    <th><center>Acciones</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = 0;
                                $query = $pdo->prepare('SELECT * FROM tracking WHERE status = "2"');

                                $query->execute();
                                $trackings = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($trackings as $tracking){
                                    $id = $tracking['id'];
                                    $date = $tracking['date_status'];
                                    $type = $tracking['type'];
                                    $category = $tracking['category'];
                                    $quantitly = $tracking['quantitly'];
                                    $obscolombia = $tracking['observaciones_colombia'];
                                    $finished = $tracking['finished'];
                                    $contador = $contador + 1;

                                    // Reemplazar el valor numérico por el texto correspondiente
                                    if ($finished == 0) {
                                        $finished_text = '';
                                    } elseif ($finished == 1) {
                                        $finished_text = 'NO';
                                    } elseif ($finished == 2) {
                                        $finished_text = 'SÍ';
                                    } else {
                                        $finished_text = $finished; // Por si acaso hay otros valores inesperados
                                    }
                                ?>
                                    <tr>
                                        <td><input type="checkbox" class="record-checkbox" value="<?php echo $id; ?>"></td> <!-- Checkbox por registro -->
                                        <td><a href="<?php echo $URL; ?>admin/administracion/tracking/tracking_chi/show_tracking.php?id=<?php echo $id; ?>"><?php echo $contador; ?></a></td>
                                        <td><?php echo $date; ?></td>
                                        <td><?php echo $type; ?></td>
                                        <td><?php echo $category; ?></td>
                                        <td><?php echo $quantitly; ?></td>
                                        <td><?php echo $obscolombia; ?></td>
                                        <td><?php echo $finished_text; ?></td>
                                        <td>
                                            <center>
                                                <a href="show_tracking_terminado.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Procesar <i class="fas fa-eye"></i></a>
                                                <a href="edit_tracking.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Terminar <i class="fas fa-pen"></i></a>
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

<?php include('../../../../layout/admin/parte2.php');?>

<script>
    $(function () {
        $("#table_tracking").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Solicitudes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Solicitudes",
                "infoFiltered": "(Filtrado de _MAX_ total Solicitudes)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Solicitudes",
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

        // Select/Deselect all checkboxes
        $('#select-all').click(function() {
        var checked = this.checked;
        $('.record-checkbox').each(function() {
            this.checked = checked;
        });
    });
</script>