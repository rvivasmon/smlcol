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
                <h1 class="m-0">Cargos SML</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            CARGOS REGISTRADOS                        
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cargos</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT * FROM cargo WHERE estado = "1"');

                                        $query->execute();
                                        $cargos = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($cargos as $cargo){
                                            $id = $cargo['id_cargo'];
                                            $descripcion = $cargo['descripcion'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $descripcion; ?></td>
                                                <td>
                                                    <center>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_asignacion<?=$id;?>">Asignar <i class="fas fa-check-circle"></i></button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="modal_asignacion<?=$id;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="background-color:goldenrod">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Asignación de Roles</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    
                                                                    <form class="form-inline" action="" method="POST">
                                                                        <div class="form-group mb-2">
                                                                            <label>Rol: <?=$cargo['descripcion'];?></label>
                                                                        </div>
                                                                        <div class="form-group mx-sm-4 mb-2">
                                                                            <select name="" id="" class="form-control">
                                                                                <?php
                                                                                $sql_permisos = "SELECT * FROM permisos WHERE estado = '1' ORDER BY nombre_url ASC";
                                                                                $query_permisos = $pdo->prepare($sql_permisos);
                                                                                $query_permisos-> execute();
                                                                                $permisos = $query_permisos->fetchAll(PDO::FETCH_ASSOC);
                                                                            foreach ($permisos as $permiso){
                                                                                $id = $permiso['id_permisos'];
                                                                                $nombre_url = $permiso['nombre_url'];
                                                                                $url = $permiso['url'];?>

                                                                                <option value="<?=$id?>"><?=$nombre_url?></option>

                                                                                <?php
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-warning mb-2">Asignar</button>
                                                                    </form>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-warning">Save changes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
            "pageLength": 5,
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