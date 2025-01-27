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
                <h1 class="m-0">Inventario Metal Mecánica Procesada</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            Introduzca los datos necesarios
                        </div>

                        <hr>

                        <div class="row">
                            <div class="card-tools ml-4">
                                <a href="inventario/create.php" class="btn btn-warning"><i class="bi bi-plus-square">Movimiento Inventario</i></a>
                            </div>

                            <div class="card-tools ml-4">
                                <a href="tipo" class="btn btn-success"><i class="bi bi-plus-square">Crear Tipo Producto</i></a>
                            </div>

                            <div class="card-tools ml-4">
                                <a href="producto" class="btn btn-secondary"><i class="bi bi-plus-square">Crear Producto</i></a>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>FECHA</th>
                                            <th>CATEGORIA</th>
                                            <th>PRODUCTO</th>
                                            <th>ENTRA</th>
                                            <th>SALE</th>
                                            <th>OBSERVACIÓN</th>
                                            <th>USUARIO</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT mmmp.*, ttp.tipo_prod_mmp AS nombre_tipo, tp.producto AS nombre_producto FROM movimiento_mmp AS mmmp INNER JOIN t_tipo_producto AS ttp ON mmmp.tipo_producto = ttp.id INNER JOIN t_productos AS tp ON mmmp.producto_mmp = tp.id_producto');

                                        $query->execute();
                                        $productos = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($productos as $producto){
                                            $id = $producto['id_movimiento_mmp'];
                                            $fecha = $producto['fecha'];
                                            $tipo = $producto['nombre_tipo'];
                                            $producto_mmp = $producto['nombre_producto'];
                                            $pop = $producto['cantidad_salida'];
                                            $id_prod = $producto['cantidad_entrada'];
                                            $ciudad = $producto['observaciones'];
                                            $cliente = $producto['id_usuario'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $fecha;?></td>
                                                <td><?php echo $tipo; ?></td>
                                                <td><?php echo $producto_mmp; ?></td>
                                                <td><?php echo $id_prod; ?></td>
                                                <td><?php echo $pop; ?></td>
                                                <td><?php echo $ciudad; ?></td>
                                                <td><?php echo $cliente; ?></td>
                                                <td>
                                                    <center>
                                                        <a href="show.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                        <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Editar <i class="fas fa-pen"></i></a >
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