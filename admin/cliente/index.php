<?php 

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php'); // Asegúrate de incluir el archivo que maneja la sesión del usuario
include('../../layout/admin/datos_sesion_user.php');
?>

<?php include('../../layout/admin/parte1.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0">Listado de Pantalla</h1>
                    <div class="card card-blue">
                        <div class="card-header">                            
                            <a href="#" class="d-block"><?php echo $sesion_usuario['nombre'] ?></a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_clientes" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th hidden>ID STC</th>
                                            <th hidden>Fecha Ingreso</th>
                                            <th hidden>medio ingreso</th>
                                            <th hidden>ticket externo</th>
                                            <th hidden>tipo servicio</th>
                                            <th>id producto</th>    
                                            <th>Proyecto</th>
                                            <th>Estado</th>
                                            <th hidden>ciudad</th>
                                            <th hidden>usuario</th>
                                            <th hidden>Cliente</th>
                                            <th hidden>persona contacto</th>
                                            <th hidden>medio contacto</th>
                                            <th hidden>falla</th>
                                            <th hidden>observacion</th>            
                                            <th><center>Accion</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // Contador de pantallas
                                    $contador = 1;
                                    // Obtiene el ID del usuario actual
                                    $id_usuario = $sesion_usuario['id'];

                                    // Realiza una consulta para obtener los registros de la tabla id_producto asociados al usuario actual
                                    $query_producto = $pdo->prepare('SELECT id_producto, nombre_proyecto 
                                        FROM id_producto 
                                        JOIN clientes ON clientes.id = id_producto.cliente 
                                        JOIN usuarios ON usuarios.id = clientes.id_usuario 
                                        WHERE usuarios.id = :id_usuario');
                                    $query_producto->bindParam(':id_usuario',$sesion_usuario['id'], PDO::PARAM_INT);
                                    $query_producto->execute();
                                    $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);

                                    // Obtiene los estados de las pantallas
                                    $query_estado = $pdo->prepare('SELECT estado_pantalla_cliente FROM estado ORDER BY estado_pantalla_cliente');
                                    $query_estado->execute();
                                    $estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);

                                    // Itera sobre los productos y muestra los datos en la tabla
                                    foreach ($productos as $producto) {
                                        $id_producto = $producto['id_producto'];
                                        $proyecto = $producto['nombre_proyecto'];

                                        // Obtiene el estado correspondiente al producto
                                        $estado = '';
                                        foreach ($estados as $estado_item) {
                                            $estado = $estado_item['estado_pantalla_cliente'];
                                        }

                                        // Muestra los datos en la tabla
                                        echo "<tr>";
                                        echo "<td>$contador</td>";
                                        echo "<td>{$id_producto}</td>";
                                        echo "<td>{$proyecto}</td>";
                                        echo "<td>{$estado}</td>";
                                        // Agrega más columnas si es necesario

                                        // Botón de acción
                                        echo "<td>";
                                        echo "<center>";
                                        echo "<a href='create.php?id_producto={$id_producto}&proyecto={$proyecto}' class='btn btn-info btn-sm'>Crear Falla Pantalla<i class='fas fa-eye'></i></a>";
                                        echo "</center>";
                                        echo "</td>";
                                        echo "</tr>";

                                        $contador++; // Incrementa el contador dentro del bucle
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

<?php include('../../layout/admin/parte2.php'); ?>

<script>
    $(function () {
        $("#table_clientes").DataTable({
            "pageLength": 5,
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
        }).buttons().container().appendTo('#table_clientes_wrapper .col-md-6:eq(0)');
    });
</script>
