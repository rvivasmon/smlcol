<?php 

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

include('../../layout/admin/parte1.php');


// Obtener la fecha de creación del formulario
$fecha_creacion = isset($_POST['fechaingreso']) ? $_POST['fechaingreso'] : date('Y-m-d');

// Validar el formato de fecha con JavaScript
    echo"<script>
            function validarFecha() {
                var fecha = document.getElementById('fechaingreso').value;
                var regex = /^\d{4}-\d{2}-\d{2}$/;
                if (!regex.test(fecha)) {
                    alert('Formato de fecha incorrecto. Utilice el formato YYYY-MM-DD.');
                    return false;
                }
                return true;
            }
        </script>";

// Obtener el año y mes de la fecha actual en formato YYYYMM
$anio_mes = date('Ym', strtotime($fecha_creacion));

// Obtener el último registro de la base de datos ordenado por año_mes de forma descendente
$query_ultimo_registro = $pdo->prepare('SELECT * FROM id_producto WHERE anio_mes_prod = :anio_mes ORDER BY contador_prod DESC LIMIT 1');
$query_ultimo_registro->bindParam(':anio_mes', $anio_mes);
$query_ultimo_registro->execute();
$ultimo_registro_prod = $query_ultimo_registro->fetch(PDO::FETCH_ASSOC);

// Determinar el contador
if ($ultimo_registro_prod) {
    // Si hay un último registro, continuar con el contador
    $contador_prod = $ultimo_registro_prod['contador_prod'] + 1;
} else {
    // Si no hay ningún registro para este año y mes, inicializar el contador en 1
    $contador_prod = 1;
}

// Crear el ID del producto
$id_prod = $anio_mes . '-' . sprintf('%03d', $contador_prod);

?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CREAR ID PRODUCTO</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form id="formulario" action="controller_create.php" method="POST" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-0">
                                            <div class="form-group">
                                                <label for=""></label>

                                                <input type="hidden" name="anio_mes" value="<?php echo $anio_mes; ?>">
                                                <input type="hidden" name="contador" value="<?php echo $contador_prod; ?>">
                                                <input type="text" name="idprod" class="form-control" value="<?php echo $id_prod; ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Fecha Creación</label>
                                                <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="actualizarContador()">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Agente</label>
                                                <input type="text" name="Agente" class="form-control" value="<?php echo htmlspecialchars($sesion_nombre = $sesion_usuario['nombre']); ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Orden OP</label>
                                                <select name="OP" id="OP" class="form-control" required>
                                                    <option value="">Seleccionar OP</option>
                                                    <?php 
                                                    $query_op = $pdo->prepare('SELECT * FROM op WHERE id_producto = 1');
                                                    $query_op->execute();
                                                    $ops = $query_op->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($ops as $op) {
                                                        $id_op = $op['id'];
                                                        $op_val = $op['op'];
                                                    ?>
                                                        <option value="<?php echo htmlspecialchars($id_op); ?>"><?php echo htmlspecialchars($op_val); ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">ID Producto</label>
                                                <input type="text" name="idproducto" id="idproducto" class="form-control" value="<?php echo $id_prod; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">Check List</label>
                                                <input type="text" name="proyecto" class="form-control" placeholder="Check List" required>
                                            </div>
                                        </div>
                                    </div>                                
                                    <div class="row">
                                        <div class="col-md-0"> <!-- Se coloca aquí el usuario que está trabajando el archivo --> 
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input type="text" name="usuario" class="form-control" value="<?php echo $sesion_nombre; ?>" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="archivo_adjunto">Archivo Adjunto</label>
                                    <br>
                                    <output id="list" style="position: relative; width: 200px; height: 200px; overflow: hidden;"></output>
                                    <input type="file" name="archivo_adjunto" id="file" class="form-control-file" multiple>
                                </div>
                            </div> 
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="<?php echo $URL."admin/atencion_cliente/stc";?>" class="btn btn-default btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear STC</button>
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

<?php include('../../layout/admin/parte2.php');?>

<script>
    function actualizarContador() {
        var fecha = document.getElementById('fechaingreso').value;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "actualizar_contador.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var nuevoContador = xhr.responseText;
                var anio_mes = fecha.substring(0, 7).replace('-', '');
                var id_prod = anio_mes + '-' + ('000' + nuevoContador).slice(-3);
                document.getElementById('idproducto').value = id_prod;
            }
        };
        xhr.send("fecha=" + encodeURIComponent(fecha));
    }
</script>