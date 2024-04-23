<?php 

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

?>

<?php include('../../layout/admin/parte1.php'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0">LIST PRICE EQUIPMENT & ACCESSORIES - TECHLED</h1>
                        <div class="card card-blue">
                            <div class="card-header">
                                PRICE
                            </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla_pre_ost" class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Module_displays</th>
                                        <th>Cabinet</th>
                                        <th>LCD</th>
                                        <th>System and Control</th>
                                        <th>Equipament and Accessories</th>
                                        <th>Hologram</th>
                                        <th>Led Rental Display</th>
                                        <th><center>Acciones</center></th>
                                    </tr>
                                </thead>
                            <tbody>
                                <?php
                                $contador = 0;
                                $query = $pdo->prepare('SELECT * FROM price_equipment_accessories_techled');

                                $query->execute();
                                $lists = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($lists as $list){
                                    $id = $list['id_price'];
                                    $module = $list['module_displays'];
                                    $cabinet = $list['cabinet'];
                                    $lcd = $list['lcd'];
                                    $system = $list['system_control'];
                                    $equipament = $list['equipament_accessories'];
                                    $hologram = $list['hologram'];
                                    $rental = $list['led_rental_display'];

                                    $contador = $contador + 1; 
                                ?>
                                    <tr>
                                        <td><?php echo $contador; ?></td>
                                        <td><?php echo $module; ?></td>
                                        <td><?php echo $cabinet; ?></td>
                                        <td><?php echo $lcd; ?></td>
                                        <td><?php echo $system; ?></td>
                                        <td><?php echo $equipament; ?></td>
                                        <td><?php echo $hologram; ?></td>
                                        <td><?php echo $rental; ?></td>
                                        <td>
                                            <center>
                                                <a href="show_index.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                <a href="edit_index.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Editar <i class="fas fa-pen"></i></a>
                                                <a href="delete_index.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
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
        $("#tabla_pre_ost").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando_START_ a _END_ de _TOTAL_ Órdenes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Órdenes",
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
        }).buttons().container().appendTo('#tabla_pre_ost_wrapper .col-md-6:eq(0)');
    });
</script>
