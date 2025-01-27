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
                <h1 class="m-0">Roles SML</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            ROLES REGISTRADOS                        
                        </div>

                        <hr>

                        <div class="card-tools ml-4">
                            <a href="create.php" class="btn btn-warning"><i class="bi bi-plus-square">Crear Nuevo Rol</i></a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_roles" class="table table-striped table-hover table-bordered">
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
                                        $query = $pdo->prepare('SELECT * FROM cargo WHERE estado = "1" ORDER BY descripcion ASC');

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
                                                                        <!-- Contenido del modal -->
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <input type="hidden" name="rol_id" id="rol_id<?=$id_rol;?>" value="<?=$id_rol;?>">
                                                                                <label>Rol: <?=$cargo['descripcion'];?></label>
                                                                            </div>

                                                                            <?php 
                                                                                $query_roles_permisos = $pdo->prepare("SELECT permiso_id FROM roles_permisos WHERE rol_id = :rol_id AND estado = '1'");
                                                                                $query_roles_permisos->bindParam(':rol_id', $id_rol, PDO::PARAM_INT);
                                                                                $query_roles_permisos->execute();
                                                                                $assigned_permissions = $query_roles_permisos->fetchAll(PDO::FETCH_COLUMN);
                                                                            ?>

                                                                            <div class="col-md-6">
                                                                                <select name="permiso_id" id="permiso_id<?=$id_rol;?>" class="form-control">
                                                                                    <?php
                                                                                    $sql_permisos = "SELECT * FROM t_permisos WHERE estado = '1' ORDER BY nombre_url ASC";
                                                                                    $query_permisos = $pdo->prepare($sql_permisos);
                                                                                    $query_permisos->execute();
                                                                                    $permisos = $query_permisos->fetchAll(PDO::FETCH_ASSOC);

                                                                                    foreach ($permisos as $permiso) {
                                                                                        if (!in_array($permiso['id_permisos'], $assigned_permissions)) {
                                                                                            $id_permiso = $permiso['id_permisos'];
                                                                                            $nombre_url = $permiso['nombre_url'];
                                                                                            $url = $permiso['url'];
                                                                                            echo "<option value=\"$id_permiso\">$nombre_url</option>";
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <button type="submit" class="btn btn-success mb-2 btn_reg" data-id="<?=$id_rol;?>">Confirmar</button>
                                                                            </div>
                                                                        </div>

                                                                        <hr>
                                                                        <div id="respuesta<?=$id_rol;?>">
                                                                            <div class="row" id="tabla1<?=$id_rol;?>">
                                                                                <table class="table table-bordered table-sm table-striped table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th style="text-align: center; background-color: goldenrod">Nro</th>
                                                                                            <th style="text-align: center; background-color: goldenrod">Rol</th>
                                                                                            <th style="text-align: center; background-color: goldenrod">Permiso</th>
                                                                                            <th style="text-align: center; background-color: goldenrod">Acción</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                        $contador2 = 0;
                                                                                        $sql_roles_permisos = "SELECT * FROM roles_permisos AS rolper INNER JOIN t_permisos AS per ON per.id_permisos = rolper.permiso_id INNER JOIN cargo AS rol ON rol.id_cargo = rolper.rol_id WHERE rolper.estado = '1' ORDER BY per.nombre_url ASC";
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
                                                                                                <td><center><?=$rol_permiso['nombre_url'];?></center></td>
                                                                                                <td>
                                                                                                    <center>
                                                                                                        <form action="controller_delete_rol_permiso.php" onclick="preguntar<?=$id_rol_permiso;?>(event)" method="post" id="miFormulario<?=$id_rol_permiso;?>">
                                                                                                            <input type="text" name="id_rol_permiso" value="<?=$id_rol_permiso;?>" hidden>
                                                                                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Borrar</button>
                                                                                                        </form>
                                                                                                    </center>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <?php } ?>
                                                                                        <?php } ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Fin Modal -->

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
    var id = $(this).data('id');
    var rol_id = $(`#rol_id${id}`).val();
    var permiso_id = $(`#permiso_id${id}`).val();

        if (rol_id && permiso_id) {
            $.get("controller_index_roles_permisos.php", { rol_id, permiso_id }, function (datos) {
                $(`#respuesta${id}`).html(datos);
                $(`#tabla1${id}`).hide();
            }).fail(function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudo asignar el permiso.",
                });
            });
        } else {
            Swal.fire({
                icon: "warning",
                title: "Campos incompletos",
                text: "Seleccione un permiso antes de confirmar.",
            });
        }
    });


    $(".btn_reg").click(function () {
    // ID del rol
    var id = $(this).data('id');
    var rol_id = $(`#rol_id${id}`).val();
    var permiso_id = $(`#permiso_id${id}`).val();

        if (rol_id && permiso_id) {
            // Realizar solicitud AJAX
            $.ajax({
                url: "controller_index_roles_permisos.php", // Ruta del controlador
                method: "POST", // Método para enviar los datos
                data: { rol_id: rol_id, permiso_id: permiso_id }, // Datos a enviar
                success: function (response) {
                    // Mostrar notificación de éxito
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Permiso asignado",
                        showConfirmButton: false,
                        timer: 3000
                    });

                    // Actualizar el contenido del select
                    $.ajax({
                        url: "get_updated_permissions.php", // Ruta para obtener los datos actualizados
                        method: "GET",
                        data: { rol_id: rol_id },
                        success: function (data) {
                            // Reemplazar las opciones del select con las nuevas
                            $(`#permiso_id${id}`).html(data);
                        },
                        error: function () {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "No se pudo actualizar la lista de permisos.",
                            });
                        }
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se pudo asignar el permiso.",
                    });
                }
            });
        } else {
            Swal.fire({
                icon: "warning",
                title: "Campos incompletos",
                text: "Seleccione un permiso antes de confirmar.",
            });
        }
    });
});
</script>

<script>
    $(function () {
        $("#table_roles").DataTable({
            "pageLength": 25,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Roles",
                "infoEmpty": "Mostrando 0 a 0 de 0 Roles",
                "infoFiltered": "(Filtrado de _MAX_ total Roles)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Roles",
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

<script>
    function preguntar<?=$id_rol_permiso;?>(event) {
    event.preventDefault();
    swal.fire({
        title: 'Eliminar registro',
        text: '¿Desea eliminar este registro?',
        icon: 'question',
        showDenyButton: true,
        confirmButtonText: 'Eliminar',
        confirmButtonColor: '#a5161d',
        denyButtonColor: '#270a0a',
    }).then((result) => {
        if (result.isConfirmed) {
            var form = $('#miFormulario<?=$id_rol_permiso;?>');
            form.submit ();
        }
    });
    }
</script>

<script>
    $(document).ready(function() {
    // Función para filtrar las opciones del select
    function filtrarOpciones() {
        var valoresTabla = [];
        $('#tabla1 tr').each(function() {
            var valorTabla = $(this).find('td:nth-child(2)').text(); // Ajusta el selector según la estructura de tu tabla
            valoresTabla.push(valorTabla);
        });

        $('#permiso_id<?=$id_rol;?> option').each(function() {
            var valorOpcion = $(this).val();
            if (valoresTabla.indexOf(valorOpcion) === -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

        // Llamar a la función al cargar la página
    filtrarOpciones();

// Llamar a la función cuando se cambia el contenido de la tabla
$('#tabla1').on('change', 'input', filtrarOpciones); // Ejemplo con un evento change en los inputs de la tabla
});
</script>