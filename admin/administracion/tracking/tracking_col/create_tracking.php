<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nueva Solicitud a China</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form id="formulario" action="controller_create_tracking.php" method="POST" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Solicitante</label>
                                                <input type="text" name="origen_solicitud" id="origen_solicitud" class="form-control" value=""> <!-- FALTA COLOCAR AQUÍ DE DÓNDE PROVIENE LA SOLICITUD OJO -->
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Fecha</label>
                                                <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value= "<?php echo date('Y-m-d'); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Origen</label>
                                                <input type="text" name="destinomercancia" class="form-control" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tipo_producto">Tipo</label>
                                                <select class="form-control" name="tipo_producto" id="tipo_producto">
                                                    <option value="">Seleccione un tipo</option>
                                                    <?php 
                                                    $query_pitch = $pdo->prepare('SELECT DISTINCT tpd.id_producto, tpd.tipo_producto 
                                                                                FROM alma_smartled AS mvd 
                                                                                INNER JOIN t_productos AS tpd 
                                                                                ON mvd.tipo_producto = tpd.id_producto');
                                                    $query_pitch->execute();
                                                    $pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach($pitches as $pitch) {
                                                        echo '<option value="' . $pitch['id_producto'] . '">' . $pitch['tipo_producto'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-0"> <!-- Se coloca aquí el usuario que está trabajando el archivo --> 
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input type="text" name="usuarioperador" class="form-control" value="<?php echo $sesion_nombre; ?>" hidden>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="categoria1">Categoría 1</label>
                                                <select class="form-control" name="categoria1" id="categoria1">
                                                    <option value="">Seleccione la categoría 1</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="categoria2">Categoría 2</label>
                                                <select class="form-control" name="categoria2" id="categoria2">
                                                    <option value="">Seleccione la categoría 2</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Cantidad</label>
                                                <input type="text" name="cantidad" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Observaciones Colombia</label>
                                    <textarea type="text" name="obscolombia" class="form-control" rows="8" placeholder="" required></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="<?php echo $URL."admin/administracion/tracking/tracking_col/index_tracking.php";?>" class="btn btn-default btn-block ml-3">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block ml-3">Crear Solicitud</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>

<script>
    document.getElementById("formulario").addEventListener("submit", function(event) {
        var medioIngreso = document.getElementById("medio_ingreso").value;
        var tipoServicio = document.getElementById("tiposervicio").value;

        if (medioIngreso === "") {
            alert("Por favor seleccionar un medio de ingreso.");
            event.preventDefault();
        }

        if (tipoServicio === "") {
            alert("Por favor seleccione un tipo de servicio.");
            event.preventDefault();
        }
    });
    
</script>

<?php include('../../../../layout/admin/parte2.php');?>

<script>
$(document).ready(function() {
    // Cuando cambia el Tipo de Producto
    $("#tipo_producto").change(function() {
        var tipo_id = $(this).val();
        $("#categoria1").html('<option value="">Cargando...</option>'); // Mensaje de carga
        $("#categoria2").html('<option value="">Seleccione la categoría 2</option>'); // Reset categoría 2

        $.ajax({
            url: 'get_categorias.php',
            type: 'POST',
            data: {tipo_id: tipo_id},
            success: function(response) {
                $("#categoria1").html(response); // Actualizar select
            }
        });
    });

    // Cuando cambia la Categoría 1
    $("#categoria1").change(function() {
        var categoria1_id = $(this).val();
        $("#categoria2").html('<option value="">Cargando...</option>');

        $.ajax({
            url: 'get_subcategorias.php',
            type: 'POST',
            data: {categoria1_id: categoria1_id},
            success: function(response) {
                $("#categoria2").html(response);
            }
        });
    });
});
</script>
