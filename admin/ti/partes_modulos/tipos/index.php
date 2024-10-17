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
                <h1 class="m-0">Tipos de Productos</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            ACTIVOS
                        </div>

                        <hr>

                        <div class="row">
                            <div class="card-tools ml-4">
                                <a href="../nits/create.php" class="btn btn-warning"><i class="bi bi-plus-square"></i><strong>Crear Nuevo NITS</strong></a>
                            </div>

                            <div class="card-tools ml-4">
                                <a href="../pitch/create.php" class="btn btn-warning"><i class="bi bi-plus-square"></i><strong>Crear Nuevo PITCH</strong></a>
                            </div>

                            <div class="card-tools ml-4">
                                <a href="../refresh/create.php" class="btn btn-warning"><i class="bi bi-plus-square"></i><strong>Crear Nuevo REFRESH</strong></a>
                            </div>

                            <div class="card-tools ml-4">
                                <a href="../tamanos/create.php" class="btn btn-warning"><i class="bi bi-plus-square"></i> <strong>Crear Nuevo TAMAÑO</strong></a>
                            </div>

                            <div class="card-tools ml-4">
                                <a href="../tipos/create.php" class="btn btn-warning"><i class="bi bi-plus-square"></i><strong>Crear Nuevo TIPO</strong></a>
                            </div>

                            <div class="card-tools ml-4">
                                <a href="../productos/create.php" class="btn btn-warning"><i class="bi bi-plus-square"></i><strong>Crear Nuevo PRODUCTO</strong></a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>TIPOS PRODUCTOS</th>
                                            <th>Habilitado</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT * FROM tabla_tipo_modulo WHERE tipo IS NOT NULL AND tipo != "" ORDER BY tipo');
                                        $query->execute();
                                        $tipos = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($tipos as $tipo){
                                            $id = $tipo['id'];
                                            $nombre_tipo = $tipo['tipo'];
                                            $habilitado = $tipo['habilitar_tipo'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $nombre_tipo; ?></td>
                                                <td>
                                                    <div style="display: flex; justify-content: center; align-items: center;">
                                                    <input type="checkbox" name="habilitado_<?php echo $id; ?>" value="1" <?php echo ($habilitado == 1) ? 'checked' : ''?>>
                                                    </div>
                                                </td>
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

<?php include('../../../../layout/admin/parte2.php');?>

<script>
    $(function () {
        $("#table_usuarios").DataTable({
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
        }).buttons().container().appendTo('#table_usuarios_wrapper .col-md-6:eq(0)');
    });
</script>