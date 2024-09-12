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
                <h1 class="m-0">Inventario Almacenes</h1>                
                    <div class="card card-blue">
                        <div class="card-header">
                            PRODUCTOS ACTIVOS
                        </div>
                        <hr>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_stcs" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Tipo Producto</th>
                                            <th>Producto</th>
                                            <th>Importación</th>
                                            <th>Principal</th>
                                            <th>TechLed</th>
                                            <th>Planta</th>
                                            <th>Soporte Tecnico</th>
                                            <th>Aliados</th>
                                            <th>Pruebas</th>
                                            <th>Desechados</th>
                                            <th>Técnica</th>
                                            <th>Sub-Total Sale</th>
                                            <th>Salida</th>
                                            <th>Existencia Total Salida</th>
                                            <th>Sub-Total Entra</th>
                                            <th>Entrada</th>
                                            <th>Existencia Total Entrada</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT 
                                                                    at.*,
                                                                    productomovido.tipo_producto AS nombre_tipo,
                                                                CASE
                                                                    when at.tipo_producto = 1 then caracmodulos.serie_modulo
                                                                    when at.tipo_producto = 2 then refecontrol.referencia
                                                                    when at.tipo_producto = 3 then refefuentes.modelo_fuente
                                                                    else null
                                                                end as nombre_producto
                                                                FROM
                                                                    alma_total AS at
                                                                INNER JOIN
                                                                    t_productos AS productomovido ON at.tipo_producto = productomovido.id_producto
                                                                LEFT JOIN
                                                                    caracteristicas_modulos AS caracmodulos ON at.producto = caracmodulos.id_car_mod AND at.tipo_producto = 1
                                                                LEFT JOIN
                                                                    referencias_control AS refecontrol ON at.producto = refecontrol.id_referencia AND at.tipo_producto = 2
                                                                LEFT JOIN
                                                                    referencias_fuente AS refefuentes ON at.producto = refefuentes.id_referencias_fuentes AND at.tipo_producto = 3;
                                                            ');

                                        $query->execute();
                                        $almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($almacenes_pricipales as $almacen_pricipal){
                                            $id = $almacen_pricipal['id_almatotal'];
                                            $fecha_ingreso = $almacen_pricipal['fecha_movimiento'];
                                            $tipo_producto = $almacen_pricipal['nombre_tipo'];
                                            $producto = $almacen_pricipal['nombre_producto'];
                                            $importacion = $almacen_pricipal['importacion'];
                                            $principal = $almacen_pricipal['id_principal'];
                                            $techled = $almacen_pricipal['id_techled'];
                                            $planta = $almacen_pricipal['id_planta'];
                                            $soporte_tecnico = $almacen_pricipal['id_soporte_tecnico'];
                                            $aliados = $almacen_pricipal['id_aliados'];
                                            $pruebas = $almacen_pricipal['id_pruebas'];
                                            $desechados = $almacen_pricipal['id_desechados'];
                                            $tecnica = $almacen_pricipal['id_tecnica'];
                                            $subtotal_sale = $almacen_pricipal['subtotal_sale'];
                                            $salio = $almacen_pricipal['salio'];
                                            $total_sale = $almacen_pricipal['existen_sale'];
                                            $subtotal_entra = $almacen_pricipal['subtotal_entra'];
                                            $entro = $almacen_pricipal['entro'];
                                            $total_entra = $almacen_pricipal['existen_entra'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $fecha_ingreso; ?></td>
                                                <td><?php echo $tipo_producto; ?></td>
                                                <td><?php echo $producto; ?></td>
                                                <td><?php echo $importacion; ?></td>
                                                <td><?php echo $principal; ?></td>
                                                <td><?php echo $techled; ?></td>
                                                <td><?php echo $planta; ?></td>
                                                <td><?php echo $soporte_tecnico; ?></td>
                                                <td><?php echo $aliados; ?></td>
                                                <td><?php echo $pruebas; ?></td>
                                                <td><?php echo $desechados; ?></td>
                                                <td><?php echo $tecnica; ?></td>
                                                <td><?php echo $subtotal_sale; ?></td>
                                                <td><?php echo $salio; ?></td>
                                                <td><?php echo $total_sale; ?></td>
                                                <td><?php echo $subtotal_entra; ?></td>
                                                <td><?php echo $entro; ?></td>
                                                <td><?php echo $total_entra; ?></td>
                                                <td>
                                                    <center>
                                                        <a href="show.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
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


<?php include('../../../../layout/admin/parte2.php'); ?>

<script>
    $(function () {
        $("#table_stcs").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando_START_ a _END_ de _TOTAL_ Órdenes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total Órdenes)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Órdenes",
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
        }).buttons().container().appendTo('#table_stcs_wrapper .col-md-6:eq(0)');
    });
</script>



<script>
  $(document).ready(function() {
    $('.servicio-link').click(function() {
      // Abre el modal correspondiente cuando se hace clic en el enlace del servicio
      $('#servicioModal').modal('show');
    });
  });
</script>
