<?php 

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

?>

<?php include('../../layout/admin/parte1.php');?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                <h1 class="m-0">ID PANTALLAS</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            Identificador
                        </div>

                        <hr>
                        
                        <div class="card-tools ml-4">
                            <a href="create.php" class="btn btn-warning"><i class="bi bi-plus-square">Crear Nuevo ID</i></a>
                        </div>
                        
                        <div class="card-body">
                        <div class="table-responsive">
                                <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ID Producto</th>
                                            <th>OP</th>
                                            <th>POP</th>
                                            <th>Cliente</th>
                                            <th>Ciudad</th>
                                            <th>Proyecto</th>
                                            <th>Lugar de Instalación</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT DISTINCT
                                                                    idp.*,
                                                                    idp.id_producto AS id_producto,
                                                                    op.op AS op,
                                                                    pop_admin.pop AS pop,
                                                                    clientes.nombre_comercial AS cliente,
                                                                    t_ciudad.ciudad AS ciudad,
                                                                    oc_admin.nombre_proyecto AS proyecto,
                                                                    oc_admin.lugar_instalacion AS lugar
                                                                FROM 
                                                                    id_producto as idp
                                                                LEFT JOIN 
                                                                    op ON idp.op = op.id
                                                                LEFT JOIN 
                                                                    pop_admin ON op.pop = pop_admin.id
                                                                LEFT JOIN 
                                                                    oc_admin ON pop_admin.oc = oc_admin.id
                                                                LEFT JOIN 
                                                                    clientes ON oc_admin.cliente = clientes.id
                                                                LEFT JOIN 
                                                                    t_ciudad ON oc_admin.ciudad = t_ciudad.id
                                                            ');

                                        $query->execute();
                                        $productos = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($productos as $producto){
                                            $id = $producto['id'];
                                            $proyecto = $producto['proyecto'];
                                            $op = $producto['op'];
                                            $pop = $producto['pop'];
                                            $id_prod = $producto['id_producto'];
                                            $cliente = $producto['cliente'];
                                            $ciudad = $producto['ciudad'];
                                            $lugar_instalacion = $producto['lugar'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $id_prod; ?></td>
                                                <td><?php echo $op; ?></td>
                                                <td><?php echo $pop; ?></td>
                                                <td><?php echo $cliente; ?></td>
                                                <td><?php echo $ciudad; ?></td>
                                                <td><?php echo $proyecto; ?></td>
                                                <td><?php echo $lugar_instalacion;?></td>
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

<?php include('../../layout/admin/parte2.php');?>

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