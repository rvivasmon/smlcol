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

        <div class="row">

          <?php if ($id_rol_sesion_usuario == 7 || $id_rol_sesion_usuario == 14): ?>

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
                  <a href="<?php echo $URL; ?>admin/ti/usuarios/create.php">
                    <div class="icon">
                      <i class="fas fa-user-plus"></i>
                    </div>
                  </a>
                  <a href="<?php echo $URL; ?>admin/ti/usuarios" class="small-box-footer">
                  Más Información <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-secondary">
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
              <div class="small-box bg-primary">
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
              <div class="small-box bg-dark">
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
              <div class="small-box bg-light">
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

          <?php endif; ?>

          <?php if ($id_rol_sesion_usuario == 7 || $id_rol_sesion_usuario == 16): ?>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <?php
                  $contador_de_solicitudes = 0;
                  foreach ($solicitudes_datos as $solicitud_dato){
                      $contador_de_solicitudes = $contador_de_solicitudes + 1;
                  }
                  ?>
                  <h3><?php echo $contador_de_solicitudes; ?></h3>
                  <p>Nuevas</p>
                </div>
                  <a href="<?php echo $URL; ?>admin/techled/tracking_chi/solicitud">
                    <div class="icon">
                      <i class="fas fa-user-plus"></i>
                    </div>
                  </a>
                  <a href="<?php echo $URL; ?>admin/techled/tracking_chi/solicitud" class="small-box-footer">
                  Más Información <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <?php
                  $contador_de_terminar = 0;
                  foreach ($terminar_solicitudes_datos as $terminar_solicitud_dato){
                      $contador_de_terminar = $contador_de_terminar + 1;
                  }
                  ?>
                  <h3><?php echo $contador_de_terminar; ?></h3>
                  <p>Procesar</p>
                </div>
                  <a href="<?php echo $URL; ?>admin/techled/tracking_chi/terminar">
                    <div class="icon">
                      <i class="fas fa-user-plus"></i>
                    </div>
                  </a>
                  <a href="<?php echo $URL; ?>admin/techled/tracking_chi/terminar" class="small-box-footer">
                  Más Información <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
            </div>

            <div class="col-lg-2 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <?php
                  $contador_de_envios = 0;
                  foreach ($enviars_datos as $enviar_dato){
                      $contador_de_envios = $contador_de_envios + 1;
                  }
                  ?>
                  <h3><?php echo $contador_de_envios; ?></h3>
                  <p>Facturar</p>
                </div>
                  <a href="<?php echo $URL; ?>admin/techled/tracking_chi/enviar">
                    <div class="icon">
                      <i class="fas fa-user-plus"></i>
                    </div>
                  </a>
                  <a href="<?php echo $URL; ?>admin/techled/tracking_chi/enviar" class="small-box-footer">
                  Más Información <i class="fas fa-arrow-circle-right"></i>
                  </a>
              </div>
            </div>

          <?php endif; ?>


        </div>
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
              <button type="button" id="btn_h1" data-dismiss="modal" class="btn btn-success btn-lg btn-block">08:00 - 09:00 am</button>
              <button type="button" id="btn_h2" data-dismiss="modal" class="btn btn-success btn-lg btn-block">09:00 - 10:00 pm</button>
              <button type="button" id="btn_h3" data-dismiss="modal" class="btn btn-success btn-lg btn-block">10:00 - 11:00 am</button>
              <button type="button" id="btn_h4" data-dismiss="modal" class="btn btn-success btn-lg btn-block">11:00 - 12:00 pm</button>
          </div>
          <div class="col-md-6">
            <center><b>Turno Tarde</b></center>
            <br>
              <button type="button" id="btn_h5" data-dismiss="modal" class="btn btn-success btn-lg btn-block">01:00 - 02:00 pm</button>
              <button type="button" id="btn_h6" data-dismiss="modal" class="btn btn-success btn-lg btn-block">02:00 - 03:00 pm</button>
              <button type="button" id="btn_h7" data-dismiss="modal" class="btn btn-success btn-lg btn-block">03:00 - 04:00 pm</button>
              <button type="button" id="btn_h8" data-dismiss="modal" class="btn btn-success btn-lg btn-block">04:00 - 05:00 pm</button>
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

                <style>
                    /* Aplicando estilos a los options para mostrar el color */
                    select option[value="amarillo_mostaza"] {
                        background-color: #e7d40a; /* Color amarillo mostaza */
                        color: #fff;
                    }
                    select option[value="rojo"] {
                        background-color: #ef280f; /* Color rojo */
                        color: #fff;
                    }
                    select option[value="azul"] {
                        background-color: #109dfa; /* Color azul */
                        color: #fff;
                    }
                    select option[value="verde_agua"] {
                        background-color: #02ac66; /* Color verde agua */
                        color: #000;
                    }
                    select {
                        -webkit-appearance: none; /* Elimina el estilo por defecto de select en algunos navegadores */
                        -moz-appearance: none;
                        appearance: none;
                        padding: 5px;
                    }
                </style>


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

            <div class="row">
              <div class="col-md-6">
                <label for="">Color</label>
                <select name="color" id="color" class="form-control">
                    <option value="amarillo_mostaza" data-color="#e7d40a"></option>
                    <option value="rojo" data-color="#ef280f"></option>
                    <option value="azul" data-color="#109dfa"></option>
                    <option value="verde_agua" data-color="#02ac66"></option>
                </select>
              </div>
            </div>

          </form>

          <script>
              document.addEventListener('DOMContentLoaded', function () {
                  var selectElement = document.getElementById('color');

                  // Función para actualizar el color de fondo del select
                  function updateSelectColor() {
                      var selectedOption = selectElement.options[selectElement.selectedIndex];
                      selectElement.style.backgroundColor = selectedOption.getAttribute('data-color');
                  }

                  // Actualizar el color al cargar la página
                  updateSelectColor();

                  // Actualizar el color al cambiar la selección
                  selectElement.addEventListener('change', updateSelectColor);
              });
          </script>

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
    var h1 = "08:00 - 09:00"
    $('#hora_reserva').val(h1);
  });

  $('#btn_h2').click(function () {
    $('#modal_formulario').modal("show");
    $('#fecha_inicio').val(a);
    var h2 = "09:00 - 10:00"
    $('#hora_reserva').val(h2);
  });

  $('#btn_h3').click(function () {
    $('#modal_formulario').modal("show");
    $('#fecha_inicio').val(a);
    var h3 = "10:00 - 11:00"
    $('#hora_reserva').val(h3);
  });

  $('#btn_h4').click(function () {
    $('#modal_formulario').modal("show");
    $('#fecha_inicio').val(a);
    var h4 = "11:00 - 12:00"
    $('#hora_reserva').val(h4);
  });

  $('#btn_h5').click(function () {
    $('#modal_formulario').modal("show");
    $('#fecha_inicio').val(a);
    var h5 = "01:00 - 02:00"
    $('#hora_reserva').val(h5);
  });

  $('#btn_h6').click(function () {
    $('#modal_formulario').modal("show");
    $('#fecha_inicio').val(a);
    var h6 = "02:00 - 03:00"
    $('#hora_reserva').val(h6);
  });

  $('#btn_h7').click(function () {
    $('#modal_formulario').modal("show");
    $('#fecha_inicio').val(a);
    var h7 = "03:00 - 04:00"
    $('#hora_reserva').val(h7);
  });

  $('#btn_h8').click(function () {
    $('#modal_formulario').modal("show");
    $('#fecha_inicio').val(a);
    var h8 = "04:00 - 05:00"
    $('#hora_reserva').val(h8);
  })
</script>
