<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT ost.*, tipo_servicio.servicio_ost AS nombre_servicio, estado.estadoost AS nombre_estado FROM ost JOIN tipo_servicio ON ost.tipo_servicio = tipo_servicio.id JOIN estado ON ost.estado = estado.id WHERE ost.id = :id_get");

$query->execute( [":id_get" => $id_get]);
$osts = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($osts as $ost){
    $id = $ost['id'];
    $id_ost = $ost['id_ost'];
    $fecha_ingreso = $ost['fecha_ost'];
    $medio_ingreso = $ost['medio_ingreso'];
    $ticket_externo = $ost['ticket_externo'];
    $nombre_servicio = $ost['nombre_servicio'];
    $id_producto = $ost['id_producto'];
    $falla = $ost['falla'];
    $observacion = $ost['observacion'];
    $nombre_cliente = $ost['cliente'];
    $nombre_ciudad = $ost['ciudad'];
    $proyecto = $ost['proyecto'];
    $nombre_estado = $ost['nombre_estado'];
    $persona_contacto = $ost['persona_contacto'];
    $medio_contacto = $ost['email_contacto'];
}

// Nueva consulta para obtener los técnicos
$query_tecnicos = $pdo->prepare("SELECT * FROM tecnicos WHERE estado_general = '1'");
$query_tecnicos->execute();
$tecnicos = $query_tecnicos->fetchAll(PDO::FETCH_ASSOC);



?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tratamiento OST</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header" style="background-color: #00A000; color: #ffffff">
                    Modifique la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit_create.php" method="post">
                        
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">ID OST</label>
                                                <input type="text" name="id_ost" value="<?php echo $id_ost;?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="fecha_ingreso"> Fecha Ingreso</label>
                                                <input type="date" name="fecha_ingreso" value="<?php echo $fecha_ingreso;?>" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">ID Producto</label>
                                                <input type="text" name="id_producto" value="<?php echo $id_producto;?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Ticket Externo</label>
                                                <input type="text" name="ticket_externo" value="<?php echo $ticket_externo;?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Tipo Servicio</label>
                                                <select name="tipo_servicio" id="tipo_servicio" class="form-control" value="<?php echo $tipo_servicio; ?>" required>

                                                    <?php
                                                        $query_servicio = $pdo->prepare('SELECT * FROM tipo_servicio');
                                                        $query_servicio->execute();
                                                        $servicios = $query_servicio->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($servicios as $servicio) {
                                                            $id_servicio = $servicio['id'];
                                                            $nombre_servicio = $servicio['servicio_ost'];
                                                            $selected = ($id_servicio == 4) ? 'selected' : '';
                                                    ?>                                           
                                                        <option value="<?php echo $id_servicio; ?>" <?php echo $selected; ?>><?php echo $nombre_servicio; ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Cliente</label>
                                                <input type="text" name="clientes" value="<?php echo $nombre_cliente;?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Proyecto</label>
                                                <input type="text" name="proyecto" value="<?php echo $proyecto;?>" class="form-control" placeholder="Proyecto" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Ciudad</label>
                                                <input type="text" name="ciudad" value="<?php echo $nombre_ciudad; ?>" id="ciudad" class="form-control" readonly>                                    
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Persona Contacto</label>
                                                <input type="text" name="persona_contacto" value="<?php echo $persona_contacto; ?>" id="clientes" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Medio Contacto</label>
                                                <input type="text" name="email_contacto" value="<?php echo $medio_contacto; ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">                            
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Técnico Tratante</label>
                                                
                                                    <select name="tecnico_tratante" id="tecnico_tratante" class="form-control" required>
                                                        <?php foreach ($tecnicos as $tecnico) { ?>
                                                            <option value="<?php echo $tecnico['id']; ?>"><?php echo $tecnico['nombre']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                            </div>
                                        </div>                            
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Estado</label>
                                                <select name="estado" value="<?php echo $nombre_estado; ?>" id="estado" class="form-control" required>
                                                <?php
                                                    $query_estado = $pdo->prepare('SELECT * FROM estado');
                                                    $query_estado->execute();
                                                    $estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($estados as $estado) {
                                                        $id_estado = $estado['id'];
                                                        $estado = $estado['estadostc'];
                                                        ?>
                                                        <option value="<?php echo $id_estado; ?>"><?php echo $estado; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Falla</label>
                                                <textarea name="falla" id="" cols="30" rows="4" class="form-control" readonly><?php echo $falla;?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Observación</label>
                                                <textarea name="observacion" id="" cols="30" rows="4" class="form-control" required><?php echo $observacion;?></textarea>
                                                <input type="text" name="id_usuario" value="<?php echo $id_get;?>" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="archivo_adjunto">Archivo Adjunto</label>
                                    <br>
                                    <output id="list" style="position: relative; width: 300px; height: 300px; overflow: hidden;"></output>
                                    <input type="file" name="archivo_adjunto[]" id="file" class="form-control-file" multiple>

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
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="<?php echo $URL."admin/atencion_cliente/ost/index_create.php";?>" class="btn btn-default btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-success btn-block">Editar OST</button>
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
