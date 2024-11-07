<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT stc.*, t_tipo_servicio.servicio_stc AS nombre_servicio, clientes.nombre_comercial AS nombre_cliente, t_ciudad.ciudad AS nombre_ciudad, t_estado.estadostc AS nombre_estado FROM stc JOIN t_tipo_servicio ON stc.tipo_servicio = t_tipo_servicio.id JOIN clientes ON stc.cliente = clientes.id JOIN t_ciudad ON stc.ciudad = t_ciudad.id JOIN t_estado ON stc.estado = t_estado.id  WHERE stc.id = '$id_get'");

$query->execute();
$stcs = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($stcs as $stc){
    $id = $stc['id'];
    $id_stc = $stc['id_stc'];
    $fecha_ingreso = $stc['fecha_ingreso'];
    $medio_ingreso = $stc['medio_ingreso'];
    $ticket_externo = $stc['ticket_externo'];
    $servicio = $stc['nombre_servicio'];
    $id_producto = $stc['id_producto'];
    $falla = $stc['falla'];
    $observacion = $stc['observacion'];
    $cliente = $stc['nombre_cliente'];
    $ciudad = $stc['nombre_ciudad'];
    $proyecto = $stc['proyecto'];
    $estado = $stc['nombre_estado'];
    $persona_contacto = $stc['persona_contacto'];
    $medio_contacto = $stc['email_contacto'];
    $evidencia = $stc['evidencias'];
    
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edición STC</h1>

                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card">
                <div class="card-header" style="background-color: #00A000; color: #ffffff">
                    Modifique la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit.php" method="post">

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">ID STC</label>
                                                <input type="text" name="idstc" class="form-control" value="<?php echo $id_stc; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Fecha de Ingreso</label>
                                                <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value="<?php echo $fecha_ingreso; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Medio de Ingreso</label>
                                                <input type="text" name="medioingreso" class="form-control" value="<?php echo $medio_ingreso; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Ticket Externo</label>
                                                <input type="text" name="ticketexterno" class="form-control" value="<?php echo $ticket_externo; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Tipo de Servicio</label>
                                                <select name="tiposervicio" id="tiposervicio" class="form-control" required>
                                                    <?php 
                                                    $valor_actual_en_edicion = $stc['tipo_servicio'];
                                                    $query_servicio = $pdo->prepare('SELECT * FROM t_tipo_servicio WHERE servicio_stc IS NOT NULL AND servicio_stc != "" AND id <> "4" ORDER BY servicio_stc ASC');
                                                    $query_servicio->execute();
                                                    $servicios = $query_servicio->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($servicios as $servicio) {
                                                        $id_servicio = $servicio['id'];
                                                        $servicio = $servicio['servicio_stc'];
                                                        $selected = ($id_servicio == $valor_actual_en_edicion) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $id_servicio; ?>" <?php echo $selected; ?>><?php echo $servicio; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">ID Producto</label>
                                                <input type="text" name="idproducto" class="form-control" value="<?php echo $id_producto; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Cliente</label>
                                                <input type="text" name="cliente" class="form-control" value="<?php echo $cliente; ?>" readonly>
                                                <input type="hidden" name="idcliente" value="<?php echo $stc['cliente']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Ciudad</label>
                                                <input type="text" name="ciudad" class="form-control" value="<?php echo $ciudad; ?>" readonly>
                                                <input type="hidden" name="idciudad" value="<?php echo $stc['ciudad']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Proyecto</label>
                                                <input type="text" name="proyecto" class="form-control" value="<?php echo $proyecto; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Estado</label>
                                                <select name="idestado" id="idestado" class="form-control" required>
                                                    <?php
                                                    $valor_actual_en_edicion = $stc['estado'];
                                                    $query_estado = $pdo->prepare('SELECT * FROM t_estado WHERE estadostc IS NOT NULL AND estadostc != ""');
                                                    $query_estado->execute();
                                                    $estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($estados as $estado) {
                                                        $id_estado = $estado['id'];
                                                        $estado = $estado['estadostc'];
                                                        $selected = ($id_estado == $valor_actual_en_edicion) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $id_estado; ?>" <?php echo $selected; ?>><?php echo $estado; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Persona Contacto</label>
                                                <input type="text" name="personacontacto" class="form-control" value="<?php echo $persona_contacto; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Medio de Contacto</label>
                                                <input type="text" name="medio_contacto" class="form-control" value="<?php echo $medio_contacto; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Falla</label>
                                            <textarea name="falla" id="" cols="30" rows="4" class="form-control" readonly><?php echo $falla; ?></textarea>
                                            <input type="text" name="id_usuario" value="<?php echo $id_get;?>" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Observación</label>
                                            <textarea name="observacion" id="" cols="30" rows="4" class="form-control" required><?php echo $observacion; ?></textarea>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="archivo_adjunto">Archivo Adjunto</label>
                                    <br>
                                    <center>
                                        <img src="<?php echo $URL."/img_uploads/".$evidencia;?>" width="50%" alt="">
                                    </center>
                                    <output id="list" style="position: relative; width: 50px; height: 50px; overflow: hidden;"></output>
                                    <input type="file" name="archivo_adjunto" id="file" class="form-control-file" multiple>

                                    <script>
                                            var currentImageIndex = 0; // Índice de la imagen actual

                                            function archivo(evt) {
                                            var files = evt.target.files; // FileList object

                                                for (var i = 0, f; f = files[i]; i++) {
                                                    var reader = new FileReader();
                                                    // Si el archivo es una imagen
                                                    if (f.type.match('image.*')) {
                                                        reader.onload = (function(theFile) {
                                                            return function(e) {
                                                                // Insertamos la imagen
                                                                var img = document.createElement('img');
                                                                img.src = e.target.result;
                                                                img.width = 200; // Tamaño de la imagen
                                                                img.style.display = "none"; // Ocultamos la imagen
                                                                document.getElementById("list").appendChild(img);
                                                        };
                                                            })(f);
                                                        }
                                                        // Lectura del archivo
                                                        reader.readAsDataURL(f);
                                                    }
                                                    showImage(currentImageIndex); // Mostramos la primera imagen
                                                }

                                                document.getElementById('file').addEventListener('change', archivo, false);

                                                function showImage(index) {
                                                var images = document.getElementById("list").getElementsByTagName("img");
                                                for (var i = 0; i < images.length; i++) {
                                                    images[i].style.display = "none"; // Ocultamos todas las imágenes
                                                }
                                                images[index].style.display = "block"; // Mostramos la imagen actual
                                            }

                                            function nextImage() {
                                            var images = document.getElementById("list").getElementsByTagName("img");
                                            currentImageIndex = (currentImageIndex + 1) % images.length; // Avanzamos al siguiente índice circularmente
                                                    showImage(currentImageIndex);
                                            }

                                            function prevImage() {
                                                var images = document.getElementById("list").getElementsByTagName("img");
                                                currentImageIndex = (currentImageIndex - 1 + images.length) % images.length; // Retrocedemos al índice anterior circularmente
                                                showImage(currentImageIndex);
                                            }
                                    </script>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div clasS="row">
                                        <div class="col-md-2">
                                            <a href="<?php echo $URL."admin/atencion_cliente/stc";?>" class="btn btn-default btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-success btn-block">Guardar STC</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-default" onclick="prevImage()">Anterior</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-default" onclick="nextImage()">Siguiente</button>
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
<?php include('../../../layout/admin/parte2.php');?>

<script>
    // Obtener los selectores por su ID
    const tipoServicioSelect = document.getElementById('tiposervicio');
    const idEstadoSelect = document.getElementById('idestado');

    // Función para sincronizar los valores cuando cambia "tiposervicio"
    tipoServicioSelect.addEventListener('change', function() {
        if (tipoServicioSelect.value === '3') {
            idEstadoSelect.value = '3';
        }
    });

    // Función para sincronizar los valores cuando cambia "idestado"
    idEstadoSelect.addEventListener('change', function() {
        if (idEstadoSelect.value === '3') {
            tipoServicioSelect.value = '3';
        }
    });
</script>
