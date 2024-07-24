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
                <h1 class="m-0">PRE PROYECTOS</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            Identificador
                        </div>

                        <hr>

                        <div class="card-tools ml-4">
                            <a href="create.php" class="btn btn-warning"><i class="bi bi-plus-square">Crear Nuevo Pre</i></a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>ID</th>
                                            <th>Nombre Pre-Proyecto</th>
                                            <th>Nombre Cliente</th>
                                            <th>Contacto</th>
                                            <th>Ciudad</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT * FROM pre_proyecto');

                                        $query->execute();
                                        $productos = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($productos as $producto){
                                            $id = $producto['id_preproyec'];
                                            $fecha = $producto['fecha'];
                                            $id_prod = $producto['idprepro'];
                                            $nombre_proyecto = $producto['nombre_preproyecto'];
                                            $cliente = $producto['cliente'];
                                            $contacto = $producto['contacto'];
                                            $ciudad = $producto['ciudad'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $fecha; ?></td>
                                                <td><?php echo $id_prod; ?></td>
                                                <td><?php echo $nombre_proyecto; ?></td>
                                                <td><?php echo $cliente; ?></td>
                                                <td><?php echo $contacto; ?></td>
                                                <td><?php echo $ciudad; ?></td>
                                                <td>
                                                    <center>
                                                        <a href="<?php echo $URL."admin/crm/proyectos/create.php";?>?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Tratamiento<i class="fas fa-pen"></i></a>
                                                        <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Borrar<i class="fas fa-trash"></i></a>
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
                "info": "Mostrando_START_ a _END_ de _TOTAL_ Usuarios",
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
        }).buttons().container().appendTo('#table_usuarios_wrapper .col-md-6:eq(0)');
    });
</script>