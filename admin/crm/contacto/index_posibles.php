<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$id_get = $_GET['id']; // El ID que obtienes de la URL

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0">Clientes Contacto</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            ACTIVOS
                        </div>

                        <hr>

                        <div class="card-tools ml-4">
                            <a href="index.php" class="btn btn-warning"><i class="bi bi-plus-square">Volver a Contactos</i></a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_contactos" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Ciudad</th>
                                            <th>Contacto</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;

                                        // Consulta SQL parametrizada
                                        $query = $pdo->prepare("SELECT
                                                                            posible_cliente.*,
                                                                            contactos.nombre AS nombre_contacto
                                                                        FROM
                                                                            posible_cliente
                                                                        JOIN
                                                                            contactos ON posible_cliente.contacto = contactos.id
                                                                        WHERE
                                                                            posible_cliente.contacto = '$id_get'
                                                                        ");
                                        $query->execute(); // Ejecutamos la consulta
                                        $contactos = $query->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($contactos as $contacto) {
                                            $id = $contacto['id'];
                                            $nombre = $contacto['nombre'];
                                            $ciudad = $contacto['ciudad'];
                                            $nombre_contacto = $contacto['nombre_contacto'];
                                            $contador++;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $nombre; ?></td>
                                                <td><?php echo $ciudad; ?></td>
                                                <td><?php echo $nombre_contacto; ?></td>  
                                                <td>
                                                    <center>
                                                        <a href="index_posibles.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar Clientes <i class="fas fa-eye"></i></a>
                                                        <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Editar <i class="fas fa-pen"></i></a>
                                                        <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
                                                        <a href="create_posible_cliente1.php?id=<?php echo $id; ?>" class="btn btn-warning btn-sm">Crear Cliente <i class="fas fa-pen"></i></a>
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
        $("#table_contactos").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Usuarios",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
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
                }]
            }, {
                extend: 'colvis',
                text: 'Visor de columnas',
                collectionLayout: 'fixed three-column'
            }],
        }).buttons().container().appendTo('#table_contactos_wrapper .col-md-6:eq(0)');
    });
</script>
