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
                <h1 class="m-0">Inventario Principal de Módulos</h1>                
                    <div class="card card-blue">
                        <div class="card-header">
                            MóDULOS ACTIVOS
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
                                            <th>Pitch</th>
                                            <th>Uso</th>
                                            <th>Modelo Modulo</th>
                                            <th>Serie Modulo</th>
                                            <th>Referencia</th>
                                            <th>Tamaño</th>
                                            <th>Observación</th>
                                            <th>Posición</th>
                                            <th>Existencia</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT 
                                            ap.*,
                                            tup.producto_uso as nombre_uso,
                                            tp.pitch as nombre_pitch,
                                            ttp.modelo_modulo as nombre_modelo,
                                            pmc.serie as nombre_serie,
                                            pmc.referencia as nombre_referencia,
                                            ttm.tamanos_modulos as nombre_tamano,
                                            da.posiciones as nombre_posicion
                                        FROM
                                            alma_principal AS ap
                                        INNER JOIN 
                                            producto_modulo_creado AS pmc ON ap.producto = pmc.id
                                        LEFT JOIN
                                            tabla_pitch AS tp ON pmc.pitch = tp.id
                                        LEFT JOIN
                                            t_tipo_producto AS ttp ON pmc.modelo = ttp.id
                                        LEFT JOIN
                                            tabla_tamanos_modulos AS ttm ON pmc.tamano = ttm.id
                                        LEFT JOIN
                                            t_uso_productos AS tup ON pmc.uso = tup.id_uso
                                        LEFT JOIN
                                            distribucion_almacen AS da ON ap.posicion = da.id
                                        WHERE
                                            ap.tipo_producto = 1
                                        ');

                                        $query->execute();
                                        $almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($almacenes_pricipales as $almacen_pricipal){
                                            $id = $almacen_pricipal['id_almacen_principal'];
                                            $posicion = $almacen_pricipal['nombre_posicion'];
                                            $uso = $almacen_pricipal['nombre_uso'];
                                            $pitch = $almacen_pricipal['nombre_pitch'];
                                            $modelo_modulo = $almacen_pricipal['nombre_modelo'];
                                            $serie_modulo = $almacen_pricipal['nombre_serie'];
                                            $referencia_modulo = $almacen_pricipal['nombre_referencia'];
                                            $tamano = $almacen_pricipal['nombre_tamano'];
                                            $existencia = $almacen_pricipal['cantidad_plena'];
                                            $observacion = $almacen_pricipal['observacion'];
                                            $contador = $contador + 1;

                                        ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $pitch; ?></td>
                                                <td><?php echo $uso; ?></td>
                                                <td><?php echo $modelo_modulo; ?></td>
                                                <td><?php echo $serie_modulo; ?></td>
                                                <td><?php echo $referencia_modulo; ?></td>
                                                <td><?php echo $tamano; ?></td>
                                                <td><?php echo $observacion; ?></td>
                                                <td><?php echo $posicion; ?></td>
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
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Módulos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Módulos",
                "infoFiltered": "(Filtrado de _MAX_ total Módulos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Módulos",
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
