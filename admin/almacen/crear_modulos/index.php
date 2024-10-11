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
                            <a href="create.php" class="btn btn-warning"><i class="bi bi-plus-square">Crear Nuevo Modulo</i></a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Pitch</th>
                                            <th>Categoria</th>
                                            <th>Sub Categ.</th>
                                            <th>Tipo</th>
                                            <th>Medida</th>
                                            <th>Nits</th>
                                            <th>Refresh</th>
                                            <th>Standard</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT
                                                                        tm.*,
                                                                        categoria.producto_uso AS nombre_categoria,
                                                                        tapit.pitch AS nombre_pitch, 
                                                                        tipo_producto.tipo_producto21 AS nombre_producto,
                                                                        t_modulo.tipo AS nombre_tipo,
                                                                        tamanos.tamanos_modulos AS nombre_tamano,
                                                                        nits.nits AS nombre_nits,
                                                                        refresh.refresh AS nombre_refresh
                                                                    FROM
                                                                        tabla_modulos AS tm
                                                                    JOIN t_uso_productos as categoria ON tm.categoria = categoria.id_uso
                                                                    JOIN tabla_pitch  AS tapit ON tm.pitch = tapit.id
                                                                    JOIN t_tipo_producto AS tipo_producto ON tm.producto = tipo_producto.id
                                                                    JOIN tabla_tipo_modulo AS t_modulo ON tm.tipo = t_modulo.id
                                                                    JOIN tabla_tamanos_modulos AS tamanos ON tm.medida = tamanos.id
                                                                    JOIN tabla_nits_refresh AS nits ON tm.nits = nits.id
                                                                    JOIN tabla_nits_refresh AS refresh ON tm.refresh = refresh.id

                                                                    ');

                                        $query->execute();
                                        $modulos = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($modulos as $modulo){
                                            $id = $modulo['id_mod'];
                                            $categoria = $modulo['nombre_categoria'];
                                            $pitch = $modulo['nombre_pitch'];
                                            $sub = $modulo['nombre_producto'];
                                            $tipo = $modulo['nombre_tipo'];
                                            $medidas = $modulo['nombre_tamano'];
                                            $nits = $modulo['nombre_nits'];
                                            $refresh = $modulo['nombre_refresh'];
                                            $standard = $modulo['standard'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $pitch; ?></td>
                                                <td><?php echo $categoria; ?></td>
                                                <td><?php echo $sub; ?></td>
                                                <td><?php echo $tipo; ?></td>
                                                <td><?php echo $medidas; ?></td>
                                                <td><?php echo $nits; ?></td>
                                                <td><?php echo $refresh; ?></td>
                                                <td>
                                                    <div style="display: flex; justify-content: center; align-items: center;">
                                                    <input type="checkbox" name="standard_<?php echo $id; ?>" value="1" <?php echo ($standard == 1) ? 'checked' : ''?>>
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

<?php include('../../../layout/admin/parte2.php');?>

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