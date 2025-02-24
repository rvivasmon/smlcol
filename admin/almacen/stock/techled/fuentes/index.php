<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

include('../../../../../layout/admin/parte1.php');

?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                <h1 class="m-0">Stock Principal de Fuentes</h1>                
                    <div class="card card-blue">
                        <div class="card-header">
                            FUENTES ACTIVAS
                        </div>
                        <hr>
                        <div class="card-tools ml-4">
                            <a href="../index.php" class="btn btn-warning"><i class="bi bi-plus-square"></i>Regresar</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_stcs" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Marca Fuente</th>
                                            <th>Tipo Fuente</th>
                                            <th>Voltaje Salida</th>
                                            <th>Modelo Fuente</th>
                                            <th>Posición</th>
                                            <th>Observación</th>
                                            <th>Existencia</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT 
                                            ap.*,
                                            cf.marca_fuente as nombre_marca,
                                            cf1.tipo_fuente as nombre_tipo,
                                            rf.voltaje_salida as nombre_voltaje,
                                            rf.modelo_fuente as nombre_modelo,
                                            da.posiciones as nombre_posicion
                                        FROM
                                            alma_smartled AS ap
                                        INNER JOIN 
                                            referencias_fuente AS rf ON ap.producto = rf.id_referencias_fuentes
                                        LEFT JOIN
                                            caracteristicas_fuentes AS cf ON rf.marca_fuente = cf.id_car_fuen
                                        LEFT JOIN
                                            caracteristicas_fuentes AS cf1 ON rf.tipo_fuente = cf1.id_car_fuen
                                        LEFT JOIN
                                            distribucion_almacen AS da ON ap.posicion = da.id
                                        WHERE
                                            ap.tipo_producto = 3
                                        ');

                                        $query->execute();
                                        $almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($almacenes_pricipales as $almacen_pricipal){
                                            $id = $almacen_pricipal['id_almacen_principal'];
                                            $marca_fuente = $almacen_pricipal['nombre_marca'];
                                            $tipo_fuente = $almacen_pricipal['nombre_tipo'];
                                            $voltaje_salida = $almacen_pricipal['nombre_voltaje'];
                                            $modelo_fuente = $almacen_pricipal['nombre_modelo'];
                                            $posicion = $almacen_pricipal['nombre_posicion'];
                                            $observacion = $almacen_pricipal['observacion'];
                                            $existencia = $almacen_pricipal['cantidad_plena'];
                                            $contador = $contador + 1;

                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $marca_fuente; ?></td>
                                                <td><?php echo $tipo_fuente; ?></td>
                                                <td><?php echo $voltaje_salida; ?></td>
                                                <td><?php echo $modelo_fuente; ?></td>
                                                <td><?php echo $posicion; ?></td>
                                                <td><?php echo $observacion; ?></td>
                                                <td><?php echo $existencia; ?></td>
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


<?php include('../../../../../layout/admin/parte2.php'); ?>

<script>
    $(function () {
        $("#table_stcs").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Fuentes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Fuentes",
                "infoFiltered": "(Filtrado de _MAX_ total Fuentes)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Fuentes",
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
