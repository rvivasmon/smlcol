<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

// Validar si 'id' está presente en la URL
$id_get = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_get) {
    echo "ID no proporcionado";
    exit;
}

try {
    // Preparar y ejecutar consulta
    $query = $pdo->prepare("SELECT * FROM vehiculos WHERE id = :id");
    $query->bindParam(':id', $id_get);
    $query->execute();
    $vehiculo = $query->fetch(PDO::FETCH_ASSOC);

    // Validar si se encontró el vehículo
    if (!$vehiculo) {
        echo "Vehículo no encontrado";
        exit;
    }
} catch (PDOException $e) {
    echo "Error al realizar la consulta: " . $e->getMessage();
    exit;
}

// Variables para el formulario
$id = $vehiculo['id'];
$placa = htmlspecialchars($vehiculo['placa']);
$propietario = htmlspecialchars($vehiculo['propietario']);
$tipo_vehiculo = htmlspecialchars($vehiculo['tipo_vehiculo']);
$pico_placa = htmlspecialchars($vehiculo['pico_placa']);
$soat_hasta = htmlspecialchars($vehiculo['soat_hasta']);
$tecnicomecanica_hasta = htmlspecialchars($vehiculo['tecnicomecanica_hasta']);
$observacion1 = htmlspecialchars($vehiculo['observacion']);
$electrico = htmlspecialchars($vehiculo['electrico']);

// Calcular si los documentos están vencidos
$today = date("Y-m-d");
$documentos_vencidos = ($soat_hasta < $today || $tecnicomecanica_hasta < $today);

// Verificar si la sesión ya está iniciada antes de iniciar una nueva
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generar CSRF token para proteger el formulario
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;

$usuario_crea_tarea = htmlspecialchars($sesion_usuario['nombre']);
$fecha_asignacion_tarea = date('Y-m-d');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nuevo Registro</h1>
                </div>
            </div>

            <div class="card card-warning">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>

                <div class="card-body">
                    <form action="controller_edit.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_edicion">Fecha Edición</label>
                                    <input name="fecha_edicion" value="<?php echo $fecha_asignacion_tarea;?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="placa">Placa Vehículo</label>
                                        <input type="text" name="placa" id="placa" value="<?php echo $placa; ?>" class="form-control">
                                    </div>
                            </div>

                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="propietario">Propietario del vehículo</label>
                                        <input type="text" name="propietario" id="propietario" value="<?php echo $propietario; ?>" class="form-control">
                                    </div>
                            </div>

                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tipo_vehiculo">Clase Vehículo</label>
                                        <input type="text" name="tipo_vehiculo" id="tipo_vehiculo" value="<?php echo $tipo_vehiculo; ?>" class="form-control">
                                    </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pico_placa">Tiene Pico y Placa</label>
                                    <input type="text" name="pico_placa" id="pico_placa" value="<?php echo $pico_placa; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="soat_hasta">Tiene SOAT Hasta</label>
                                    <input type="date" name="soat_hasta" id="soat_hasta" value="<?php echo $soat_hasta; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tecnicomecanica_hasta">Tiene Técnicomecánica Hasta</label>
                                    <input type="date" name="tecnicomecanica_hasta" id="tecnicomecanica_hasta" value="<?php echo $tecnicomecanica_hasta; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="es_electrico">¿Es Eléctrico?</label><br>
                                    <input type="checkbox" id="es_electrico" name="es_electrico" value="1"
                                    <?php echo ($electrico == 1) ? 'checked' : ''; ?>> Eléctrico
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control"><?php echo $observacion1; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="<?php echo $URL . "admin/administracion/vehiculos/index.php"; ?>" class="btn btn-default btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-warning btn-block">Guardar Cambios</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.querySelector('form').addEventListener('submit', function(e) {
                                var tecnoDate = document.getElementById('tecnicomecanica_hasta').value;
                                var tecnoCheckbox = document.getElementById('es_electrico').checked;

                                // Si ambos están vacíos o ambos están llenos, prevenir envío
                                if ((tecnoDate === "" && !tecnoCheckbox) || (tecnoDate !== "" && tecnoCheckbox)) {
                                    e.preventDefault();
                                    alert("Debe llenar la fecha del TECNOMECÁNICO o marcar la casilla 'Es Eléctrico?', pero no ambos.");
                                    return false;
                                }

                                // Si está bien, permitir el envío
                                return true;
                            });
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../../../layout/admin/parte2.php'); ?>

<script>
    // Obtener elementos del DOM
    const tecnicomecanicaInput = document.getElementById('tecnicomecanica_hasta');
    const picouplacaInput = document.getElementById('pico_placa');
    const electricoCheckbox = document.getElementById('es_electrico');

    // Función para habilitar/deshabilitar campos según el checkbox
    function toggleFields() {
        if (electricoCheckbox.checked) {
            // Si el checkbox está marcado, deshabilitar los inputs y mostrar "NO APLICA"
            tecnicomecanicaInput.value = 'NO APLICA';
            tecnicomecanicaInput.setAttribute('disabled', 'disabled');
            picouplacaInput.value = 'NO APLICA';
            picouplacaInput.setAttribute('readonly', 'readonly');
        } else {
            // Si el checkbox no está marcado, habilitar los inputs y restaurar sus valores originales
            tecnicomecanicaInput.removeAttribute('disabled');
            tecnicomecanicaInput.value = "<?php echo $tecnicomecanica_hasta; ?>";
            picouplacaInput.removeAttribute('readonly');
            picouplacaInput.value = "<?php echo $pico_placa; ?>";
        }
    }

    // Añadir el evento para cambiar dinámicamente cuando el usuario marca/desmarca el checkbox
    electricoCheckbox.addEventListener('change', toggleFields);

    // Ejecutar la función cuando la página se cargue
    window.addEventListener('load', toggleFields);
</script>

