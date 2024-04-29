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
                                        $contador1 = 0;
                                        $query = $pdo->prepare('SELECT * FROM cargo WHERE estado = "1"');

                                        $query->execute();
                                        $cargos = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($cargos as $cargo){
                                            $id_rol = $cargo['id_cargo'];
                                            $descripcion = $cargo['descripcion'];
                                            $contador1 = $contador1 + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador1; ?></td>
                                                <td><?php echo $descripcion; ?></td>
                                                <td>
                                                    <center>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_asignacion<?=$id_rol;?>">Asignar <i class="fas fa-check-circle"></i></button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="modal_asignacion<?=$id_rol;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="background-color:goldenrod">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Asignación de Roles</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            
                                                                            <div class="col-md-3">
                                                                                <input type="hidden" name="rol_id" id="rol_id<?=$id_rol;?>" value="<?=$id_rol;?>">
                                                                                <label>Rol: <?=$cargo['descripcion'];?></label>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <select name="permiso_id" id="permiso_id<?=$id_rol;?>" class="form-control">
                                                                                    <?php
                                                                                    $sql_permisos = "SELECT * FROM permisos WHERE estado = '1' ORDER BY nombre_url ASC";
                                                                                    $query_permisos = $pdo->prepare($sql_permisos);
                                                                                    $query_permisos-> execute();
                                                                                    $permisos = $query_permisos->fetchAll(PDO::FETCH_ASSOC);
                                                                                foreach ($permisos as $permiso){
                                                                                    $id_permiso = $permiso['id_permisos'];
                                                                                    $nombre_url = $permiso['nombre_url'];
                                                                                    $url = $permiso['url'];?>

                                                                                    <option value="<?=$id_permiso?>"><?=$permiso['nombre_url'];?></option>

                                                                                    <?php
                                                                                        }
                                                                                    ?>
                                                                                </select>

                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <button type="submit" class="btn btn-success mb-2 btn_reg" data-id="<?=$id_rol;?>">Confirmar</button>
                                                                            </div>
                                                                        </div>

                                                                        <hr>
                                                                        <div id="respuesta<?=$id_rol;?>"></div>
                                                                        <div class="row"  id="tabla1<?=$id_rol;?>">
                                                                            <table class="table table-bordered table-sm table-striped table-hover">
                                                                                <tr>
                                                                                    <th style="text-align: center; background-color: goldenrod">Nro</th>
                                                                                    <th style="text-align: center; background-color: goldenrod">Rol</th>
                                                                                    <th style="text-align: center; background-color: goldenrod">Permiso</th>
                                                                                    <th style="text-align: center; background-color: goldenrod">Acción</th>
                                                                                </tr>
                                                                                <?php

                                                                                $contador2 = 0;
                                                                                $sql_roles_permisos = "SELECT * FROM roles_permisos AS rolper INNER JOIN permisos AS per ON per.id_permisos = rolper.permiso_id INNER JOIN cargo AS rol ON rol.id_cargo = rolper.rol_id WHERE rolper.estado = '1' ORDER BY per.nombre_url ASC";
                                                                                $query_roles_permisos = $pdo->prepare($sql_roles_permisos);
                                                                                $query_roles_permisos-> execute();
                                                                                $roles_permisos = $query_roles_permisos->fetchAll(PDO::FETCH_ASSOC);
                                                                                    
                                                                                    foreach ($roles_permisos as $rol_permiso) {
                                                                                        if($id_rol == $rol_permiso['rol_id']) {
                                                                                            $id_rol_permiso = $rol_permiso['id_rol_permiso'];
                                                                                            $contador2 = $contador2 + 1;
                                                                                ?>
                                                                                    <tr>
                                                                                        <td><center><?=$contador2;?></center></td>
                                                                                        <td><center><?=$rol_permiso['descripcion'];?></center></td>
                                                                                        <td><?=$rol_permiso['nombre_url'];?></td>
                                                                                        <td>

                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="show.php?id=<?php echo $id_rol; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                        <a href="edit.php?id=<?php echo $id_rol; ?>" class="btn btn-success btn-sm">Editar <i class="fas fa-pen"></i></a>
                                                        <a href="delete.php?id=<?php echo $id_rol; ?>" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
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
    
$(document).ready(function () {
    // Cuando se hace clic en el botón para abrir el modal
    $(".btn-success").click(function () {
        // Obtener el ID del botón que se ha hecho clic
        var id = $(this).data('id');
        
        // Obtener los valores necesarios para la solicitud AJAX
        var a = $(this).closest('tr').find('input[name="rol_id"]').val();
        var b = $(this).closest('tr').find('select[name="permiso_id"]').val();

        // Realizar la solicitud AJAX
        var url = "controller_index_roles_permisos.php";
        $.get(url, {rol_id:a, permiso_id:b}, function (datos) {
            // Actualizar el contenido del contenedor de respuesta
            $('#respuesta' + id).html(datos);
            $('#tabla1<?=$id_rol;?>').css('display', 'none');

        });
    });

        $(".btn_reg").click(function () {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Permiso asignado",
                showConfirmButton: false,
                timer: 5000
                });
            });
        });

</script>

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

