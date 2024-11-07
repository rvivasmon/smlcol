<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

?>

<?php include('../../../layout/admin/parte1.php'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0">TICKETS A TRATAR PARA ASIGNAR OST - SMARTLED</h1>
                        <div class="card card-blue">
                            <div class="card-header">
                                CASOS ACTIVOS
                            </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla_pre_ost" class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ID STC</th>
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
                                        <th>Medio de Contacto</th>
                                        <th><center>Acciones</center></th>
                                    </tr>
                                </thead>
                            <tbody>
                                <?php
                                $contador = 0;

                                $query = $pdo->prepare('SELECT stc.*, t_tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_clientes, t_ciudad.ciudad AS nombre_ciudad, t_estado.estadostc AS nombre_estado FROM stc JOIN t_tipo_servicio ON stc.tipo_servicio = t_tipo_servicio.id JOIN t_estado ON stc.estado = t_estado.id JOIN clientes ON stc.cliente = clientes.id JOIN t_ciudad ON stc.ciudad = t_ciudad.id WHERE stc.tipo_servicio = "3" AND stc.estado_ticket IN (1,2)');

                                $query->execute();
                                $stcs = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($stcs as $stc){
                                    $id = $stc['id'];
                                    $id_stc = $stc['id_stc'];
                                    $fechaingreso = $stc['fecha_ingreso'];
                                    $medioingreso = $stc['medio_ingreso'];
                                    $ticketexterno = $stc['ticket_externo'];
                                    $nombreservicio = $stc['nombre_servicio'];
                                    $idproducto = $stc['id_producto'];
                                    $falla = $stc['falla'];
                                    $observacion = $stc['observacion'];
                                    $nombrecliente = $stc['nombre_clientes'];
                                    $nombreciudad = $stc['nombre_ciudad'];
                                    $proyecto = $stc['proyecto'];
                                    $nombreestado = $stc['nombre_estado'];
                                    $personacontacto = $stc['persona_contacto'];
                                    $mediocontacto = $stc['email_contacto'];
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
                                        <td>
                                            <center>
                                                <a href="show_index.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                <a href="edit_index.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Generar OST<i class="fas fa-pen"></i></a>
                                                <a href="delete_index.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
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

<?php include('../../../layout/admin/parte2.php'); ?>

<script>
    $(function () {
        $("#tabla_pre_ost").DataTable({
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
        }).buttons().container().appendTo('#tabla_pre_ost_wrapper .col-md-6:eq(0)');
    });
</script>
