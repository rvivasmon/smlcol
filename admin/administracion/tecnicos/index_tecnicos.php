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
                <h1 class="m-0">Usuarios SML</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            ACTIVOS
                        </div>

                        <hr>

                        <div class="card-tools ml-4">
                            <a href="create_tecnicos.php" class="btn btn-warning"><i class="bi bi-plus-square"></i> Crear nuevo técnico</a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Documento</th>
                                            <th>Usuario</th>
                                            <th>Ciudad</th>
                                            <th>Estado General</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT tecnicos.*, t_estado.estado_general AS estado_tecnicos, t_ciudad.ciudad AS ciudad_tecnico FROM tecnicos  JOIN t_ciudad ON tecnicos.ciudad = t_ciudad.id JOIN t_estado ON tecnicos.estado_general = t_estado.id WHERE tecnicos.estado_general = "1"');

                                        $query->execute();
                                        $tecnicos = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($tecnicos as $tecnico){
                                            $id = $tecnico['id'];
                                            $nombre = $tecnico['nombre'];
                                            $documento = $tecnico['docident'];
                                            $usuario_uso = $tecnico['usuario'];
                                            $ciudad = $tecnico['ciudad_tecnico'];
                                            $estado_general = $tecnico['estado_tecnicos'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $nombre; ?></td>
                                                <td><?php echo $documento; ?></td>
                                                <td><?php echo $usuario_uso; ?></td>
                                                <td><?php echo $ciudad; ?></td>
                                                <td><?php echo $estado_general; ?></td>
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

<?php include('../../../layout/admin/parte2.php');?>

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