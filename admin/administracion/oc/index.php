<?php

// Incluir archivos necesarios
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$fecha_creacion = date('Y-m-d'); //Obtiene la fecha actual
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col">
          <h1 class="m-0">ORDEN DE COMPRAS</h1>
          <div class="card card-blue">
            <div class="card-header">
                <a href="#" class="d-block invisible"><?php echo $sesion_usuario['nombre'] ?></a>
            </div>
            <hr>
            
            <div class="col-md-4">
              <a type="button" href="<?php echo $URL; ?>admin/administracion/oc/create_oc.php" class="btn btn-primary">INSERTAR UN NUEVO OC</a>
            </div>
           
            <div class="card-body">
              <div class="table-responsive">
                        <table id="table_oc" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>OC</th>
                                    <th>PC</th>
                                    <th>Proyecto</th>
                                    <th>Cliente</th>
                                    <th>Fecha Admon</th>
                                    <th hidden>Tipo OC</th>
                                    <th hidden>Tipo PC</th>
                                    <th hidden>OC Cliente</th>
                                    <th hidden>Fecha Aprobacion</th>
                                    <th hidden>Estado Admon</th>
                                    <th hidden>Vendedor</th>
                                    <th hidden>Estado Factura</th>
                                    <th hidden>Num Factura Fecha</th>
                                    <th hidden>Acuerdo Pago</th>
                                    <th hidden>Nom Contacto Admin</th>
                                    <th hidden>Telefono Contacto</th>
                                    <th hidden>Nom Contacto Cliente</th>
                                    <th hidden>Num Telefono</th>
                                    <th hidden>Ciudad</th>
                                    <th hidden>Lugar Instalacion</th>
                                    <th hidden>Estado Logistico</th>
                                    <th hidden>Dias Pactados</th>
                                    <th hidden>Observacion</th>
                                    <th hidden>Num Factura</th>
                                    <th hidden>Num Items</th>
                                    <th><center>Acciones</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = 0;
                                $query_oc = $pdo->prepare('SELECT * FROM oc');
                                $query_oc->execute();
                                $oces = $query_oc->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($oces as $oc_item){

                                    $id = $oc_item['id'];
                                    $oc = $oc_item['oc'];
                                    $pc = $oc_item['pc'];
                                    $tipo_oc = $oc_item['tipo_oc'];
                                    $tipo_pc = $oc_item['tipo_pc'];
                                    $oc_cliente = $oc_item['oc_cliente'];
                                    $nom_cliente = $oc_item['nom_cliente'];
                                    $fecha_creacion = $oc_item['fecha_creacion'];
                                    $fecha_aprobacion = $oc_item['fecha_aprobacion'];
                                    $estado_admon = $oc_item['estado_admon'];
                                    $vendedor = $oc_item['vendedor'];
                                    $estado_factura = $oc_item['estado_factura'];
                                    $factura_fecha = $oc_item['factura_fecha'];
                                    $acuerdo_pago = $oc_item['acuerdo_pago'];
                                    $nom_contacto_admin = $oc_item['nom_contacto_admin'];
                                    $telefono_contacto = $oc_item['telefono_contacto'];
                                    $nom_contacto_cliente = $oc_item['nom_contacto_cliente'];
                                    $num_telefono = $oc_item['num_telefono'];
                                    $proyecto = $oc_item['proyecto'];
                                    $ciudad = $oc_item['ciudad'];
                                    $lugar_instalacion = $oc_item['lugar_instalacion'];
                                    $estado_logistico = $oc_item['estado_logistico'];
                                    $dias_pactados = $oc_item['dias_pactados'];;
                                    $observacion = $oc_item['observacion'];
                                    $num_factura = $oc_item['num_factura'];
                                    $num_items = $oc_item['num_items'];
                                  
                                    $contador = $contador + 1;
                                ?>
                                    <tr>
                                        <td><?php echo $contador; ?></td>
                                        <td><?php echo $oc; ?></td>
                                        <td><?php echo $pc; ?></td>
                                        <td><?php echo $proyecto; ?></td>
                                        <td ><?php echo $nom_cliente; ?></td>          
                                        <td><?php echo $fecha_creacion; ?></td>  
                                        <td hidden><?php echo $tipo_oc; ?></td>
                                        <td hidden><?php echo $tipo_pc; ?></td>
                                        <td hidden><?php echo $oc_cliente; ?></td>                          
                                        <td hidden><?php echo $fecha_aprobacion; ?></td>
                                        <td hidden><?php echo $estado_admon; ?></td>
                                        <td hidden><?php echo $vendedor; ?></td>
                                        <td hidden><?php echo $estado_factura; ?></td>
                                        <td hidden><?php echo $factura_fecha; ?></td>
                                        <td hidden><?php echo $acuerdo_pago; ?></td>
                                        <td hidden><?php echo $nom_contacto_admin; ?></td>
                                        <td hidden><?php echo $telefono_contacto; ?></td>  
                                        <td hidden><?php echo $nom_contacto_cliente; ?></td>
                                        <td hidden><?php echo $num_telefono; ?></td>
                                        <td hidden><?php echo $ciudad; ?></td>
                                        <td hidden><?php echo $lugar_instalacion; ?></td>
                                        <td hidden><?php echo $estado_logistico; ?></td>
                                        <td hidden><?php echo $dias_pactados; ?></td>
                                        <td hidden><?php echo $observacion; ?></td>
                                        <td hidden><?php echo $num_factura; ?></td>
                                        <td hidden><?php echo $num_items; ?></td>
                                   
                                        <td>
                                            <center>
                                                <a href="show_oc.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar<i class="fas fa-eye"></i></a>
                                                <a href="tratar_oc.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Tratar<i class="fas fa-pen"></i></a>
                                                <a href="delete_oc.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Eliminar<i class="fas fa-trash"></i></a>
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
        $("#table_oc").DataTable({
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
        }).buttons().container().appendTo('#table_oc_wrapper .col-md-6:eq(0)');
    });
</script>