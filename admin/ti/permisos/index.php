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
                <h1 class="m-0">Listado de Permisos</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            PERMISOS REGISTRADOS                        
                        </div>
                        <div class="card-tools">
                            <a href="create.php" class="btn btn-warning"><i class="bi bi-plus-square"></i> Crear nuevo permiso</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_permisos" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nro</th>
                                            <th>Nombre de la URL</th>
                                            <th>URL</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador_permisos = 0;
                                        $sql_permisos = "SELECT * FROM permisos WHERE estado = '1' ORDER BY nombre_url ASC";
                                            $query_permisos = $pdo->prepare($sql_permisos);
                                            $query_permisos-> execute();
                                            $permisos = $query_permisos->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($permisos as $permiso){
                                            $id = $permiso['id_permisos'];
                                            $nombre_url = $permiso['nombre_url'];
                                            $url = $permiso['url'];
                                            $contador_permisos = $contador_permisos + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador_permisos; ?></td>
                                                <td><?php echo $nombre_url; ?></td>
                                                <td><?php echo $url; ?></td>
                                                <td>
                                                    <center>
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

<?php include('../../../layout/admin/parte2.php');?>

<script>
    $(function () {
        $("#table_permisos").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Permisos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Permisos",
                "infoFiltered": "(Filtrado de _MAX_ total Permisos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Permisos",
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
        }).buttons().container().appendTo('#table_permisos_wrapper .col-md-6:eq(0)');
    });
</script>