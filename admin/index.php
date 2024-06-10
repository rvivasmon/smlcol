<?php 
include('../app/config/config.php');
include('../app/config/conexion.php');

include('../layout/admin/sesion.php');
include('../layout/admin/datos_sesion_user.php');

include('controller_index.php');

include('../layout/admin/parte1.php');

?>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>

<script>

    var a;
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            editable: true,
            selectable: true,
            allDaySlot: false,

            aspectRatio: 2, // Ajusta la proporción de aspecto según sea necesario

            events: 'reservas/cargar_reservas.php',
              
            dateClick: function(info) {
              a = info.dateStr;
              const fechaComoCadena = a;
              var numeroDia = new Date(fechaComoCadena).getDay();
              var dias = ['LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES'];

                if( (numeroDia == "5") ){
                  alert("No hay Soporte técnico los días Sabados");
                }else if( (numeroDia == "6") ){
                  alert("No hay Soporte técnico los días Domingos");
                }else {
                  $('#modal_reservas').modal("show");
                  $('#dia_de_la_semana').html(dias[numeroDia] + " " + a);
                }
            },
        });
        calendar.render();
    });
</script>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br><br>
                <h1 style="text-align: center">Bienvenido al <b style="color: #0a58ca">agendamiento</b></h1>
                <br><br>
            </div>
        </div>
        
        <div class="row">
            <div id='calendar' class="col-md-12"></div>
        </div>

        <br>

        <?php if ($id_rol_sesion_usuario == 7 || $id_rol_sesion_usuario == 14): ?>
          <div class="row">
            <div class="col-lg-2 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <?php
                  $contador_de_usuarios = 0;
                  foreach ($usuarios_datos as $usuario_dato){
                      $contador_de_usuarios = $contador_de_usuarios + 1;
                  }
                  ?>
                  <h3><?php echo $contador_de_usuarios; ?></h3>
                  <p>Usuarios Registrados</p>
                </div>
                  <a href="<?php echo $URL; ?>admin/ti_usuarios/create.php">
                    <div class="icon">
                      <i class="fas fa-user-plus"></i>
                    </div>
                  </a>
                  <a href="<?php echo $URL; ?>admin/ti_usuarios" class="small-box-footer">
                  Más Información <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <?php
                  $contador_de_usuarios = 0;
                  foreach ($usuarios_datos as $usuario_dato){
                      $contador_de_usuarios = $contador_de_usuarios + 1;
                  }
                  ?>
                  <h3><?php echo $contador_de_usuarios; ?></h3>
                  <p>Usuarios Registrados</p>
                </div>
                  <a href="<?php echo $URL; ?>admin/ti_usuarios/create.php">
                    <div class="icon">
                      <i class="fas fa-user-plus"></i>
                    </div>
                  </a>
                  <a href="<?php echo $URL; ?>admin/ti_usuarios" class="small-box-footer">
                  Más Información <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <?php
                  $contador_de_usuarios = 0;
                  foreach ($usuarios_datos as $usuario_dato){
                      $contador_de_usuarios = $contador_de_usuarios + 1;
                  }
                  ?>
                  <h3><?php echo $contador_de_usuarios; ?></h3>
                  <p>Usuarios Registrados</p>
                </div>
                  <a href="<?php echo $URL; ?>admin/ti_usuarios/create.php">
                    <div class="icon">
                      <i class="fas fa-user-plus"></i>
                    </div>
                  </a>
                  <a href="<?php echo $URL; ?>admin/ti_usuarios" class="small-box-footer">
                  Más Información <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
            </div>
          </div>

        <?php endif; ?>

    </div>
</section>

<br>


<!-- Modal -->
<div class="modal fade" id="modal_reservas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Visita Técnica para el día <span id="dia_de_la_semana"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <center><b>Turno Mañana</b></center>
            <br>
              <button type="button" id="btn_h1" data-dismiss="modal" class="btn btn-success btn-lg btn-block">08:00 - 10:00 am</button>
              <button type="button" id="btn_h2" data-dismiss="modal" class="btn btn-success btn-lg btn-block">10:00 - 12:00 pm</button>
          </div>
          <div class="col-md-6">
            <center><b>Turno Tarde</b></center>
            <br>
              <button type="button" id="btn_h3" data-dismiss="modal" class="btn btn-success btn-lg btn-block">02:00 - 04:00 pm</button>
              <button type="button" id="btn_h4" data-dismiss="modal" class="btn btn-success btn-lg btn-block">04:00 - 06:00 pm</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php include('../layout/admin/parte2.php');?>


<!-- Modal -->
<div class="modal fade" id="modal_formulario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Visita Técnica para el día <span id="dia_de_la_semana"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form action="">

            <div class="row">
              <div class="col-md-12">
                <label for="">Evento</label>
                <input type="text" class="form-control">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="">Responsable</label>
                <input type="text" class="form-control">
              </div>                
              <div class="col-md-6">
                <label for="">Hora Evento</label>
                <input type="text" class="form-control" id="hora_reserva" disabled>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="">Fecha inicio</label>
                <input type="text" class="form-control" id="fecha_inicio" disabled>
              </div>
              <div class="col-md-6">
                <label for="">Fecha fin</label>
                <input type="date" class="form-control" id="fecha_fin">
              </div>
            </div>

          </form>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#btn_h1').click(function () {
    $('#modal_formulario').modal("show");
    $('#fecha_inicio').val(a);
    var h1 = "08:00 - 10:00"
    $('#hora_reserva').val(h1);
  });

  $('#btn_h2').click(function () {
    alert("BBBBBBBBBBBBBBBBBBBBBBB");
  });

  $('#btn_h3').click(function () {
    alert("CCCCCCCCCCCCCCCCCCCCCCCCCCC");
  });

  $('#btn_h4').click(function () {
    alert("DDDDDDDDDDDDDDDDDDDDD");
  });
</script>
