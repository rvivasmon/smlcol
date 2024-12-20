<?php

// Incluir archivos necesarios
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
          <h1 class="m-0">ASIGNACIÓN DE POP</h1>
          <div class="card card-blue">
            <div class="card-header">
              <a href="#" class="d-block invisible"><?php echo $sesion_usuario['nombre'] ?></a>
            </div>
            <hr>
            
            <div class="col-md-4" hidden>
              <a type="button" href="<?php echo $URL; ?>admin/operacion/pop/create_pop.php" class="btn btn-primary">INSERTAR UN NUEVO POP</a>
            </div>
           
            <div class="card-body">
              <div class="table-responsive">
                        <table id="table_pop" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha Recibido</th>
                                    <th>POP</th>
                                    <th>OC</th>
                                    <th>JPM</th>
                                    <th>Proyecto</th>
                                    <th>Ciudad</th>
                                    <th>Estado POP</th>
                                    <th>Cliente</th>
                                    <th>Lugar de Instalación</th>
                                    <th><center>Acciones</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = 0;
                                $query_pop = $pdo->prepare('SELECT * FROM pop');
                                $query_pop->execute();
                                $popes = $query_pop->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($popes as $pop_item){

                                    $id = $pop_item['id'];
                                    $pop = $pop_item['pop'];
                                    $fecha_recibido = $pop_item['fecha_recibido'];
                                    $oc = $pop_item['oc'];
                                    $jpm = $pop_item['jpm'];
                                    $proyecto = $pop_item['nombre_proyecto'];
                                    $ciudad = $pop_item['ciudad'];
                                    $estdo_pop = $pop_item['estado_pop'];
                                    $fecha_inicio = $pop_item['cliente'];
                                    $fecha_fin = $pop_item['lugar_instalacion'];
                                    $contador = $contador + 1;
                                ?>
                                    <tr>
                                        <td><?php echo $contador; ?></td>
                                        <td><?php echo $fecha_recibido?></td>
                                        <td><?php echo $pop; ?></td>
                                        <td><?php echo $oc; ?></td>
                                        <td><?php echo $jpm; ?></td>
                                        <td><?php echo $proyecto; ?></td>
                                        <td><?php echo $ciudad; ?></td>
                                        <td><?php echo $estdo_pop; ?></td>
                                        <td ><?php echo $fecha_inicio; ?></td>                                        
                                        <td><?php echo $fecha_fin; ?></td>
                                        <td>
                                            <center>
                                                <a href="show.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Procesar <i class="fas fa-pen"></i></a>
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
        $("#table_pop").DataTable({
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
        }).buttons().container().appendTo('#table_pop_wrapper .col-md-6:eq(0)');
    });
</script>