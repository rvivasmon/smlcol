<?php

// Incluir archivos necesarios
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$cargo = $sesion_usuario['nombre_cargo']; // Obtener el cargo del usuario desde la sesión

// Consultar vehículos con SOAT o tecnomecánica próximos a vencer
$fecha_actual = date('Y-m-d');
$fecha_15_dias = date('Y-m-d', strtotime('+15 days'));

$consulta = $pdo->prepare("SELECT placa, soat_hasta, tecnicomecanica_hasta FROM vehiculos WHERE (soat_hasta BETWEEN :fecha_actual AND :fecha_15_dias) OR (tecnicomecanica_hasta BETWEEN :fecha_actual AND :fecha_15_dias)");
$consulta->bindParam(':fecha_actual', $fecha_actual);
$consulta->bindParam(':fecha_15_dias', $fecha_15_dias);
$consulta->execute();
$alertas = $consulta->fetchAll(PDO::FETCH_ASSOC);

// Obtener el día de la semana actual y el día siguiente
$dias_semana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
$dia_actual = date("w"); // 0 (Lunes) a 6 (Viernes)
$dia_siguiente = ($dia_actual + 1) % 7;
$dia_siguiente_nombre = $dias_semana[$dia_siguiente];

// Consultar vehículos que tienen pico y placa al día siguiente
$consulta = $pdo->prepare("SELECT placa, pico_placa FROM vehiculos WHERE pico_placa = :dia_siguiente_nombre");
$consulta->bindParam(':dia_siguiente_nombre', $dia_siguiente_nombre);
$consulta->execute();
$alertas_pico_placa = $consulta->fetchAll(PDO::FETCH_ASSOC);

// Mostrar la alerta un día antes del pico y placa
if (!empty($alertas_pico_placa)) {
    echo '<div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <center>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Alerta! Pico y Placa para mañana:</h5>
            <ul>';
    foreach ($alertas_pico_placa as $alerta) {
        echo '<li>Vehículo con placa: ' . $alerta['placa'] . ' - Pico y Placa el: ' . $alerta['pico_placa'] . '</li>';
    }
    echo '</ul></center></div>';
}
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col">
          <h1 class="m-0">VEHICULOS</h1>
          <?php if (!empty($alertas)): ?>
            <div class="alert alert-warning alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i>Alertas de Documentos Próximos a Vencer:</h5>
                <ul>
                  <?php foreach ($alertas as $alerta): ?>
                    <li>
                      <?php echo "Vehículo con placa: " . $alerta['placa']; ?>
                      <?php
                        if ($alerta['soat_hasta'] <= $fecha_15_dias && $alerta['soat_hasta'] >= $fecha_actual) {
                          echo " - SOAT vence el: " . $alerta['soat_hasta'];
                        }
                        if ($alerta['tecnicomecanica_hasta'] <= $fecha_15_dias && $alerta['tecnicomecanica_hasta'] >= $fecha_actual) {
                          echo " - Tecnomecánica vence el: " . $alerta['tecnicomecanica_hasta'];
                        }
                      ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
            </div>
          <?php endif; ?>

          <div class="card card-blue">
            <div class="card-header">
              AREA DE GESTIÓN
            </div>

            <hr>

            <div class="card-tools ml-4">
              <a type="button" href="<?php echo $URL; ?>admin/administracion/vehiculos/create.php" class="btn btn-primary">INSERTAR UN NUEVO VEHÍCULO</a>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table id="table_vehiculo" class="table table-striped table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Placa Del vehículo</th>
                      <th>Propietario Del vehículo</th>
                      <th>Clase Del vehículo</th>
                      <th>Tienen pico de placa</th>
                      <th>Tiene soat hasta</th>
                      <th>Tiene técnico mecánico hasta</th>
                      <th>Tarea A realizar</th>
                      <th>Clase de Tarea</th>
                      <th>Fecha tarea a realizar</th>
                      <th>Observación</th>
                      <th hidden>Fecha terminación de tareas</th>
                      <th hidden>Usuario que termina la tarea</th>
                      <th><center>Acciones</center></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $contador = 0;
                    $consulta = $pdo->prepare('SELECT * FROM vehiculos');
                    $consulta->execute();
                    $vehiculos = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($vehiculos as $vehiculo) {
                      $contador++;
                      ?>
                      <tr>
                        <td><?php echo $contador; ?></td>
                        <td><?php echo $vehiculo['placa']; ?></td>
                        <td><?php echo $vehiculo['propietario']; ?></td>
                        <td><?php echo $vehiculo['tipo_vehiculo']; ?></td>
                        <td><?php echo $vehiculo['pico_placa']; ?></td>
                        <td><?php echo $vehiculo['soat_hasta']; ?></td>
                        <td><?php echo $vehiculo['tecnicomecanica_hasta']; ?></td>
                        <td><?php echo $vehiculo['tarea_realizar']; ?></td>
                        <td><?php echo $vehiculo['clase_tarea']; ?></td>
                        <td><?php echo $vehiculo['fecha_tarea']; ?></td>
                        <td><?php echo $vehiculo['observacion']; ?></td>
                        <td hidden><?php echo $vehiculo['fecha_terminacion']; ?></td>
                        <td hidden><?php echo $vehiculo['usuario']; ?></td>
                        <td>
                          <center>
                            <a href="edit.php?id=<?php echo $vehiculo['id']; ?>" class="btn btn-warning btn-sm">Editar <i class="fas fa-pen"></i></a>
                            <a href="tarea.php?id=<?php echo $vehiculo['id']; ?>" class="btn btn-success btn-sm">Asignar <i class="fas fa-pen"></i></a>
                            <a href="show.php?id=<?php echo $vehiculo['id']; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                            <a href="terminacion.php?id=<?php echo $vehiculo['id']; ?>" class="btn btn-danger btn-sm">Terminar <i class="fas fa-trash"></i></a>
                          </center>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div><!-- /.content-header -->
</div><!-- /.content-wrapper -->

<?php include('../../../layout/admin/parte2.php'); ?>

<script>
  $(function () {
    $("#table_vehiculo").DataTable({
      "pageLength": 10,
      "language": {
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
        "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
        "infoFiltered": "(Filtrado de _MAX_ total de Usuarios)",
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
    }).buttons().container().appendTo('#table_vehiculo_wrapper .col-md-6:eq(0)');
  });
</script>