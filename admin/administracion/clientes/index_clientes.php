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

                        <hr>

                        <div class="card-tools ml-4">
                            <a href="create_cliente.php" class="btn btn-warning"><i class="bi bi-plus-square">Crear Nuevo Cliente</i></a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_clientes" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre Comercial</th>
                                            <th>Razón Social</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>Contacto</th>
                                            <th>Teléfono Contacto</th>
                                            <th>NIT</th>
                                            <th>Web</th>
                                            <th>Dirección</th>
                                            <th>Ciudad</th>
                                            <th>Departamento</th>
                                            <th>País</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT * FROM clientes');

                                        $query->execute();
                                        $clientes = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($clientes as $cliente){
                                            $id = $cliente['id'];
                                            $nombre = $cliente['nombre_comercial'];
                                            $razon = $cliente['razon_social'];
                                            $email = $cliente['email'];
                                            $telefono = $cliente['telefono'];
                                            $contacto = $cliente['contacto'];
                                            $celular = $cliente['celular'];
                                            $nit = $cliente['nit'];
                                            $web = $cliente['web'];
                                            $direccion = $cliente['direccion'];
                                            $ciudad = $cliente['ciudad'];
                                            $departamento = $cliente['departamento'];
                                            $pais = $cliente['pais'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $nombre; ?></td>
                                                <td><?php echo $razon; ?></td>
                                                <td><?php echo $email; ?></td>
                                                <td><?php echo $telefono; ?></td>
                                                <td><?php echo $contacto; ?></td>
                                                <td><?php echo $celular; ?></td>
                                                <td><?php echo $web; ?></td>
                                                <td><?php echo $nit; ?></td>
                                                <td><?php echo $direccion; ?></td>
                                                <td><?php echo $ciudad; ?></td>
                                                <td><?php echo $departamento; ?></td>
                                                <td><?php echo $pais; ?></td>
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
        $("#table_clientes").DataTable({
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
        }).buttons().container().appendTo('#table_clientes_wrapper .col-md-6:eq(0)');
    });
</script>