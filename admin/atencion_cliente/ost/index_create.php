<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

?>

<?php include('../../../layout/admin/parte1.php');?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                <h1 class="m-1">TRATAMIENTO DE OST - SMARTLED</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            CASOS ACTIVOS
                        </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="table_traost" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ID STC</th>
                                    <th>ID OST</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Medio Ingreso</th>
                                    <th>Ticket Externo</th>
                                    <th>Tipo Servicio</th>
                                    <th>ID Producto</th>
                                    <th>Falla</th>
                                    <th>Observación</th>
                                    <th>Cliente</th>
                                    <th>Ciudad</th>
                                    <th>Proyecto</th>
                                    <th>Estado</th>
                                    <th>Persona Contacto</th>
                                    <th>Medio Contacto</th>
                                    <th>Técnico Tratante</th>
                                    <th>Detalle Solución</th>
                                    <th><center>Acciones</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = 0;
                                $query = $pdo->prepare('SELECT ost.*, tipo_servicio.servicio_ost AS nombre_servicio, tecnicos.nombre AS nombre_tecnicos, estado.estadoost AS nombre_estado FROM ost JOIN tipo_servicio ON ost.tipo_servicio = tipo_servicio.id JOIN estado ON ost.estado = estado.id JOIN tecnicos ON ost.tecnico_tratante = tecnicos.id WHERE ost.estado_ticket = "1"');

                                $query->execute();
                                $osts = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($osts as $ost){
                                    $id = $ost['id'];
                                    $id_stc = $ost['id_stc'];
                                    $id_ost = $ost['id_ost'];
                                    $fechaingreso = $ost['fecha_ost'];
                                    $medioingreso = $ost['medio_ingreso'];
                                    $ticketexterno = $ost['ticket_externo'];
                                    $nombreservicio = $ost['nombre_servicio'];
                                    $idproducto = $ost['id_producto'];
                                    $falla = $ost['falla'];
                                    $observacion = $ost['observacion'];
                                    $nombrecliente = $ost['cliente'];
                                    $nombreciudad = $ost['ciudad'];
                                    $proyecto = $ost['proyecto'];
                                    $nombreestado = $ost['nombre_estado'];
                                    $personacontacto = $ost['persona_contacto'];
                                    $mediocontacto = $ost['email_contacto'];
                                    $contador = $contador + 1;
                                ?>
                                    <tr>
                                        <td><?php echo $contador; ?></td>
                                        <td><?php echo $id_stc; ?></td>
                                        <td><?php echo $fechaingreso; ?></td>
                                        <td><?php echo $medioingreso; ?></td>
                                        <td><?php echo $ticketexterno; ?></td>
                                        <td><?php echo $nombreservicio; ?></td>
                                        <td><?php echo $idproducto; ?></td>
                                        <td><?php echo $falla; ?></td>
                                        <td><?php echo $observacion; ?></td>
                                        <td><?php echo $nombrecliente; ?></td>
                                        <td><?php echo $nombreciudad; ?></td>
                                        <td><?php echo $proyecto; ?></td>
                                        <td><?php echo $nombreestado; ?></td>
                                        <td><?php echo $personacontacto; ?></td>
                                        <td><?php echo $mediocontacto; ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>                                        
                                        <td>
                                            <center>
                                                <a href="show_create.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                <a href="edit_create.php?id=<?php echo $id;?>" class="btn btn-success btn-sm">Editar <i class="fas fa-pen"></i></a>
                                                <a href="" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
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
        $("#table_traost").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando_START_ a _END_ de _TOTAL_ Órdenes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Órdenes",
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
        }).buttons().container().appendTo('#table_traost_wrapper .col-md-6:eq(0)');
    });
</script>
