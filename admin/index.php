<?php 

include('../app/config/config.php');
include('../app/config/conexion.php');

include('../layout/admin/sesion.php');
include('../layout/admin/datos_sesion_user.php');

include('controller_index.php');

include('../layout/admin/parte1.php');


// Definir el rango de fechas (por ejemplo, este mes)
$fecha_inicio = date('Y-m-d', strtotime('-5 days')); // Primer día del mes actual
$fecha_fin = date('Y-m-d', strtotime('+45 days'));     // Último día del mes actual

// Obtener eventos del usuario actual dentro del rango de fechas
$sql = "SELECT id_evento, title, start_date, usuario, color, recordatorio FROM eventos WHERE usuario = ? AND start_date BETWEEN ? AND ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$sesion_id_usuario, $fecha_inicio, $fecha_fin]); // Pasar los parámetros en el orden correcto
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!-- Agrega FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/main.css' rel='stylesheet' />

<!-- Agrega tu CSS personalizado para adaptar el estilo -->
<style>
  /* Estilos personalizados para adaptar el calendario al estilo de AdminLTE 3 */
  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

  /* Personaliza otros estilos según sea necesario */
</style>

<!-- Agrega FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/main.min.js'></script>

<!-- Inicializa FullCalendar -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth', // Vista inicial
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: <?php echo json_encode($eventos); ?>, // Tus eventos
      eventDidMount: function(info) {
        // Agregar recordatorio
        let reminderTime = new Date(info.event.extendedProps.recordatorio);
        let now = new Date();
        let timeUntilReminder = reminderTime - now;

        if (timeUntilReminder > 0) {
          setTimeout(function() {
            alert("Recordatorio: " + info.event.title);
          }, timeUntilReminder);
        }
      }
    });
    calendar.render();
  });
</script>
  

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0">Bienvenido</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <br>
        <br>

        <!-- Formulario para crear eventos -->
        <div class="row">
          <div class="col-sm-4">
            <form id="create-event-form" action="create_event.php" method="POST">
              <div class="form-group">
                <label for="title">Título del Evento:</label>
                <input type="text" id="title" name="title" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="start">Fecha de Inicio:</label>
                <input type="date" id="start" name="start" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="color">Color del Evento:</label>
                <select id="color" name="color" class="form-control" required>
                  <option value="#cc9900" style="background-color: #F3C300;"></option>
                    <option value="#0000ff" style="background-color: #0691F7;"></option>
                    <option value="#008000" style="background-color: #22AD11;"></option>
                    <option value="#ff0000" style="background-color: #F70606;"></option>
                    <option value="#008080" style="background-color: #17D0BF;"></option>
                </select>
              </div>
                <div class="form-group">
                  <label for="recordatorio">Fecha y Hora del Recordatorio:</label>
                  <input type="datetime-local" id="recordatorio" name="recordatorio" class="form-control" required>
                </div>
                <!-- Campo oculto para el usuario -->
                <input type="hidden" id="usuario" name="usuario" value="<?php echo $sesion_id_usuario; ?>">
                <button type="submit" class="btn btn-primary">Crear Evento</button>
            </form>
          </div>
            <div class="col-sm-8">
              <div class="form-group">
                <div id='calendar'></div>
              </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
        
      </div><!-- /.container-fluid -->

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


  <br>

<?php include('../layout/admin/parte2.php');?>